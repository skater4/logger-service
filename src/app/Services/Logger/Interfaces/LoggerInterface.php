<?php

namespace App\Services\Logger\Interfaces;

use App\Models\Log\DTO\LogData;

interface LoggerInterface
{
    /**
     * @param LogData $logData
     * @return void
     */
    public function addLog(LogData $logData): void;

    /**
     * @return array
     */
    public function getLog(): array;

    /**
     * @return void
     */
    public function deleteLog(): void;
}
