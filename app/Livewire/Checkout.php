<?php

namespace App\Livewire;

use App\Mail\OrderPlacedEamil;
use App\Mail\OrderPlacedEmail;
use App\Models\CashOnDelivery;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Services\CartManagementService;
use Livewire\Component;
use Carbon\Carbon;
use Faker\Core\Color;
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
    public $city = '';
    private $cod_list = [];
    public $lst_cod = [];
    public $cities = [];
    public $country = 0;
    public $phone = '';
    public $postal_code = '';
    public $coupon_discount = 0;
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

    private $coupon_id = 0;

    public function mount()
    {
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

        $coupon_detail = Coupon::where('code', $this->coupon)
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

    public function completeOrder()
    {
        $order =  Order::where('id', 15)->first();
        $email_data['order'] = $order;
        $email_data['order_detail'] = OrderDetail::where('order_id', $order->id)->first();

        Mail::to($order->email)->send(new OrderPlacedEmail($email_data));

        // $this->validate($this->completeOrderRules);
        // $order = new Order();
        // $order->order_id = Str::uuid();
        // $order->email = $this->email;
        // $order->first_name = $this->first_name;
        // $order->last_name = $this->last_name;
        // $order->city = $this->city;
        // $order->country = $this->country;
        // $order->postal_code = $this->postal_code;
        // $order->address = $this->address;
        // $order->sub_total = $this->sub_total;
        // $order->free_shipping = $this->is_shipping_free;
        // $order->coupon_id = $this->coupon_id;
        // $order->shipping_charges = $this->shipping_charges;
        // $order->status = 'Placed';
        // $order->save();

        // foreach ($this->cartItems as $key => $cart_item) {
        //     $order_detail = new OrderDetail();
        //     $order_detail->order_id = $order->id;
        //     $color_id =  ProductColor::where('color_name', $cart_item['color'])->first() ? ProductColor::where('color_name', $cart_item['color'])->first()->id : 0;
        //     $order_detail->color_id = $color_id;
        //     $product_id = ProductHead::where('slug', $cart_item['slug'])->first()->id;
        //     $order_detail->product_id = $product_id;
        //     $order_detail->currency = $cart_item['currency'];
        //     $order_detail->quantity = $cart_item['quantity'];
        //     $order_detail->unit_amount = $cart_item['unit_amount'];
        //     $order_detail->total_amount = $cart_item['total_amount'];
        //     $order_detail->save();
        // }
        // $this->order_completed = true;
        // CartManagementService::clearCartItems();
        // $data = ['type' => 'success', 'message' => 'Order Placed successfully'];
        // $this->dispatch('update-cart', data: $data);
        // $this->dispatch('cart-refresh');

        // $email_data['order'] = $order;
        // $email_data['order_detail'] = OrderDetail::where('order_id', $order->id)->first();
        // Mail::to($this->email)->send(new OrderPlacedEmail($email_data));

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
