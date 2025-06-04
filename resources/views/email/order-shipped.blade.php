<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Order Shipped</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="color: #2a2a2a; font-family: Arial, sans-serif; font-size: 14px; margin: 0; padding: 0;">
<div class="mail-wrapper">
<table border="0"  style="border-collapse: collapse; background-color: #ffffff;">
<tr>
<td style="font-weight: 600; font-size: 2.25rem; line-height: 2.5rem;">
    <a style="text-decoration: none;" href="{{ route('home') }}">
        <span style="color:#D19C97;">Every Day</span>
        <span style="color: black;">{{ website()->title }}</span>
    </a>
</td>
</tr>
<tr>
<td style="">
<table width="100%" border="0"  style="border-spacing: 4px !important; border-collapse: separate;">
<tr style="color: #000000; font-size: 24px; font-weight: bold; font-family: Arial, sans-serif;">
<td colspan="2" valign="middle">Your package has been shipped!</td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
@if($cod == 'Leopards')
    <td style="text-align: start;"><b>Track# {{ $track_number }}</b></td>
@endif
    <td style="text-align: end;"><b>ORDER #ED{{ $email_data->order_id }}</b></td>
</tr>

<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td colspan="2" style="text-align: start;">We are pleased to share that the item(s) from your order have been shipped.</td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
@if($cod == 'Leopards')
    <td>
        <a href="https://www.leopardscourier.com/tracking" target="_blank" style="color: #ffffff; background-color:#D19C97; padding: 10px 20px; font-weight: bold;  font-size: 18px; font-family: Arial, sans-serif; text-decoration: none;">Track your order</a>
    </td>
@endif
@if($cod == 'Post_Ex')
    <td>
        <a href="https://postex.pk/tracking?cn={{$track_number}}" target="_blank" style="color: #ffffff; background-color:#D19C97; padding: 10px 20px; font-weight: bold;  font-size: 18px; font-family: Arial, sans-serif; text-decoration: none;">Track your order</a>
    </td>
@endif
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
</table>
<table border="0" style="border-collapse: collapse; background-color: #ffffff;">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr style="color: #000000; font-size: 18px; font-weight: bold; font-family: Arial, sans-serif;">
        <td style="text-align: start;padding: 5px 0px;">Order summary</td>
    </tr>
    @foreach ($email_data->detail as $order_detail)
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: left;">
            <img height="75" width="75" src="{{ asset('/storage/'.$order_detail->product->image) }}" alt="">
        </td>
        <td style="text-align: left;"><b>{{ $order_detail->product->title }} x {{ $order_detail->quantity }}</b></td>
        <td><b> {{ getLocation()->currency }}  {{ number_format( $order_detail->total_amount,2) }}</b></td>
    </tr>
    @endforeach
    <tr>
        <td></td>
        <td style="text-align: left;"> Sub Total</td>
        <td style="text-align: end;">  {{ getLocation()->currency }} {{ number_format($email_data->sub_total,2)  }}</td>
    </tr>
    @if($email_data->coupon_id != 0)
    <tr>
        <td></td>
        <td style="text-align: left;">Discount</td>
        <td style="text-align: end;"> {{ number_format(round($email_data->sub_total / 100 * $email_data->coupon->discount),2) }} ({{ $email_data->coupon->discount }}%)</td>
    </tr>
    @endif
    <tr>
        <td></td>
        <td style="text-align: left;">Delivery</td>
        <td style="text-align: end;">
            @if($email_data->free_shipping == 0)
            {{ number_format($email_data->shipping_charges,2) }}
            @else
            FREE
            @endif
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: left;">Grand Total</td>
        @if($email_data->free_shipping == 0)
            @if($email_data->coupon_id != 0)
            <td style="text-align: end;">{{ number_format(round($email_data->sub_total + $email_data->shipping_charges - ($email_data->sub_total / 100 * $email_data->coupon->discount)) ,2)  }}</td>
            @else
            <td style="text-align: end;">{{ number_format(round($email_data->sub_total + $email_data->shipping_charges) ,2)  }}</td>
            @endif
        @endif
        @if($email_data->free_shipping == 1)
            @if($email_data->coupon_id != 0)
            <td style="text-align: end;">{{ number_format(round($email_data->sub_total - ($email_data->sub_total / 100 * $email_data->coupon->discount)) ,2)  }}</td>
            @else
            <td style="text-align: end;">{{ number_format(round($email_data->sub_total) ,2)  }}</td>
            @endif
        @endif
    </tr>
</table> 
<table border="0" style="border-collapse: collapse; background-color: #ffffff;">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr style="color: #000000; font-size: 18px; font-weight: bold; font-family: Arial, sans-serif;">
        <td style="text-align: start;padding: 5px 0px;">Delivery information</td>
    </tr>
    <tr>
        <td>
            <table>
                <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
                    <td style="text-align: start;  padding: 5px 0px;">{{ $email_data->user->first_name }} {{ $email_data->user->last_name }}</td>
                </tr>
                <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
                    <td style="text-align: start;  padding: 5px 0px;">{{ $email_data->billing_address }}</td>
                </tr>
                <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
                    <td style="text-align: start;  padding: 5px 0px;">{{ $email_data->city->name }}</td>
                </tr>
            </table>
        </td>
    </tr>
   
</table>
<table width="100%" border="0" cellpadding="4" class="agenda-table" align="center" style="border-spacing: 4px !important; border-collapse: separate;">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td>_______________________________________________________</td>
    </tr>
    <td>
        If you have any questions, reply to this email or contact us at <a href="mailto:info@everydayplastic.co">info@everydayplastic.co</a>
    </td>
</table>

 
</div>
</body>
</html>