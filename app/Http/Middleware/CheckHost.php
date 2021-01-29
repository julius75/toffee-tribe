<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckHost
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
        $userRoles = Auth::user()->roles->pluck('name');
        if ($userRoles->contains('host'))
        {
           return $next($request);
        }elseif($userRoles->contains('admin')){
            return redirect('/toffee-admin');
        }
        else{
            return redirect('/member_dashboard');
        }
    }
}
