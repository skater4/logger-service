<?php

namespace App\Services\ApiAuth;

use App\Services\ApiAuth\Interfaces\ApiAuthInterface;
use Illuminate\Http\Request;

class TokenAuth implements ApiAuthInterface
{
    /**
     * @param string $token
     */
    public function __construct(
        private readonly string $token
    ){}

    public function auth(Request $request): bool
    {
        $token = $request->header('X-Access-Token');

        if (empty($token) || $token != $this->token) {
            return false;
        }

        return true;
    }
}
