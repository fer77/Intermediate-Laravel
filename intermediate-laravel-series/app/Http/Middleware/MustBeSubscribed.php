<?php

namespace App\Http\Middleware;

use Closure;

class MustBeSubscribed
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
      $user = $request->user();

      // if user logged in and subscribed.
      if ($user && $user->isSubscribed()) {
        return $next($request);
      }
      return redirect('/');
    }
}
