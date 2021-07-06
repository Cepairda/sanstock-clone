<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}-UA">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Payment</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    @php(header('Access-Control-Allow-Origin: *'))
</head>
<body >
<form id="myForm" action="https://secure.platononline.com/post/" method="post">
    <input type="hidden" name="action" value="{{ $data['action'] }}"/>
    <input type="hidden" name="client_key" value="{{ $data['CLIENT_KEY'] }}"/>
    <input type="hidden" name="order_id" value="{{ $data['order_id'] }}"/>
    <input type="hidden" name="order_amount" value="{{ $data['order_amount'] }}"/>
    <input type="hidden" name="order_currency" value="{{ $data['order_currency'] }}"/>
    <input type="hidden" name="order_description" value="{{ $data['order_description'] }}"/>
    <input type="hidden" name="payment_token" value="{{ $data['payment_token'] }}"/>
    <input type="hidden" name="payer_email" value="{{ $data['payer_email'] }}"/>
    <input type="hidden" name="term_url_3ds" value="{{ $data['term_url_3ds'] }}"/>
    <input type="hidden" name="hash" value="{{ $hash }}"/>
</form>

<script>

    $.ajax({
        url: "https://secure.platononline.com/post/",                                           // url страницы (action_ajax_form.php)
        type:     "POST",                                                                       // метод отправки
        dataType: "html",                                                                       // формат данных
        data: $("#myForm").serialize(),                                                         // Сеарилизуем объект
        success: function(response) {
            console.log('Success');                                                             // Данные отправлены успешно
            console.log(response);
        },
        error: function(response) {                                                             // Данные не отправлены
            console.log('Error');
            console.log(response);
        }
    });



    // let formData = new FormData(document.getElementById("myForm"));
    //
    // fetch("https://secure.platononline.com/post/", {
    //     method: 'POST',
    //     body: formData
    // })
    //     .then(r => r.json())
    //     .then(function (response) {
    //         console.log(response);
    //     });
</script>
</body>
</html>
