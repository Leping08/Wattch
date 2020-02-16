<?php

namespace App\Http\Controllers;

use App\Models\HttpResponse;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function show(HttpResponse $response)
    {
        $this->authorize('view', $response);

        $response->with('page');

        return view('pages.auth.http_responses.show', compact('response'));
    }
}
