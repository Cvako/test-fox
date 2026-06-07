<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
if (\Auth::user()->last_ip != \Request::ip()) {
        \Auth::logout(); // log the user out
        return \Redirect::to(env('ADMIN_LOGIN_URL'))->withErrors(['login_again' => __('admin.login_again')]);
        } else {
        return $next($request);
        }
    }
}
