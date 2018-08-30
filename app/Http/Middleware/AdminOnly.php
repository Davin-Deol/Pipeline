<?php

namespace App\Http\Middleware;

use Closure;
use App\Users as Users;

class AdminOnly
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
        $user = auth()->user();
        
        if (!is_null($user))
        {
            if (($user->type == "admin") || ($user->type == "demo-admin"))
            {
                return $next($request);
            }
        }
        
        return redirect()->route('user-profile');
    }
}
