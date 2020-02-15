<?php

namespace App\Http\Controllers;

use App\Models\HttpResponse;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function show(HttpResponse $response)
    {
        //TODO Make sure they can view it

        //return $response;

        return view('pages.auth.http_responses.show', compact('response'));
    }
}
