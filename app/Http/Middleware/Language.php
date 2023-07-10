<?php

namespace App\Http\Middleware;

use App\Models\Language as ModelsLanguage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $default = ModelsLanguage::whereStatus(2)->first();
        $code = ($default) ? $default->code : 'master';
        $language_code = (auth()->user()->language && auth()->user()->language->code) ? auth()->user()->language->code : $code;
        if ($language_code != null) {
            App::setLocale($language_code);
        }
        return $next($request);
    }
}
