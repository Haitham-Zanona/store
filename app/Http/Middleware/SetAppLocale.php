<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $locale = request('locale', Cookie::get('locale', config('app.locale')));

        $locale = $request->route('locale');
        App::setlocale($locale);
        Cookie::queue('locale', $locale, 60 * 24 * 365);

        URL::defaults([
            'locale'=> $locale,
        ]);
        Route::current()->forgetParameter('locale');

        return $next($request);
    }
}
