<?php

namespace App\Http\Controllers;

use App\AssertionResult;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssertionResultController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->query('start_date') ? Carbon::parse($request->query('start_date')) : Carbon::now()->subDays(7);
        $end_date = $request->query('start_date') ? Carbon::parse($request->query('end_date')) : Carbon::now();

        $assertion_results = AssertionResult::with(['assertion.type', 'assertion.page.website', 'assertion.page.latest_screenshot'])
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15);

        return view('pages.auth.assertion_results.index', compact('assertion_results'));
    }
}
