<?php

namespace App\Http\Controllers;

use App\Models\Assertion;
use Illuminate\Http\Request;

class RunAssertionController extends Controller
{
    public function index(Assertion $assertion)
    {
        $this->authorize('view', $assertion);

        $assertion->execute();

        $result = $assertion->latest_result;

        if ($result->success) {
            session()->flash('success', 'Assertion successful!');
        } else {
            session()->flash('error', 'Assertion failed!');
        }

        return redirect()->route('assertions.show', [$assertion]);
    }
}
