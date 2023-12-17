<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\two_factorController;

class Tow_Factor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

       if(auth()->check() && auth()->user()->Code){

         if(!$request->is('tow_factor*')){
            return redirect()->route('tow_factor.index');
         }

       }


        return $next($request);
    }
}
