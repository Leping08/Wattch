<?php

namespace App\Http\Controllers;

use App\Models\Assertion;
use App\Models\AssertionResult;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssertionController extends Controller
{
    public function index(Request $request)
    {
        $assertions = Assertion::with([
            'page.website', 'page.latest_screenshot', 'type', 'results' => function ($query) {
                $query->orderBy('created_at', 'desc')->whereDate('created_at', '>', Carbon::now()->subDays(30));
            },
        ])
            ->simplePaginate(10)
            ->appends(request()->query());

        return view('pages.auth.assertions.index', compact('assertions'));
    }

    public function show(Assertion $assertion)
    {
        $this->authorize('view', $assertion);

        $results = AssertionResult::where('assertion_id', $assertion->id)->orderBy('created_at', 'desc')->simplePaginate(10);

        $assertion->load([
            'page.website', 'page.latest_screenshot', 'type', 'latest_result', 'results' => function ($query) {
                $query->orderBy('created_at', 'desc')->whereDate('created_at', '>', Carbon::now()->subDays(30));
            },
        ]);

        return view('pages.auth.assertions.show', compact('assertion', 'results'));
    }
}
