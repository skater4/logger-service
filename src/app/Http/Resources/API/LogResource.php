<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->resource->id,
            'created_at'  => $this->resource->created_at,
            'client'      => $this->resource->client,
            'message'     => $this->resource->message,
            'level'       => $this->resource->level,
            'user_id'     => $this->resource->user_id ?? null,
        ];
    }
}
