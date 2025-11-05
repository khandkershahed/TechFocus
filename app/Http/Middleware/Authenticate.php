<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
protected function redirectTo($request)
{
    if ($request->expectsJson()) {
        return null;
    }

    // Determine guard from route
    $guards = func_get_args();
    
    if (in_array('principal', $guards)) {
        return route('principal.login');
    }

    if (in_array('admin', $guards)) {
        return route('admin.login');
    }

    return route('login'); // default user login
}


}
