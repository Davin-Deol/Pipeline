<?php

namespace App\Http\Middleware;

use Closure;
use App\Users as Users;
use Symfony\Component\HttpFoundation\Cookie as Cookie;

class UsersOnly
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
        $userId = $request->session()->get('userId');
        $password = $request->session()->get('password');
        
        $user = Users::find($userId);
        
        if (!is_null($user))
        {
            if (password_verify($password, $user->password))
            {
                return $next($request);
            }
        }
        
        return redirect()->route('guest-home');
    }
}
