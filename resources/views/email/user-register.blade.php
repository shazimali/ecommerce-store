<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Welcome to Every Day {{ website()->title }}</title>
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
<td colspan="2" valign="middle">Hi, {{ $first_name }}</td>
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
<tr style="color: #000000; font-size: 24px; font-weight: bold; font-family: Arial, sans-serif;">
<td colspan="2" valign="middle">Welcome to our platform!</td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td colspan="2" style="text-align: start;">We are excited to have you as a new member of our community. You can now access all the features and services our platform has to offer.</td>
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
        <td style="text-align: start;padding: 5px 0px;">Login Detail</td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: left;"><b>Email:</b></td>
        <td style="text-align: end;"> {{ $email }}</td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align: left;"><b>Password:</b></td>
        <td style="text-align: end;"> {{ $password }}</td>
    </tr>
     <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td style="text-align: left;">
            Thank you for joining us!
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