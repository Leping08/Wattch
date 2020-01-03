<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    public function index()
    {
        return view('pages.public.sign_up');
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'product_id' => ['required', 'exists:products,id'],
            'payment_method_id' => ['required']
        ]);

        /* @var $product Product **/
        $product = Product::find($validData['product_id']);

        /* @var $user User **/
        $user = User::create([
            'name' => $validData['name'],
            'email' => $validData['email'],
            'password' => Hash::make($validData['password']),
        ]);

        $user->createAsStripeCustomer();

        $user->updateDefaultPaymentMethod($validData['payment_method_id']);

        $user->newSubscription('prod_Fv1J8aRpNDvdBE', 'plan_GRx3SdLW2s8eCW')->create($user->defaultPaymentMethod()->paymentMethod);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
