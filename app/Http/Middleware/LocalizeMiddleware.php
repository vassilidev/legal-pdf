<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocalizeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale') ?? config('app.fallback_locale');

        app()->setLocale($locale);

        return $next($request);
    }
}
