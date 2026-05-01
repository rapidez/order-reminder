<?php

namespace Rapidez\OrderReminder\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rapidez\Core\Models\Customer;

class OrderReminderAuthMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        // If email doesn't belong to an existing customer, allow the request
        if (!Customer::firstWhere('email', $request->email)) {
            return $next($request);
        }

        // If email belongs to the authenticated customer, allow the request
        if (Auth::guard('magento-customer')->user()?->email === $request->email) {
            return $next($request);
        }

        // Otherwise, abort with 403
        abort(403);
    }
}