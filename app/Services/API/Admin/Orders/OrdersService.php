<?php

namespace App\Services\API\Admin\Orders;

use App\Http\Requests\API\Admin\Orders\BookOrderRequest;
use App\Http\Requests\API\Admin\Orders\BookedOrderStatusRequest;
use App\Http\Resources\API\Admin\Orders\OrderCODListResource;
use App\Http\Resources\API\Admin\Orders\OrdersListResource;
use App\Interfaces\API\Admin\Orders\OrdersInterface;
use App\Models\CashOnDelivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Type\Integer;

class OrdersService implements OrdersInterface
{
    public function getAll(Request $request)
    {
        $order = Order::with('coupon', 'user')->orderBy('created_at', 'DESC')->paginate($request->itemPerPage);
        if ($order) {
            return OrdersListResource::collection($order);
        } else {
            return response()->json(['message' => 'Order Not exist'], 200);
        }
    }

    public function getAllCODs()
    {
        $cods = CashOnDelivery::activeOrDefault()->get();
        if ($cods) {
            return OrderCODListResource::collection($cods);
        } else {
            return response()->json(['message' => 'COD not found'], 200);
        }
    }

    public function bookOrder(BookOrderRequest $request)
    {
        try {
            $order = Order::where('order_id', $request->order_id)->first();
            if($request->cod_company == 'Leopards'){
                $order->status = 'IN_TRANSIT';
                $order->track_number = $request->track_number;
                $order->cod_id = CashOnDelivery::where('title',$request->cod_company)->first()->id;
                $order->save();
            }
            if($request->cod_company == 'Post_Ex'){
                $order->status = 'IN_TRANSIT';
                $order->track_number = $request->track_number;
                $order->cod_id = CashOnDelivery::where('title',$request->cod_company)->first()->id;
                $order->save();
            }
            // if ($request->cod_company == 'Leopards') {
            //     $cod_company = CashOnDelivery::where('title', 'Leopards')->first();
            //     $data = [
            //         'api_key' => $cod_company->api_key,
            //         'api_password' => $cod_company->api_password,
            //         'booked_packet_weight' => $request->weight,
            //         'booked_packet_collect_amount' => $order->total,
            //         'booked_packet_order_id' => 'ED#' . $order->order_id,
            //         'booked_packet_no_piece' => $request->piece,
            //         'origin_city' => 'self',
            //         'destination_city' => $order->city_id,
            //         'shipment_id' => getSettingVal('leopards_cod_shipper_id'),
            //         'shipment_name_eng' => 'self',
            //         'shipment_email' => 'self',
            //         'shipment_phone' => 'self',
            //         'shipment_address' => 'self',
            //         'consignment_name_eng' => $order->user->name,
            //         'consignment_email' => $order->user->email,
            //         'consignment_phone' => $order->phone,
            //         'consignment_address' => $order->address,
            //         'special_instructions' => !empty($request->special_instruction) ? $request->special_instruction : 'N/A'
            //     ];
            //     $response = Http::post($cod_company->api_url . 'bookPacket/format/json/', $data);

            //     $res_data = $response->json();
            //     if ($res_data['status'] == 1) {
            //         $order->weight = $request->weight;
            //         $order->piece = $request->piece;
            //         $order->special_instructions = !empty($request->special_instruction) ? $request->special_instruction : 'N/A';
            //         $order->track_number = $res_data['track_number'];
            //         $order->slip_link = $res_data['slip_link'];
            //         $order->status = 'IN_TRANSIT';
            //         $order->save();
            //     } else {
            //         return response()->json(['message' => 'COD response =>' . $res_data['error']], 401);
            //     }
            // }
            // if ($request->cod_company == 'Post_Ex') {
            // }

            return response()->json(['message' => 'Order Booked Successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 201);
        }
    }

    public function bookedOrderStatus(BookedOrderStatusRequest $request){
        
        $order = Order::where('order_id',$request->order_id)->first();
        $order->status = $request->status;
        $order->save();
        return response()->json(['message' => 'Order Status Updated Successfully.'], 200);
   
    }
    public function deleteOrder(int $id)
    {
        Order::where('order_id', $id)->delete();
        return response()->json(['message' => 'Order Deleted Successfully.'], 200);
    }
}
