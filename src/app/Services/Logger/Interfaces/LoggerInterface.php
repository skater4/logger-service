<?php

namespace App\Services\Logger\Interfaces;

interface LoggerInterface
{
    /**
     * @param array $data
     * @return void
     */
    public function addLog(array $data): void;

    /**
     * @return array
     */
    public function getLog(): array;

    /**
     * @return void
     */
    public function deleteLog(): void;
}
