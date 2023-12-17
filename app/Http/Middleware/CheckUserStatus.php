<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            
        if(auth()->user()->Status == "غير مفعل") {
            session()->flash('login','عفوا انت غير مغعل للدخول');
            return redirect('http://localhost/Bills/public/');
        }
        
        return $next($request);
    }
}
