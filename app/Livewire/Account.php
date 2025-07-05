<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Account extends Component
{
    use WithFileUploads;
    public $profile_image;

    public $email = '';
    public $first_name = '';
    public $last_name = '';
    public $address = '';
    public $billing_address = '';
    public $city = '';
    public $cities = [];
    public $country = '';
    public $country_id = 0;
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    #[Validate('required')]

    protected $formRules = [
        'first_name'          => 'required|string|max:500',
        'last_name'           => 'required|string|max:500',
        'address'             => 'required',
        'profile_image'       => 'nullable|image|max:500',
        'billing_address'     => 'required',
        'city'             => 'required',
        'country'             => 'required',
        'phone'               => 'required|numeric',
        'password'            => 'nullable|min:8|confirmed',
        'password_confirmation' => 'required_if:password,!=,null'
    ];

    protected $messages = [
        'city_id.required' => 'The Country field is required.',
    ];

    public function mount()
    {
        $this->cities = City::get();
        $this->country = auth()->user()->country_id ? auth()->user()->country->name : getLocation()->name;
        $this->country_id = auth()->user()->country_id ? auth()->user()->country_id : getLocation()->id;
        $this->first_name = auth()->user()->first_name;
        $this->last_name = auth()->user()->last_name;
        $this->address = auth()->user()->address;
        $this->billing_address = auth()->user()->billing_address;
        $this->city = auth()->user()->city;
        $this->phone = auth()->user()->phone;
    }
    public function updateAccount()
    {
        $this->validate($this->formRules);

        $user = User::where('email', auth()->user()->email)->first();
        if ($this->password != '') {
            $user->update([
                'first_name'          => $this->first_name,
                'last_name'           => $this->last_name,
                'address'             => $this->address,
                'billing_address'     => $this->billing_address,
                'city'                => $this->city,
                'country_id'          => $this->country_id,
                'phone'               => $this->phone,
                'password'            => $this->password,
                'profile_image'       => $this->profile_image ? $this->profile_image->storeAs('/', 'profile_image' . now(), $disk = 'public') : '',
            ]);
        } else {
            $user->update([
                'first_name'          => $this->first_name,
                'last_name'           => $this->last_name,
                'address'             => $this->address,
                'billing_address'     => $this->billing_address,
                'city'                => $this->city,
                'country_id'          => $this->country_id,
                'profile_image'       => $this->profile_image ? $this->profile_image->storeAs('/', 'profile_image_' . now(), $disk = 'public')  : '',
                'phone'               => $this->phone
            ]);
        }

        return back()->with('success', 'Account detail updated successfully.');
    }
    public function render()
    {
        return view('livewire.account');
    }
}
