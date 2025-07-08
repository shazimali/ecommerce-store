<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Reset Password</title>
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
<td colspan="2" valign="middle">Hello!</td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td colspan="2" style="text-align: start;">You are receiving this email because we received a password reset request for your account.</td>
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
    <td >
        <a href="{{ url($resetUrl) }}" style="color: #ffffff; background-color:#D19C97; padding: 10px 20px; font-weight: bold;  font-size: 18px; font-family: Arial, sans-serif; text-decoration: none;">Reset Password</a>
    </td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td colspan="2" style="text-align: start;">This password reset link will expire in 60 minutes.</td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td colspan="2" style="text-align: start;">If you did not request a password reset, no further action is required.</td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td colspan="2" style="text-align: start;">Regards,</td>
</tr>
<tr style="color: #000000; font-size: 16px; font-family: Arial, sans-serif;">
    <td colspan="2" style="text-align: start;">Every Day {{ website()->title }}</td>
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
        If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
        <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
    </td>
</table>

 
</div>
</body>
</html>