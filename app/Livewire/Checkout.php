<?php

namespace App\Livewire;

use App\Events\AdminNotification;
use App\Events\NewNotification;
use App\Mail\OrderPlacedEmail;
use App\Mail\UserRegisterEmail;
use App\Models\CashOnDelivery;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\ShipmentAddress;
use App\Models\User;
use App\Services\CartManagementService;
use Livewire\Component;
use Carbon\Carbon;
use Faker\Core\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;

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
    public $cities = [];
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
        }
        $this->cities = City::get();
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

    public function completeOrder()
    {
        $this->validate($this->completeOrderRules);
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $password = rand(10, 10000);
            $user = User::create([
                'email' => $this->email,
                'name' => $this->first_name . ' ' . $this->last_name,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'country' => getLocation()->id,
                'type' => 'CUSTOMER',
                'city_id' => $this->city_id,
                'phone' => $this->phone,
                'address' => $this->address,
                'billing_address' => $this->same_for_billing_address ?  $this->address : $this->billing_address,
                'password' => $password,
            ]);

            Mail::mailer('noreply')
                ->to($this->email)
                ->bcc(env('OWNER_EMAIL_ADDRESS'))
                ->send(new UserRegisterEmail($this->email, $this->first_name, $password));
        }
        //placing order
        $order = Order::create([
            'user_id' => $user->id,
            'order_id' => Order::get()->count() > 0 ? Order::latest()->first()->order_id + 1 : 1,
            'order_status' => 'PLACED',
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'shipping_charges' => $this->shipping_charges,
            'free_shipping' => $this->is_shipping_free,
            'coupon_id' => $this->coupon_id,
            'address' => $this->address,
            'billing_address' => $this->same_for_billing_address ?  $this->address : $this->billing_address,
            'country_id' => getLocation()->id,
            'city_id' => $this->city_id,
            'phone' => $this->phone
        ]);


        //storing order detail
        foreach ($this->cartItems as $key => $cart_item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'color_id' =>  ProductColor::where('color_name', $cart_item['color'])->first() ? ProductColor::where('color_name', $cart_item['color'])->first()->id : 0,
                'product_id' => ProductHead::where('slug', $cart_item['slug'])->first()->id,
                'currency' => $cart_item['currency'],
                'quantity' => $cart_item['quantity'],
                'unit_amount' => round($cart_item['unit_amount']),
                'total_amount' => round($cart_item['total_amount']),
            ]);
        }

        //storing shipment address
        // $shipment = ShipmentAddress::create([
        //     'user_id' => $user->id,
        //     'country_id' => getLocation()->id,
        //     'city_id' => $this->city_id,
        //     'address' => $this->address,
        //     'postal_code' => $this->postal_code,
        //     'phone' => $this->phone
        // ]);

        $email_data['order'] = Order::where('id', $order->id)->first();
        $email_data['order_detail'] = OrderDetail::where('order_id', $order->id)->get();
        $email_data['user_detail'] = $user;
        $email_data['coupon_discount_amount'] = $email_data['order']->sub_total / 100 * $this->coupon_discount;
        $email_data['coupon_discount'] = $this->coupon_discount;

        Mail::mailer('noreply')
            ->to($this->email)
            ->bcc(env('OWNER_EMAIL_ADDRESS'))
            ->send(new OrderPlacedEmail($email_data));

        $this->order_completed = true;
        event(new AdminNotification('You have a new order' . 'ED#' . $order->id));
        CartManagementService::clearCartItems();
        $data = ['type' => 'success', 'message' => 'Order Placed successfully'];
        $this->dispatch('update-cart', data: $data);
        $this->dispatch('cart-refresh');
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
