<?php

namespace App\Interfaces\API\Admin\Auth;

use App\Http\Requests\API\Admin\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\Admin\Auth\TokenRequest;
use App\Livewire\ForgotPassword;

interface AuthInterface
{
    public function getAuthToken(TokenRequest $request);
    public function forgotPassword(ForgotPasswordRequest $request);
    public function logOut(int $id);
    public function getNotifications();
}
