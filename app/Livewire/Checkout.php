<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Coupon;
use App\Services\CartManagementService;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class Checkout extends Component
{
    public $cartItems = [];
    public $sub_total = 0;
    public $order_completed = false;
    public $total = 0;
    public $shipping_charges = 0;
    public $is_shipping_free = false;
    public $email = '';
    public $first_name = '';
    public $last_name = '';
    public $address = '';
    public $same_for_billing_address = false;
    public $billing_address = '';
    public $city_id = '';
    public $lst_cod = [];
    public $country = 0;
    public $phone = '';
    public $postal_code = '';
    public $coupon_discount = 0;
    public $coupon_id = 0;
    #[Validate('required')]
    public $coupon = '';

    protected $completeOrderRules = [
        'email'               => 'required|email|email:rfc,dns',
        'first_name'          => 'required|string|max:500',
        'last_name'           => 'required|string|max:500',
        'address'             => 'required',
        'billing_address'     => 'required_if:same_for_billing_address,false',
        'city_id'             => 'required',
        'country'             => 'required',
        'phone'               => 'required|numeric',
        'postal_code'         => 'nullable'
    ];

    protected $messages = [
        'city_id.required' => 'The Country field is required.',
    ];


    public function mount()
    {
        if (Auth::check()) {
            $this->email = auth()->user()->email;
            $this->first_name = auth()->user()->first_name;
            $this->last_name = auth()->user()->last_name;
            $this->address = auth()->user()->address;
            $this->phone = auth()->user()->phone;
            $this->billing_address = auth()->user()->billing_address;
            $this->city_id =  auth()->user()->city ? City::where('name', auth()->user()->city)->first()->id : null;
            $this->country = auth()->user()->country;
            $this->country = auth()->user()->country;
        }
        $this->cartItems = CartManagementService::getCartItemsFromCookies();
        $this->sub_total = CartManagementService::calculateGrandTotal($this->cartItems);
        $this->shipping_charges = getSettingVal('shipping_charges');
        $this->country = getLocation()->name;
        $this->is_shipping_free = CartManagementService::calculateGrandTotal($this->cartItems) > getSettingVal('free_shipping') ? true : false;
        if ($this->is_shipping_free) {
            $this->total =  $this->coupon_discount == 0 ?  $this->sub_total : round($this->sub_total -  ($this->sub_total / 100 * $this->coupon_discount));
        } else {
            $this->total =  $this->coupon_discount == 0 ?  $this->sub_total + $this->shipping_charges : round(($this->sub_total + $this->shipping_charges) - ($this->sub_total / 100 * $this->coupon_discount));
        }
    }

    public function applyCouponDiscount()
    {

        $this->validateOnly($this->coupon);

        $coupon_detail = Coupon::active()->where('code', $this->coupon)
            ->where('country_id', getLocation()->id)
            ->whereDate('date_to', '>=', Carbon::today()->toDateString())
            ->first();

        if ($coupon_detail) {
            $this->coupon_discount = $coupon_detail->discount;
            $this->coupon_id = $coupon_detail->id;
            if ($this->is_shipping_free) {
                $this->total =  $this->coupon_discount == 0 ?  $this->sub_total : round($this->sub_total - ($this->sub_total / 100 * $this->coupon_discount));
            } else {
                $this->total =  $this->coupon_discount == 0 ?  $this->sub_total + $this->shipping_charges : round($this->sub_total + $this->shipping_charges - ($this->sub_total / 100 * $this->coupon_discount));
            }
            session()->flash('success', 'Congratulations you got ' . $this->coupon_discount . '% discount.');
        } else {
            session()->flash('error', 'coupon not found!');
        }
    }

    // public function updateBillingAddressFlag()
    // {
    //     $this->same_for_billing_address = !$this->same_for_billing_address;
    // }

    public function completeOrder(\App\Services\CheckoutService $checkoutService)
    {
        $this->validate($this->completeOrderRules);

        $validatedData = [
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'city_id' => $this->city_id,
            'resolved_billing_address' => $this->same_for_billing_address ?  $this->address : $this->billing_address,
        ];
        // try {
            $checkoutService->processCheckout(
                $validatedData,
                $this->cartItems,
                $this->sub_total,
                $this->total,
                $this->shipping_charges,
                $this->is_shipping_free,
                $this->coupon_id,
                $this->coupon_discount
            );

            $this->order_completed = true;
            $data = ['type' => 'success', 'message' => 'Order Placed successfully'];
            $this->dispatch('update-cart', data: $data);
            $this->dispatch('cart-refresh');
        // } catch (\Exception $e) {
        //     // Log error or handle it. For now, maybe flash error?
        //     session()->flash('error', 'Something went wrong. Please try again.');
        // }
    }

    public function render()
    {
        return view('livewire.checkout', [
            'cities' => City::get()
        ]);
    }
}
