<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserLocale
{
    /**
     * Handle an incoming request and set user locale if specified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Set default locale as fallback
        $locale = config('app.locale');

        // Check if user is authenticated
        if (!Auth::check()) {
            return $next($request); // Proceed with default locale if not authenticated
        }

        // Retrieve user locale
        $userLocale = Auth::user()->locale;

        // Verify if user locale is set and valid
        if (empty($userLocale) || !$this->isValidLocale($userLocale)) {
            return $next($request); // Proceed with default locale if user's locale is invalid or not set
        }

        // Apply the valid user locale
        app()->setLocale($userLocale);

        return $next($request);
    }

    /**
     * Validate if the given locale exists in the language directory.
     *
     * @param  string  $locale
     * @return bool
     */
    protected function isValidLocale($locale)
    {
        return is_dir(app()->langPath() . '/' . $locale);
    }
}
