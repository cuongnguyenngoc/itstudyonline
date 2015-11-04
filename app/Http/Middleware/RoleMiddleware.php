<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class RoleMiddleware
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
        $response = $next($request);

        $sendToHomeUser = $request->user()->role;
        $sendToHome =  "you dont know me";
        if(!$request->user()->hasRole($role)){
            return redirect('test');
        }
        Session::flash('message', $sendToHome);
        Session::flash('user', $sendToHomeUser);

        if($request->user()->role->role_name = 'admin'){
            return redirect('test');
        }

        return $response;
    }
}
