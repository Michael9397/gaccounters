<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminLinks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Gate::allows('viewAdmin')) {
            Inertia::share('admin_links', [
                '/admin/dashboard'=> 'Dashboard',
                '/admin/battles' => 'Battles',
                '/admin/characters' => 'Characters',
                '/admin/creators' => 'Content Creators',
                '/admin/videos' => 'Videos', //Not sure if this will stay a first class citizen
                '/admin/teams' => 'Teams',
            ]);
        }

        return $next($request);
    }
}
