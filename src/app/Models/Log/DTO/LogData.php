<?php

namespace App\Models\Log\DTO;

use Spatie\LaravelData\Data;

class LogData extends Data
{
    public string $id;
    public string $created_at;
    public string $client;
    public string $message;
    public string $level;
    public ?string $user_id = null;


    /**
     * @return string[]
     */
    public static function headers(): array
    {
        return [
            'id',
            'created_at',
            'client',
            'message',
            'level',
            'user_id',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        foreach (self::headers() as $header) {
            $data []= $this->$header;
        }

        return $data;
    }
}
