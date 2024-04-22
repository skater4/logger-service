<?php

namespace App\Services\Logger;

use App\Models\Log\DTO\LogData;
use App\Services\Logger\Interfaces\LoggerInterface;
use Carbon\Carbon;

class CsvLogger implements LoggerInterface
{
    private string $csvFile;
    private string $csvDir;

    private const CSV_FILE_NAME = 'log.csv';
    private const CSV_DIR = 'csv';

    public function __construct()
    {
        $this->csvDir = public_path() . '/' . self::CSV_DIR;
        $this->csvFile = $this->csvDir . '/' . self::CSV_FILE_NAME;
    }

    /**
     * @param LogData $logData
     * @return void
     */
    public function addLog(LogData $logData): void
    {
        if (!is_dir($this->csvDir)) {
            mkdir($this->csvDir, 0644, true);
        }

        $fileHandle = fopen($this->csvFile, 'a');
        if (!file_exists($this->csvFile)) {
            fputcsv($fileHandle, LogData::headers());
        }

        $logData->id = uniqid();
        $logData->created_at = Carbon::now()->toDateTimeString();
        fputcsv($fileHandle, $logData->toArray());

        fclose($fileHandle);
    }

    /**
     * @return array
     */
    public function getLog(): array
    {
        if (!file_exists($this->csvFile)) {
            return [];
        }

        $fileHandle = fopen($this->csvFile, 'r');
        $headers = fgetcsv($fileHandle);
        $logs = [];
        while ($row = fgetcsv($fileHandle)) {
            $row = array_pad($row, count($headers), null);
            $row = array_combine($headers, $row);
            $logs []= LogData::from($row);
        }
        fclose($fileHandle);

        return $logs;
    }

    /**
     * @return void
     */
    public function deleteLog(): void
    {
        if (file_exists($this->csvFile)) {
            unlink($this->csvFile);
        }
    }
}
