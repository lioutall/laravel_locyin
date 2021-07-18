<?php

namespace App\Http\Middleware;

use Closure;

class ChangeLocale
{
    public function handle($request, Closure $next)
    {
        $language = $request->header('AcceptLanguage');
        if ($language) {
            \App::setLocale($language);
        }

        return $next($request);
    }
}
