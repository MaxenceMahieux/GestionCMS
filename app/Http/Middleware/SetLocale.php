<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    public function handle($request, Closure $next)
    {


            if (session('locale') !== null) {
                App::setLocale(Session::get('locale'));
            } else {
                App::setLocale(Config::get('app.locale'));
            }

        return $next($request);
    }
}