<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\Traits\APIResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    use APIResponse;
   
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()->role != $role) {
            return $this->error(403, "unauthorized", []);
        }
        return $next($request);
    }
}
