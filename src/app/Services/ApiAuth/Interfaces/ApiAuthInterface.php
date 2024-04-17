<?php

namespace App\Services\ApiAuth\Interfaces;

use Illuminate\Http\Request;

interface ApiAuthInterface
{
    public function auth(Request $request): bool;
}
