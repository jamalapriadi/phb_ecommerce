<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** 
         * ketika sudah login, maka tidak bisa mengakses halaman tertentu
         * atau di redirect ke halaman home
         */
        if(auth()->guard('customer')->check()){
            return redirect()->route('home');
        }
        
        return $next($request);
    }
}
