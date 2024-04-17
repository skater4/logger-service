<?php

namespace App\Repositories;

use App\Http\Requests\LogRequest;
use App\Models\Log\Log;
use App\Repositories\Base\BaseRepository;

class LogRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Log::class;
    }

    /**
     * @param LogRequest $request
     * @return void
     */
    public function saveLogFromApiRequest(LogRequest $request): void
    {
        $this->model->create([
            'client' => $request->get('client'),
            'message' => $request->get('message'),
            'level' => $request->get('level'),
            'user_id' => $request->get('user_id') ?? null,
        ]);
    }
}
