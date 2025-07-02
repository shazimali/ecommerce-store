<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $doRegisterRules = [
        'name'               => 'required|string',
        'email'               => 'required|email|unique:users,email',
        'password'            => 'required|min:8|confirmed',
        'password_confirmation'            => 'required',
    ];

    public function doRegister()
    {
        $this->validate($this->doRegisterRules);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'type' => 'CUSTOMER'
        ]);

        Auth::login($user, remember: true);
        return redirect()->route('dashboard');

        // return redirect()->route('login')->with('success', 'congratulations you are successfully registered please proceed to login.');
    }


    public function render()
    {
        return view('livewire.register');
    }
}
