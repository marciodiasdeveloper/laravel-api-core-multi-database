<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;

class CheckDomainMain
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
        if (request()->getHost() !== config('tenant.domain_main')) {
            abort(401, 'Acesso não permitido!');
        }

        return $next($request);
    }
}
