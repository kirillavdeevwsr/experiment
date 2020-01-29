<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;

class checkAdmin
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
        $roles = Role::where('short_name', 'admin')->get();
        $user = auth()->user();
        if($user->roles->contains('short_name',$roles->first()->short_name))
            return $next($request);
        return redirect()->back()->withErrors('Доступ запрещен!');
    }
}
