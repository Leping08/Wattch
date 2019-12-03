<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsAccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.auth.settings.account.index', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($request->email && ($request->email != $user->email)) { //If the email has changed
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],  //Check for unique email
            ]);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ])->save();

        session()->flash('success', 'Account Updated');
        return redirect()->route('settings.account.index');
    }
}
