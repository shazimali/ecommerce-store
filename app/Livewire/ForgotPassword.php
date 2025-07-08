<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email = '';

    protected $validationRules = [
        'email'               => 'required|email',
    ];

    public function submit()
    {
        $this->validate($this->validationRules);

        $status = Password::sendResetLink(
            ['email' => $this->email]
        );

        return $status === Password::ResetLinkSent
            ? session()->flash('success', __($status))
            : session()->flash('error', __($status));
    }
    public function render()
    {
        return view('livewire.forgot-password');
    }
}
