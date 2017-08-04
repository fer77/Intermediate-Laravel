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
     * @param   string   $plan
     * @return mixed
     */
    public function handle($request, Closure $next, $plan = null)
    {
      $user = $request->user();

      if ($user && $user->subscribed($plan)) {
        return $next($request);
      }
        return redirect('/');
    }
}
