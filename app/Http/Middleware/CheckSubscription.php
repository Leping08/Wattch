<?php

namespace App\Http\Middleware;

use Closure;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //TODO: Get this middlewhere working
//        if ($request->user() && ! $request->user()->subscribedToPlan('monthly', 'main')) {
//            // This user is not a paying customer...
//            return redirect(route('settings.billing.index'));
//        }

        return $next($request);
    }
}
