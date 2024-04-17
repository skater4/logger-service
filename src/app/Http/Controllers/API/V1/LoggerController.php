<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\API\CheckJsonIsValid;
use App\Http\Requests\LogRequest;
use App\Http\Resources\API\LogResource;
use App\Services\Logger\Interfaces\LoggerInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LoggerController extends Controller
{
    public function __construct()
    {
        $this->middleware(CheckJsonIsValid::class)
            ->only('add');
    }

    /**
     * New entry
     *
     * @param LogRequest $request
     * @param LoggerInterface $logger
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function add(LogRequest $request, LoggerInterface $logger): Application|ResponseFactory|JsonResponse|Response
    {
        try {
            $logger->addLog($request->validated());
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Error saving log',
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['message' => 'Log created successfully'], ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param LoggerInterface $logger
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function get(LoggerInterface $logger): JsonResponse|AnonymousResourceCollection
    {
        try {
            return LogResource::collection($logger->getLog());
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Error obtaining log',
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
