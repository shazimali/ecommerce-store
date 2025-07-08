<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Illuminate\Support\Str;

class ResetPassword extends Component
{
    public $email = '';
    public $token = '';
    public $password = '';
    public $password_confirmation = '';

    protected $validationRules = [
        'password' => 'required|min:8|confirmed'
    ];

    public function mount($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function submit()
    {
        $this->validate($this->validationRules);
        $status = Password::reset(
            [
                "email" => $this->email,
                "password" => $this->password,
                "password_confirmation" => $this->password_confirmation,
                "token" => $this->token
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('success', __($status))
            : session()->flash('error', __($status));
    }

    public function render()
    {
        return view('livewire.reset-password');
    }
}
