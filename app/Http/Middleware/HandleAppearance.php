<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class HandleAppearance
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $forceDark = $this->isAdminPanelRequest($request);

        View::share('appearance', $request->cookie('appearance') ?? 'system');
        View::share('forceDark', $forceDark);

        return $next($request);
    }

    private function isAdminPanelRequest(Request $request): bool
    {
        if ($request->is('dashboard')) {
            return true;
        }

        if ($request->is('core') || $request->is('core/*')) {
            return true;
        }

        if ($request->is('settings') || $request->is('settings/*')) {
            return true;
        }

        return false;
    }
}
