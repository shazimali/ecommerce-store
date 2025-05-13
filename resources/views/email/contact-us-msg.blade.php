<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Send</title>
</head>

<body>

    <h3>Hello, Admin</h3>
    <p>First Name: {{ $request['first_name'] }} </p>
    <p>Last Name: {{ $request['last_name'] }} </p>
    <p>Email Address: {{ $request['email_address'] }} </p>
    <p>Email Address Confirmation: {{ $request['email_address_confirmation'] }} </p>
    <p>Contact Number: {{ $request['contact_number'] }} </p>
    <p>Type: {{ $request['type'] }} </p>
    <p>Product Code: {{ $request['product_code'] }} </p>
    <p>Subject: {{ $request['subject'] }} </p>
    <p>Message: {{ $request['message'] }} </p>
</body>

</html>
