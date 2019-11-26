<?php

namespace App\Http\Controllers;

use App\Assertion;
use Illuminate\Http\Request;

class AssertionController extends Controller
{
    public function show(Assertion $assertion)
    {
        $this->authorize('view', $assertion);

        return $assertion;
    }
}
