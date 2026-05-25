<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('customer.login')
                ->with('error', 'অনুগ্রহ করে প্রথমে লগইন করুন।');
        }

        $user = auth()->user();

        if (!$user->hasRole('customer')) {
            abort(403, 'Customer অ্যাক্সেস প্রয়োজন।');
        }

        if (!$user->information()->exists()) {
            if (!$request->routeIs('customer.information.*') && !$request->routeIs('customer.logout')) {
                return redirect()->route('customer.information.create')
                    ->with('warning', 'ড্যাশবোর্ড অ্যাক্সেস করার আগে অনুগ্রহ করে আপনার প্রয়োজনীয় তথ্য এবং ডকুমেন্ট প্রদান করুন।');
            }
        }

        return $next($request);
    }
}
