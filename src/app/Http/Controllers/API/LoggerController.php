<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogRequest;
use App\Repositories\LogRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LoggerController extends Controller
{
    /**
     * New entry
     *
     * @param LogRequest $request
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function add(LogRequest $request): Application|ResponseFactory|JsonResponse|Response
    {
        try {
            resolve(LogRepository::class)->saveLogFromApiRequest($request);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'error' => $e->getMessage(),
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['message' => 'Log created successfully'], ResponseAlias::HTTP_CREATED);
    }
}
