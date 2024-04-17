<?php

namespace App\Models\Log\Enum;

enum LogFields: string
{
    case Id = 'id';
    case CreatedAt = 'created_at';
    case Client = 'client';
    case Message = 'message';
    case Level = 'level';
    case UserId = 'user_id';
}
