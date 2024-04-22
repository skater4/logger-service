<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\API\CheckJsonIsValid;
use App\Http\Requests\LogRequest;
use App\Http\Resources\API\LogResource;
use App\Models\Log\DTO\LogData;
use App\Services\Logger\Interfaces\LoggerInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LogsController extends Controller
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private readonly LoggerInterface $logger)
    {
        $this->middleware(CheckJsonIsValid::class)
            ->only('store');
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(): JsonResponse|AnonymousResourceCollection
    {
        try {
            return LogResource::collection($this->logger->getLog());
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Error obtaining log',
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * New entry
     *
     * @param LogRequest $request
     * @return ResponseFactory|JsonResponse|Response
     */
    public function store(LogRequest $request): ResponseFactory|JsonResponse|Response
    {
        try {
            $logData = LogData::from($request->validated());
            $this->logger->addLog($logData);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Error saving log',
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['message' => 'Log created successfully'], ResponseAlias::HTTP_CREATED);
    }
}
