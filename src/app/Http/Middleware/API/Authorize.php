<?php

namespace App\Http\Middleware\API;

use App\Services\ApiAuth\Interfaces\ApiAuthInterface;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Application|ResponseFactory|Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Application|ResponseFactory|Response|RedirectResponse|JsonResponse
    {
        if (!resolve(ApiAuthInterface::class)->auth($request)) {
            return response('', ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
