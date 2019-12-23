<?php

namespace App\Http\Controllers;

use App\Assertion;
use App\AssertionResult;
use App\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $websites_count = Website::all()->count();
        $assertions_count = Assertion::all()->count();
        $latest_results = AssertionResult::with(['assertion.type', 'assertion.page.website'])
                                            ->orderBy('created_at', 'desc')
                                            ->limit(5)
                                            ->get();

        $latest_assertions = Assertion::with(['page.latest_screenshot', 'type', 'results'])
                                            ->orderBy('created_at', 'desc')
                                            ->limit(5)
                                            ->get();

        $assertions_results = AssertionResult::orderBy('created_at', 'desc')->whereDate('created_at', '>', Carbon::now()->subDays(30))->get();

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

        return view('pages.auth.dashboard', compact('websites_count', 'latest_results', 'latest_assertions', 'assertions_count', 'assertions_success_by_day', 'assertions_fails_by_day'));
    }
}
