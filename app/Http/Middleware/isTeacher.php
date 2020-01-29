<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;

class isTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = Role::where('short_name', 'teacher')->first();
        $roleAdmin = Role::where('short_name', 'admin')->first();
        if(auth()->user()->roles->contains($roleAdmin->id))
            return $next($request);
        else if(auth()->user()->roles->contains($role->id))
            return $next($request);
        return redirect()->back()->withErrors('Доступ к разделу сайта запрещен!');
    }
}
