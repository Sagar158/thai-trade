<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if($request->is('admin')){
            return $next($request);
        }
        if (auth()->check() && auth()->user()->is_admin) {
            // dd('check');
            return $next($request);
        }

        // If user is not an admin, you can redirect them or return a response
        abort(403, 'please contact the admistrator');
        return redirect('/admin')->with('error', 'You are not authorized to access this page.');
    }
}