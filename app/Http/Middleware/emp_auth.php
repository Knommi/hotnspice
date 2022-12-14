<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class emp_auth
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
        if(!session()->has('emp_logid')){
            return redirect('signin_emp');
        }

        return $next($request);
    }
}
