<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}-UA">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Payment</title>
</head>
<body onload="javascript:document.forms[0].submit()">
<form action="https://secure.platononline.com/post/" method="post">
    <input type="hidden" name="action" value="{{ $data['action'] }}" />
    <input type="hidden" name="client_key" value="{{ $data['CLIENT_KEY'] }}" />
    <input type="hidden" name="order_id" value="{{ $data['order_id'] }}" />
    <input type="hidden" name="order_amount" value="{{ $data['order_amount'] }}" />
    <input type="hidden" name="order_currency" value="{{ $data['order_currency'] }}" />
    <input type="hidden" name="order_description" value="{{ $data['order_description'] }}" />
    <input type="hidden" name="payment_token" value="{{ $data['payment_token'] }}" />
    <input type="hidden" name="payer_email" value="{{ $data['payer_email'] }}" />
    <input type="hidden" name="term_url_3ds" value="{{ $data['term_url_3ds'] }}" />
    <input type="hidden" name="hash" value="{{ $hash }}" />
</form>
</body>
</html>
