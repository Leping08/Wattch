<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use Illuminate\Http\Request;

class ScreenshotController extends Controller
{
    public function show(Screenshot $screenshot)
    {
        $this->authorize('view', $screenshot);

        return view('pages.auth.screenshots.show', compact('screenshot'));
    }
}
