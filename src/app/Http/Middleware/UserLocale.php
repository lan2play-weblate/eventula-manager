<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Session;
use App;
use Config;
use App\Setting;



class UserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Log::info("UserLocale middleware called");
        // Set the locale from the site settings as default
        $locale = Setting::getSiteLocale();
        \Log::info("Locale set from Site: " . $locale);
        // Check if the user is authenticated before attempting to access user-specific settings
        if (Auth::check()) {
            $userLocale = Auth::user()->locale;
            \Log::info("Locale set from User: " . $userLocale);
            // Override with the user's preference if it's set
            if ($userLocale) {
                $locale = $userLocale;
                \Log::info("Language of the user: " . $locale);
            }
        } else {
            \Log::info("No authenticated user.");
        }
        // Override with the user's preference if authenticated
        if (Auth::check() && Auth::user()->language) {
            $locale = Auth::user()->language;
            \Log::info("Language of the user: " . $locale);
        }

        $locale_dirs = array_filter(glob(app()->langPath() . '/*'), 'is_dir');
        if (in_array(app()->langPath() . '/' . $locale, $locale_dirs)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
