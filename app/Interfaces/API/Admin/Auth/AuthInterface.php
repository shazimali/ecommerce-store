<?php

namespace App\Interfaces\API\Admin\Auth;

use App\Http\Requests\API\Admin\Auth\TokenRequest;

interface AuthInterface
{
    public function getAuthToken(TokenRequest $request);
    public function logOut(int $id);
}
