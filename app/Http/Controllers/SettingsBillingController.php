<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsBillingController extends Controller
{
    public function index()
    {
        return view('pages.auth.settings.billing.index');
    }

    public function post(Request $request)
    {
        return $request->all();
    }
}
