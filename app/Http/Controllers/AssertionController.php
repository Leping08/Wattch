<?php

namespace App\Http\Controllers;

use App\Assertion;
use Illuminate\Http\Request;

class AssertionController extends Controller
{
    public function index()
    {
        $assertions = Assertion::with('page.website', 'page.latest_screenshot', 'type', 'latest_result')->get();

        //return $assertions;

        return view('pages.auth.assertions.index', compact('assertions'));
    }

    public function show(Assertion $assertion)
    {
        $this->authorize('view', $assertion);

        return $assertion;
    }
}
