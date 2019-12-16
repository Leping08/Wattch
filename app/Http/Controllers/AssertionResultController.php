<?php

namespace App\Http\Controllers;

use App\AssertionResult;
use App\Page;
use App\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssertionResultController extends Controller
{
    public function index(Request $request)
    {
        $validData = collect($request->validate([
            'website_id' => 'numeric',
            'page_id' => 'numeric',
            'status_id' => 'numeric',
            'start_date' => 'date',
            'end_date' => 'date'
        ]));

        $statuses = collect([
            [
                'id' => 0,
                'name' => 'All'
            ],
            [
                'id' => 1,
                'name' => 'Successful'
            ],
            [
                'id' => 2,
                'name' => 'Failed'
            ]
        ]);

        $website = $validData->has('website_id') ? Website::find($validData->get('website_id')) : null;
        $page = $validData->has('page_id') ? Page::find($validData->get('page_id')) : null;
        $status = $validData->has('status_id') ? $statuses->filter(function ($value, $key) use ($validData) {
            return $value['id'] == $validData->get('status_id');
        })->first() : null;
        $status = collect($status);
        $start_date = $validData->has('start_date') ? Carbon::parse($validData->get('start_date')) : Carbon::now()->subDays(30);
        $end_date = $validData->has('end_date') ? Carbon::parse($validData->get('end_date')) : Carbon::now();

        $assertion_results = AssertionResult::with(['assertion.type', 'assertion.page.latest_screenshot', 'assertion.page.website'])
                                    ->whereHas('assertion.page.website', function ($query) use ($website) {
                                        $website ? $query->where('id', '=', $website->id) : $query;
                                    })
                                    ->whereHas('assertion.page', function ($query) use ($page) {
                                        $page ? $query->where('id', '=', $page->id) : $query;
                                    })
                                    ->where(function ($query) use ($status) {
                                        if ($status->get('name') == 'Successful') {
                                            return $query->where('success', '=', true);
                                        } elseif ($status->get('name') == 'Failed') {
                                            return $query->where('success', '=', false);
                                        } else {
                                            return $query;
                                        }
                                    })
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15)
                                    ->appends(request()->query());

        //This is used to populate the filter dropdowns
        $websites = Website::all();
        $pages = $website ? $website->pages : Page::all();

        return view('pages.auth.results.index', compact('assertion_results', 'websites', 'pages', 'statuses'));
    }


    public function show(AssertionResult $result)
    {
        $this->authorize('view', $result);

        $result->load(['assertion.type', 'assertion.page.website', 'assertion.page.latest_screenshot']);

        return view('pages.auth.results.show', compact('result'));
    }
}
