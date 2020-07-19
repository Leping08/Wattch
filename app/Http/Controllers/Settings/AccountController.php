<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Product;
use App\Models\User;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        //Put this on the user model for reuse
        $user = User::find(Auth::id())->with(['subscription' => function ($query) {
            $query->where('stripe_status', '=', 'active')->with('plan');
        }])->get()->first();

        $products = Product::with('plans')->get();

        return view('pages.auth.settings.account.index', compact('user', 'products'));
    }

    public function store(Request $request)
    {
        //Validate the email is unique on the users table
        if ($request->email && ($request->email != $request->user()->email)) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],  //Check for unique email
            ]);
        }

        //Validate the user data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'plan_id' => ['required', 'integer', 'exists:plans,id'],
        ]);

        //Save the new user data
        $request->user()->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ])->save();

        //Handel Product changes
        $user = $request->user();

        //Handel Plan changes
        if (!($user->active_plan()->id === $request['plan_id'])) {  //The user changed plans
            //Update stripe product
            $newPlan = Plan::find($request['plan_id']);
            // This changes the plan
            $currentSubscription = $user->subscriptions()->active()->get()->first();
            $currentSubscription->swap($newPlan->stripe_plan);
            //TODO: Still need to change the product
            session()->flash('success', 'Product Changed!');
        }

        session()->flash('success', 'Account updated!');
        return redirect()->route('settings.account.index');
    }
}
