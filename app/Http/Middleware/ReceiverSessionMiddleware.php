<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReceiverSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->isReceiver()) {
            $receiver = $request->user()->receiver;

            if ($receiver && $receiver->isExpired()) {
                auth()->logout();
                return redirect('/login')->with('error', 'আপনার অস্থায়ী অ্যাকাউন্ট মেয়াদ শেষ হয়েছে');
            }

            if ($receiver && $receiver->expires_at) {
                $minutesLeft = $receiver->expires_at->diffInMinutes(now());
                session(['receiver_expires_at' => $receiver->expires_at, 'minutes_left' => $minutesLeft]);
            }
        }

        return $next($request);
    }
}