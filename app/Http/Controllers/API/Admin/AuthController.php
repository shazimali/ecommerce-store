<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\Admin\Auth\TokenRequest;
use App\Services\API\Admin\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function token(TokenRequest $request)
    {
        return $this->authService->getAuthToken($request);
    }

    public function logout(int $id)
    {
        return $this->authService->logOut($id);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

        return $this->authService->forgotPassword($request);
    }
}
