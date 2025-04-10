<?php

namespace App\Livewire;

use App\Services\CartManagementService;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;

class Checkout extends Component
{
    public $cartItems = [];
    public $sub_total = 0;
    public $shipping_charges = 0;
    public $is_shipping_free = false;
    public $email = '';
    public $first_name = '';
    public $last_name = '';
    public $address = '';
    public $city = '';
    public $cities = [];
    public $country = 0;
    public $phone = '';
    public $postal_code = '';
    #[Validate('required')]
    public $coupon = '';

    protected $completeOrderRules = [
        'email'               => 'required|email',
        'first_name'          => 'required|string|max:500',
        'last_name'           => 'required|string|max:500',
        'address'             => 'required',
        'city'                => 'required',
        'country'             => 'required',
        'phone'               => 'required|numeric',
        'postal_code'         => 'nullable'
    ];

    public $coupon_discount = 0;

    public function mount()
    {
        $response = Http::get(env('COD_API') . 'getAllCities/format/json/', [
            'api_key' => env('COD_API_KEY'),
            'api_password' => env('COD_API_PASSWORD')
        ]);

        $res_data = $response->json();
        $this->cities = $res_data['city_list'];
        $this->cartItems = CartManagementService::getCartItemsFromCookies();
        $this->sub_total = CartManagementService::calculateGrandTotal($this->cartItems);
        $this->shipping_charges = getSettingVal('shipping_charges');
        $this->country = getLocation()->name;
        $this->is_shipping_free = CartManagementService::calculateGrandTotal($this->cartItems) > getSettingVal('free_shipping') ? true : false;
    }

    public function applyCouponDiscount()
    {

        // $this->validateOnly($this->coupon);

        // $coupon_detail = Coupon::where('value', $this->coupon)->whereDate('end_date', '>=', Carbon::today()->toDateString())->first();
        // if ($coupon_detail) {
        //     $this->coupon_discount = $coupon_detail->discount;
        //     session()->flash('success', 'Congratulations you got ' . $this->coupon_discount . '% discount.');
        // } else {
        //     session()->flash('error', 'coupon not found!');
        // }
    }

    public function completeOrder()
    {
        $this->validate($this->completeOrderRules);

        // $response = Http::get('https://merchantapistaging.leopardscourier.com/api/bookPacket/format/json/', [
        //     'api_key' => '',
        //     'api_password' => '',
        //     'booked_packet_weight' => '2000',
        //     'booked_packet_no_piece' => 

        // ]);

        // $res_data = $response->json();
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
