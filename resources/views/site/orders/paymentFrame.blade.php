<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}-UA">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Payment</title>
    </head>
    <body onload="javascript:document.forms[0].submit()">
        <form action="https://secure.platononline.com/payment/auth" method="post">
            <input type="hidden" name="payment" value="{{ $payment }}" />
            <input type="hidden" name="key" value="{{ $key }}" />
            <input type="hidden" name="url" value="{{ $url }}" />
            <input type="hidden" name="data" value="{{ $data }}" />
            <input type="hidden" name="req_token" value="{{ $req_token }}" />
            <input type="hidden" name="sign" value="{{ $sign }}" />
        </form>
    </body>
</html>
