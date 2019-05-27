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
        if(
            (Auth::user()->role == 'admin' ||
            Auth::user()->role == 'teacher'||
            Auth::user()->role == 'student') &&
            Auth::user()->deleted_at==null)
            return  $next($request);
        if(Auth::user()->deleted_at!=null) {
            return new Response(view('access_denied',['message'=>'Ваш профиль был удален']));
        }

        return new Response(view('access_denied',['message'=>'Только подтвержденные пользователи имеют доступ к этой странице']));

    }
}
