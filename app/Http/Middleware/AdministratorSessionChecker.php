<?php

namespace App\Http\Middleware;

use Closure;

class AdministratorSessionChecker
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
        if(session()->has('administrator_id')) {
        } else {
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
