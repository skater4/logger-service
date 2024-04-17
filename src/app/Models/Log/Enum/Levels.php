<?php

namespace App\Models\Log\Enum;

enum Levels: string
{
    case Warning = 'warning';
    case Info = 'info';
    case Error = 'error';
}
