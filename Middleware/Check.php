<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('id_user') == null) {
            // dd($request->session()->get('name'));
            return redirect('/');
        }
        return $next($request);
    }
}
