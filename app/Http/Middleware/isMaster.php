<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Redirect;

class isMaster
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->auth->guest()){
            return redirect('/');
        }else{
            if($this->auth->user()->role->role_name != 'master')
                return Redirect::back()->withErrors(['notice'=> $this->auth->user()->role->role_name.', You dont have permission to access, buddy']);
        }

        return $next($request);
    }
}
