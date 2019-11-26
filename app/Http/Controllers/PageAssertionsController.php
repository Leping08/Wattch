<?php

namespace App\Http\Controllers;

use App\Assertion;
use App\AssertionType;
use App\Page;
use Illuminate\Http\Request;

class PageAssertionsController extends Controller
{
    public function index(Page $page)
    {
        $this->authorize('view', $page);

        $page->load([
            'website',
            'assertions.latest_result',
            'assertions.type',
        ]);

        $types = AssertionType::all();

        return view('pages.auth.page_assertions.index', compact('page', 'types'));
    }

    public function show(Page $page, Assertion $assertion)
    {
        //TODO: Not sure if 2 authorize's are needed here or not
        $this->authorize('view', $assertion);
        $this->authorize('view', $page);
    }
}
