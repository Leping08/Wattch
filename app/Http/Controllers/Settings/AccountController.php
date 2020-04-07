<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = Product::all();
        $currentProduct = $user->product();

        return view('pages.auth.settings.account.index', compact('user', 'products', 'currentProduct'));
    }

    public function store(Request $request)
    {
        if ($request->email && ($request->email != $request->user()->email)) { //If the email has changed
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],  //Check for unique email
            ]);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        $request->user()->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ])->save();

        //TODO Change stripe subscription

        session()->flash('success', 'Account updated!');
        return redirect()->route('settings.account.index');
    }
}
