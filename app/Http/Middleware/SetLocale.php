<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale') ?? $request->segment(1);

        if (in_array($locale, ['fr', 'en', 'de'])) {
            app()->setLocale($locale);
            
            // Set locale for URL generation
            \Illuminate\Support\Facades\URL::defaults(['locale' => $locale]);
        } else {
             // Fallback or default locale
             $defaultLocale = config('app.locale', 'fr');
             app()->setLocale($defaultLocale);
        }

        return $next($request);
    }
}
