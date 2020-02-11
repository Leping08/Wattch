<?php

namespace App\Http\Controllers;

use App\Assertion;
use App\AssertionType;
use App\Page;
use App\Task;
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

    public function store(Request $request)
    {
        $request->validate([
            'page_id' => ['required', 'numeric', 'exists:pages,id'],
            'assertion_type_id' => ['required', 'numeric', 'exists:assertion_types,id']
        ]);

        $page = Page::find($request->page_id);
        $assertion_type = AssertionType::find($request->assertion_type_id);

        $assertion = Assertion::create([
            'assertion_type_id' => $assertion_type->id,
            'page_id' => $page->id,
            'parameters' => [$request->parameters]
        ]);

        Task::create([
            'taskable_type' => Assertion::class,
            'taskable_id' => $assertion->id,
            'frequency' => 'hourly'
        ]);

        session()->flash('success', 'Assertion created');

        return redirect()->route('pages.assertions.index', ['page' => $page]);
    }
}
