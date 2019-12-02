<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsAccountController extends Controller
{
    public function index()
    {
        return view('pages.auth.settings.account.index');
    }

    public function post(Request $request)
    {
        return $request->all();
    }
}
