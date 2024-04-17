<?php

namespace App\Services\Logger;

use App\Models\Log\Enum\LogFields;
use App\Services\Logger\Interfaces\LoggerInterface;
use Cache;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\LockTimeoutException;

class CsvLogger implements LoggerInterface
{
    private string $idFile;
    private string $csvFile;

    private const CSV_FILE_NAME = 'log.csv';
    private const ID_FILE_NAME = 'id.csv';

    public function __construct(
        private readonly string $csvDir
    )
    {
        $this->idFile = $this->csvDir . '/' . self::ID_FILE_NAME;
        $this->csvFile = $this->csvDir . '/' . self::CSV_FILE_NAME;
    }

    /**
     * @param array $data
     * @return void
     * @throws LockTimeoutException
     */
    public function addLog(array $data): void
    {
        if (!is_dir($this->csvDir)) {
            mkdir($this->csvDir, 0777, true);
        }

        $_data = [];
        foreach (LogFields::cases() as $field) {
            $_data[$field->value] = null;
        }

        $_data[LogFields::Id->value] = $this->getNextId();
        $_data[LogFields::CreatedAt->value] = Carbon::now()->toDateTimeString();

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $_data)) {
                $_data[$key] = $value;
            }
        }

        $needHeader = !file_exists($this->csvFile);
        $fileHandle = fopen($this->csvFile, 'a');
        if ($needHeader) {
            fputcsv($fileHandle, array_column(LogFields::cases(), 'value'));
        }

        fputcsv($fileHandle, $_data);
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
            $logs[] = array_combine($headers, $row);
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

    /**
     * @return int
     * @throws LockTimeoutException
     */
    private function getNextId(): int
    {
        $lock = Cache::lock('getNextId', 10);

        if ($lock->block(5)) {
            try {
                $lastId = file_exists($this->idFile) ? (int) file_get_contents($this->idFile) : 0;
                $nextId = $lastId + 1;
                file_put_contents($this->idFile, $nextId);
            } finally {
                optional($lock)->release();
            }
        } else {
            throw new LockTimeoutException("Could not obtain lock for getNextId");
        }

        return $nextId;
    }
}
