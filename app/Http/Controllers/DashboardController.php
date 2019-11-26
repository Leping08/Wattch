<?php

namespace App\Http\Controllers;

use App\Page;
use App\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $websites = Website::withCount('assertions')->get();
        $websites_count = $websites->count();
        $assertions_count = $websites->sum('assertions_count');
        $pages = Page::with('website')->has('website')->get();
        $latest_assertions = Website::with(['assertions.results' => function($query) {
                                    $query->with('assertion.type')->orderBy('created_at', 'desc')->limit(25);
                                }])
                                ->get()
                                ->pluck('assertions')
                                ->flatten()
                                ->pluck('results')
                                ->flatten();

        $assertions_results = Website::with(['assertions.results' => function($query) {
                                    $query->orderBy('created_at', 'desc')->whereDate('created_at', '>', Carbon::now()->subDays(30));
                                }])
                                ->get()
                                ->pluck('assertions')
                                ->flatten()
                                ->pluck('results')
                                ->flatten();

        $assertions_success_by_day = $assertions_results->groupBy(function ($item) {
                                    return Carbon::parse($item->created_at)->format('m-d-Y') . ' GMT';
                                })
                                ->map(function ($item) {
                                    return $item->where('success', true)->count();
                                });

        $assertions_fails_by_day = $assertions_results->groupBy(function ($item) {
                                    return Carbon::parse($item->created_at)->format('m-d-Y') . ' GMT';
                                })
                                ->map(function ($item) {
                                    return $item->where('success', false)->count();
                                });

        return view('pages.auth.dashboard', compact('websites_count', 'pages', 'assertions_count', 'latest_assertions', 'assertions_success_by_day', 'assertions_fails_by_day'));
    }
}
