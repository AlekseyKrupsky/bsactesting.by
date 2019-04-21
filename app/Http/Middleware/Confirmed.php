<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class Confirmed
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
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'teacher'|| Auth::user()->role == 'student')
            return  $next($request);
//        return view('access_denied'); //redirect('/login');
        return new Response(view('access_denied',['message'=>'Только подтвержденные пользователи имеют доступ к этой странице']));

    }
}
