<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $doLoginRules = [
        'email'               => 'required|email',
        'password'            => 'required'
    ];

    public function doLogin()
    {
        $this->validate($this->doLoginRules);
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return redirect()->route('dashboard');
        }
        session()->flash('error', 'Invalid email or password!');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
