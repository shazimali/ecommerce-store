<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Order Placed</title>
<script type="application/ld+json">
    {
      "@context": "http://schema.org/",
      "@type": "EmailMessage",
      "sender": {
        "@type": "Person",
        "name": "John Doe",
        "email": "john.doe@example.com"
      },
      "recipient": {
        "@type": "Person",
        "name": "Jane Doe",
        "email": "jane.doe@example.com"
      },
      "subject": "Event Reminder",
      "text": "This is a reminder about the upcoming event.",
      "description": "A short description of the email's content.",
      "event": {
        "@type": "Event",
        "name": "Example Event",
        "startDate": "2025-05-31T18:00:00",
        "endDate": "2025-05-31T20:00:00",
        "location": "Event location",
        "url": "https://example.com/event"
      }
    }
  </script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="color: #2a2a2a; font-family: Arial, sans-serif; font-size: 14px; margin: 0; padding: 0;">
<style>
    body{
        color: #2a2a2a;
                font-family: Arial, sans-serif;
                font-size: 14px;
    }
    .mail-wrapper{
        text-align: center;
        background-color: #dadbdd;
        width: 750px;
        margin: 0 auto;
    }
    .session{
        background: #dadbdd;
                font-family: Arial, sans-serif;
        font-size: 12px !important;
                height: 18px;
    }
    .session-title-label{
        font-weight: bold;
                font-family: Arial, sans-serif;
            }

    .session-speech
    {
        background: #00aeef;
        color: #ffffff;
    }
    .session-keynote
    {
        background: #00aeef;
        color: #ffffff;
    }
    .person-name{
        color: #3754a5;
        font-weight:bold;
        margin-bottom:5px;
    }
    .position{
        font-size:11px;
        margin:5px 0;
    }
    .company{
        margin:5px 0;
        font-weight: bold;
    }
    .person-name,.paper-title,.text-presentation{
                font-family: Arial, sans-serif;
            }
    .position{
                font-family: Arial, sans-serif;
            }
    .company{
                font-size:11px;
        font-family: Arial, sans-serif;
            }
    .paper-title,.text-presentation{
                font-size:11px;
        }
    .paper-title{
        max-width: 250px;
        display: block;
        margin: 0 auto;
    }
    .chair-pill{
        font-weight: bold;
        color: black;
        background: #fce664;
        line-height: 20px;
        border-radius: 5px;
        width: 100%;
    }
    .speakers-pill-wrapper{
        text-align: left;
        max-width: 83px;
    }
    .speakers-pill{
        padding: 0 10px;
        font-weight: bold;
        color: #ffffff;
        background: #414242;
        margin-bottom: 5px;
        line-height: 20px;
        border-radius: 5px;
        width: auto;
        text-align: center;
        display: inline-block;
    }
    .agenda-table{
        border-spacing:4px !important;

        border-collapse:separate;
    }
    .wrapper-table{
        border-collapse:collapse;
    }
    .wrapper-table td{
        text-align: center;
    }
</style>
<div class="mail-wrapper">
<table border="0" align="center" style="border-collapse: collapse; background-color: #ffffff;">
<tr>
<td style="text-align: center;">
    <img src="{{ asset('images/logo.png') }}" style="max-width:  200px; " width="200" alt="Every day logo">
{{-- <img src="{{ asset('/storage/'.website()->logo) }}" style="max-width:  200px; " width="200" alt="Every day logo"> --}}
</td>
</tr>
<tr>
<td style="text-align: center;">
<table width="100%" border="0" cellpadding="4" class="agenda-table" align="center" style="border-spacing: 4px !important; border-collapse: separate;">
<tr style="color: #000000; font-size: 24px; font-weight: bold; font-family: Arial, sans-serif;">
<td colspan="2" valign="middle" style="text-align: center;">Thank you for your order!</td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td style="text-align: start;">Hi {{ $email_data['user_detail']->first_name }} {{ $email_data['user_detail']->last_name }},</td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td colspan="2" style="text-align: start;">Your order <b># {{ $email_data['order']->order_id }}</b> has been placed successfully and we will let you know once your package is on its way.</td>
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
    <td colspan="2" valign="middle" style="text-align: center;">
        <a href="" style="color: #ffffff; background-color:#D19C97; padding: 10px 20px; font-weight: bold;  font-size: 18px; font-family: Arial, sans-serif; text-decoration: none;">Track My Order</a>
    </td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td>_______________________________________________________</td>
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
        <td style="text-align: start;padding: 5px 0px;">Delivery Details</td>
    </tr>
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: start;  padding: 5px 0px;">Name</td>
        <td style="text-align: start;  padding: 5px 0px;">{{ $email_data['user_detail']->first_name }} {{ $email_data['user_detail']->last_name }}</td>
    </tr>
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: start;  padding: 5px 0px;">Address</td>
        <td style="text-align: start;  padding: 5px 0px;">{{ $email_data['shipment']->address }}</td>
    </tr>
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: start;  padding: 5px 0px;">Email</td>
        <td style="text-align: start;  padding: 5px 0px;">{{ $email_data['user_detail']->email }}</td>
    </tr>
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: start;  padding: 5px 0px;">Phone</td>
        <td style="text-align: start;  padding: 5px 0px;">{{ $email_data['shipment']->phone }}</td>
    </tr>
</table>
<table width="100%" border="0" cellpadding="4" class="agenda-table" align="center" style="border-spacing: 4px !important; border-collapse: separate;">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td>_______________________________________________________</td>
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
        <td style="text-align: start;padding: 5px 0px;">Order Details</td>
    </tr>
    @foreach ($email_data['order_detail'] as $order_detail)
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: left;">
            {{-- <img   height="75" width="75" src="https://everydayplastic.co/storage/01JCATBVMN8MP0E4QGBH1KZBW6.png" alt=""> --}}
            <img height="75" width="75" src="{{ asset('/storage/'.$order_detail['product']->image) }}" alt="">
        </td>
        <td style="text-align: left;">
            <table style="font-size: 12px">
                <tr>
                    <td><b>{{ $order_detail['product']->title }}</b></td>
                </tr>
                <tr>
                    <td> {{ getLocation()->currency }} {{ number_format( $order_detail['unit_amount'], 2) }}</td>
                </tr>
                <tr>
                    <td>Color: {{ $order_detail['color'] ? $order_detail['color']->color_name : 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Qty: {{ $order_detail['quantity'] }}</td>
                </tr>
            </table>
        </td>
        <td style="text-align: right;">
            <table style="font-size: 12px">
                <tr>
                    <td><b>{{ number_format( $order_detail['total_amount'],2) }}</b></td>
                </tr>
            </table>
        </td>
    </tr>
    @endforeach
</table>
<table border="0" style="border-collapse: collapse; background-color: #ffffff;">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: start;  padding: 5px 0px;">Sub Total</td>
        <td style="text-align: start;  padding: 5px 0px;">{{ number_format($email_data['order']->sub_total,2)  }}</td>
    </tr>
    @if($email_data['order']->coupon_id != 0)
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: start;  padding: 5px 0px;">Discount</td>
        <td style="text-align: start;  padding: 5px 0px;">- {{ number_format($email_data['coupon_discount_amount'],2) }} ({{ $email_data['coupon_discount'] }}%)</td>
    </tr>
    @endif
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: start;  padding: 5px 0px;">Delivery</td>
        <td style="text-align: start;  padding: 5px 0px;">
            @if($email_data['order']->free_shipping == 0)
            {{ number_format($email_data['order']->shipping_charges,2) }}
            @else
            FREE {{ $email_data['order']->free_shipping }}
            @endif
        </td>
    </tr>
    <tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
        <td style="text-align: start;  padding: 5px 0px;">Grand Total</td>
        <td style="text-align: start;  padding: 5px 0px;">{{ number_format($email_data['order']->sub_total + $email_data['order']->shipping_charges - $email_data['coupon_discount_amount'] ,2)  }}</td>
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
</table>   
</div>
</body>
</html>