<?php

namespace App\Interfaces\API\Admin\Auth;

use App\Http\Requests\API\Admin\Auth\TokenRequest;

interface TokenInterface
{
    public function getAuthToken(TokenRequest $request);
}
