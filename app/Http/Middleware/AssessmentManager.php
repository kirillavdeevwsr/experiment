<?php

namespace App\Http\Middleware;

use App\Models\Assessment\AssessmentList;
use Closure;

class AssessmentManager
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
        $user = auth()->user();
        $assessment = AssessmentList::where('responsible_id', $user->id)->first();
        if(!empty($assessment))
            return $next($request);
        return redirect()->back()->withErrors('Доступ запрещен!');
    }
}
