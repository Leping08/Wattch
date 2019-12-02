<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsNotificationsController extends Controller
{
    public function index()
    {
        return view('pages.auth.settings.notifications.index');
    }

    public function post(Request $request)
    {
        return $request->all();
    }
}
