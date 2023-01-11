<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Tenant\Tenant;
use Closure;
use Illuminate\Http\Request;

use App\Tenant\ManagerTenant;

class TenantMiddleware
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

        $manager = app(ManagerTenant::class);

        if ($manager->domainIsMain())
            return $next($request);

        $tenant = $this->getTenant($request->getHost());

        if (!$tenant && $request !== route('404.tenant')) {
            return redirect()->route('404.tenant');
        } else if ($request !== route('404.tenant') && !$manager->domainIsMain()) {
            $manager->setConnection($tenant);
            $this->setSessionTenant($tenant->only([
                'name', 'uuid'
            ]));
        }

        return $next($request);
    }

    public function getTenant($host)
    {
        return Tenant::where('domain', $host)->first();
    }

    public function setSessionTenant($tenant)
    {
        session()->put('tenant', $tenant);
    }
}
