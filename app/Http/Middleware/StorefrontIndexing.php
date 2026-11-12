<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StorefrontIndexing
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if (config('reyana.preview') || ! config('reyana.indexable') || ! app()->environment('production') || $request->is('admin/*', 'dashboard', 'bookings*', 'profile', 'login', 'register', 'forgot-password', 'reset-password/*', 'cart', 'checkout', 'order-confirmation', 'wishlist', 'account', 'search') || $request->hasAny(['q', 'size', 'color', 'min', 'max', 'sort', 'available'])) {
            $response->headers->set('X-Robots-Tag', 'noindex, follow');
        }

        return $response;
    }
}
