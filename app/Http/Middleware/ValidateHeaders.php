<?php

namespace App\Http\Middleware;

use Closure;

class ValidateHeaders
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
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader != 'application/json') {
          return response()->json(['success' => false, 'message' => 'This request only returns a json content response, please verify your headers'], 400);
        }

        return $next($request);
    }
}
