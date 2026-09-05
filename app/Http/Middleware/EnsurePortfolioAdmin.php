<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePortfolioAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('portfolio_admin')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
