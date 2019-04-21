<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Response;

class Teachers
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
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'teacher') return  $next($request);
        return new Response(view(
            'access_denied',
            ['message'=>'К этой странице имеют доступ только преподаватели или администратор']
        ));

    }
}
