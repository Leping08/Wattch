<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BillingController extends Controller
{
    public function index()
    {
        /* @var $user User */
        $user = Auth::user();
        $invoices = $user->invoicesIncludingPending();

        $paymentMethods = collect();
        if ($user->hasPaymentMethod()) {
            foreach ($user->paymentMethods() as $paymentMethod) {
                $paymentMethods->push($paymentMethod->asStripePaymentMethod());
            }
        }

        $intent = $user->createSetupIntent();
        $stripePubKey = env('STRIPE_KEY');

        return view('pages.auth.settings.billing.index', compact('intent', 'stripePubKey', 'user', 'paymentMethods', 'invoices'));
    }

    public function store(Request $request)
    {
        $request->user()->updateDefaultPaymentMethodFromStripe($request->user()->payment_method_id);

        //TODO add flash message
        return Redirect::back();
    }
}
