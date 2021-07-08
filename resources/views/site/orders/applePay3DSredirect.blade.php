<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}-UA">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bank 3DS</title>
</head>
<body onload="javascript:document.forms[0].submit()">
<form id="myForm" action="{{ $redirect_url }}" method="post">
    <input type="hidden" name="PaReq" value="{{ $data['PaReq'] }}"/>
    <input type="hidden" name="TermUrl" value="{{ $data['TermUrl'] }}"/>
    <input type="hidden" name="MD" value="{{ $data['MD'] }}"/>
</form>

</body>
</html>
