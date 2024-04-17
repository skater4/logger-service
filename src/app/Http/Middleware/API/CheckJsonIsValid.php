<?php

namespace App\Http\Middleware\API;

use Closure;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CheckJsonIsValid
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        json_decode($request->getContent());

        if (json_last_error() != JSON_ERROR_NONE) {
            return response([
                'error' => 'Bad JSON received'
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
