<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if($request->user() === null){
          return response("<h1 class='text-center'>คุณไม่ได้รับสิทธิ์ให้เข้าหน้านี้</h1>", 401);
        }
        $actions = $request->route()->getAction();
        $roles = isset( $actions['roles']) ? $actions['roles'] : null;

        if( $request->user()->hasAnyRole($roles) || !$roles ){
          return $next($request);
        }

        return response("<h1 class='text-center'>คุณไม่ได้รับสิทธิ์ให้เข้าหน้านี้</h1>", 401);
    }
}
