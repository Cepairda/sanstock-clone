<?php

namespace App\Http\Controllers\Site;

use App\OrderProduct;
use App\Orders;
use App\OrderShipping;
use App\PaymentOrder;
use App\Product;
use App\Regions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CartController
{

    private $order_sum = 0;

    const BANK_CARD = 'bank_card';

    const GOOGLE_PAY = 'google_pay';

    const APPLE_PAY = 'apple_pay';

    public $is_employee = 0;

    private $telegramMessage = true;

    // private $mode = 'TEST';
    private $mode = 'ENVIRONMENT';

    function __construct() {

        $this->is_employee = (isset($_COOKIE["access"])) ? 1 : 0;
    }

    /**
     * Получение данных о товарах в корзине
     */
    public function getCartProducts(): array
    {
        $orderProducts = (isset($_COOKIE["products_cart"])) ? json_decode($_COOKIE["products_cart"], true) : [];

        $sku = array_keys($orderProducts);

        $products = Product::joinLocalization()->whereIn('details->sku', $sku)->get()->keyBy('sku');

        // получаем товары из базы и формируем данные для отображения корзины
        foreach($products as $product):

            $orderItem = [];

            $orderItem['sku'] = $product->getDetails('sku');

            $orderItem["sdCode"] = $product->getDetails('sd_code');

            $orderItem['name'] = $product->name;

            $orderItem['quantity'] = $orderProducts[$product->getDetails('sku')];

            $orderItem['price'] = $product->productSort->price;

            $this->order_sum += $orderItem['price'];

            $orderItem['grade'] = $product->getDetails('grade');

            $orderItem['defective_attributes'] = $product->data['defective_attributes'];

            $orderItem['max_quantity'] = 1;

            $orderProducts[$product->getDetails('sku')] = $orderItem;

        endforeach;

        return $orderProducts;
    }

    public function getCartProductsTable() {
        $orderProducts = $this->getCartProducts();
        $order_sum = $this->order_sum;
        return response()->json(
            [
                'body' => view('site.orders.components.modal', compact('orderProducts','order_sum'))->render()
            ]
        );
    }

    /**
     * Show cart view
     */
    public function loadCartView() {

        $np = new \App\Http\Controllers\Admin\NewPost\NewPostController();

        $areas = $np->getAreas();

        $orderProducts = $this->getCartProducts();

        // возвращаем view с данными о заказанных товарах
        return view('site.orders.cart', [
            'orderProducts' => $orderProducts,
            'areas' => $areas,
            'order_sum' => $this->order_sum,
        ]);
    }

    /**
     * Show checkout view
     * @return Application|Factory|RedirectResponse|View
     */
    public function loadCheckout() {

        if(!isset($_COOKIE["products_cart"])) return redirect()->route('site./');

        // $regions = Regions::get();
        $regions = config('regions');

        return view('site.orders.checkout', [
            'paymentMethods' => $this->paymentMethods(),
            'regions' => $regions,
        ]);
    }

    /**
     * Checkout order
     * @param Request $request
     */
    public function checkout(Request $request) {

        $rules = [
            'new_mail_surname' => 'required',
            'new_mail_name' => 'required',
            'new_mail_patronymic' => 'required',
            'new_mail_phone' => 'required|regex:/^\+38[\s]\(0\d{2}\)[\s]\d{3}[-]\d{2}[-]\d{2}$/',
            // 'new_mail_delivery_type' => 'required',
            // 'new_mail_insurance_sum' => 'required|numeric|min:200',
        ];
        // dd($request->new_post_delivery);
        if(empty($this->is_employee) || (!empty($this->is_employee) && isset($request->new_post_delivery))) {

            $rules['new_mail_delivery_type'] = 'required';

            $rules['new_mail_region'] = 'required|size:36';

            $rules['new_mail_city'] = 'required|size:36';
        }

        $shipping = [];

        $shipping['new_mail_surname'] = $request->new_mail_surname ?? '';

        $shipping['new_mail_name'] = $request->new_mail_name ?? '';

        $shipping['new_mail_patronymic'] = $request->new_mail_patronymic ?? '';

        $shipping['new_mail_phone'] = $request->new_mail_phone ?? '';

        $shipping['new_mail_delivery_type'] = $request->new_mail_delivery_type ?? '';

        $shipping['new_mail_region'] = $request->new_mail_region ?? '';

        $shipping['new_mail_city'] = $request->new_mail_city ?? '';

        $shipping['new_mail_warehouse'] = $request->new_mail_warehouse ?? '';

        $shipping['new_mail_comment'] = $request->new_mail_comment ?? null ;

        $shipping['new_mail_street'] = $request->new_mail_street ?? '' ;

        $shipping['new_mail_house'] = $request->new_mail_house ?? '' ;

        $shipping['new_mail_apartment'] = $request->new_mail_apartment ?? '' ;

        $shipping['new_mail_insurance_sum'] = $request->new_mail_insurance_sum ?? 0 ;

        $shipping['payments_form'] = (isset($request->payments_form)) ? $request->payments_form : 0 ;

        $shipping['employee_region'] = (!empty($this->is_employee) && !empty($request->employee_region) && isset(config('regions')[$request->employee_region]))
            ? config('regions')[$request->employee_region] : '' ;

        if($shipping['new_mail_delivery_type'] === 'storage_storage') {

            $shipping['new_mail_street'] = '';

            $shipping['new_mail_house'] = '';

            $shipping['new_mail_apartment'] = '';

            if(empty($this->is_employee)) $rules['new_mail_warehouse'] = 'required|size:36';

        } else {

            $shipping['new_mail_warehouse'] = '';

            if(empty($this->is_employee)) $rules['new_mail_house'] = 'required';

        }

        $shipping['is_employee'] = $this->is_employee??0;

        $orderData = $this->createDataOrder($shipping);

        $new_post_delivery_employee = (!empty($this->is_employee) && isset($request->new_post_delivery) && $request->new_post_delivery == 'on')
            ? 1 : 0 ;

        $region_employee = (empty($new_post_delivery_employee)) ? $shipping['employee_region'] : '';

        if(!empty($this->is_employee)) {
            $employee = [
                'is_employee' => 1,
                'new_post_delivery' => $new_post_delivery_employee,
                'employee_region' => $region_employee,
                'comments' => $shipping['new_mail_comment'],
            ];
        } else $employee = [
            'comments' => $shipping['new_mail_comment'],
        ];

        $orderProducts = $this->getCartProducts();

        // $orderProducts = (isset($_COOKIE["products_cart"])) ? json_decode($_COOKIE["products_cart"], true) : [];
        if(count($orderProducts) === 0)
            return Redirect::back()->withErrors('Для оформления заказа необходимо выбрать хотя бы один товар!');
        // order
        $newOrder = new Orders;

        $newOrder->status = 0;

        $newOrder->attempts = 0;

        $newOrder->save();

        // shipping details
        $orderShipping = new OrderShipping;

        $orderShipping->order_id = $newOrder->id;

        $orderShipping->areas_ref = $shipping['new_mail_region'];

        $orderShipping->settlement_ref = $shipping['new_mail_city'];

        $orderShipping->street_ref = $shipping['new_mail_street'];

        $orderShipping->house = $shipping['new_mail_house'];

        $orderShipping->apartment = $shipping['new_mail_apartment'];

        $orderShipping->warehouse_ref = $shipping['new_mail_warehouse'] ;

        $orderShipping->first_name = $shipping['new_mail_name'];

        $orderShipping->middle_name = $shipping['new_mail_patronymic'];

        $orderShipping->last_name = $shipping['new_mail_surname'];

        $orderShipping->phone = $shipping['new_mail_phone'];

        $orderShipping->cashless_payment = 0;

        $orderShipping->payments_form = $orderData['payments_form'];

        $orderShipping->cash_sum = 0;

        $orderShipping->company = json_encode([]);

        $orderShipping->insurance_sum = 0;

        $orderShipping->comments = json_encode($employee);

        $orderShipping->save();

        $products = [];

        $orderData['price_sum'] = 0;

        foreach($orderProducts as $product):
            // order products
            $orderProduct = new OrderProduct;

            $orderProduct->order_id = $newOrder->id;

            $orderProduct->product_barcode = $product['sku'];

            $orderProduct->details = json_encode($product);

            $orderProduct->save();

            $products[$product['sku']] = $product['quantity'];

            if($this->mode === 'TEST') $orderData['price_sum'] = "1.00"; // !!! TEST PAYMENT !!!
            else $orderData['price_sum'] += (int)$product['price'];

            Product::where('details->sku', $product['sku'])->update([
                'details->balance' => 0
            ]);

        endforeach;

        if(!empty($orderData['payments_form'])) {

            $this->createOrderPaymentMethodeRecord($newOrder->id, $orderData['payments_form'], 0, $orderData['payments_form']);
        }

        $orderData['order_id'] = $newOrder->id;

        $order = [
            'order' => $products,
            'data' => $orderData,
        ];

        $this->telegramMessage($order, $newOrder->id, "NEW ORDER WITH PAYMENT");

        //Cookie::queue('order', $order, 60);
        session(['order' => $order]);
        // dd(Cookie::get('order'));

        // $this->sentOrderToB2B($order);
        // dd($order);
        if(!empty($shipping['payments_form'])) {

            return Redirect::route('site.payment');
        }

        $this->telegramMessage($order, $newOrder->id, "NEW ORDER WITHOUT PAYMENT");

        return $this->moveToSuccessCheckoutPage($orderData['order_id'], $shipping['payments_form'], false);
    }

    /**
     * Create data order for request
     * @param $data
     * @return array
     */
    public function createDataOrder($data): array
    {
        $result = [];

        $result['new_mail_surname'] = $data['new_mail_surname'];

        $result['new_mail_name'] = $data['new_mail_name'];

        $result['new_mail_patronymic'] = $data['new_mail_patronymic'];

        $result['new_mail_phone'] = $data['new_mail_phone'];

        $result['new_mail_region'] = $data['new_mail_region'];

        $result['new_mail_city'] = $data['new_mail_city'];

        $result['new_mail_comment'] = $data['new_mail_comment'];

        $result['new_mail_delivery_type'] = $data['new_mail_delivery_type'];

        $result['payments_form'] = $data['payments_form'];

//        $result['is_employee'] = $data['is_employee'];
//
//        $result['employee_region'] = $data['employee_region'];

        if($data['new_mail_delivery_type'] === 'storage_storage') {

            $result['new_mail_warehouse'] = $data['new_mail_warehouse'];

        } else {

            $result['new_mail_street'] = $data['new_mail_street'];

            $result['new_mail_house'] = $data['new_mail_house'];

            $result['new_mail_apartment'] = $data['new_mail_apartment'];

        }

        return $result;
    }

    /**
     * Payment page
     * @return RedirectResponse
     */
    public function payment() {

        $order = [];

        if(session()->has('order')) $order = session('order');

        if(!session()->has('order') && !($order = $this->getCookieOrder())) return redirect()->route('site.cart');

        if(empty($order)) Redirect::route('site.order-checkout')->withErrors([
            'error'=>'Для оформления заказа необходимо выбрать хотя бы один товар!']);

        return view('site.orders.payment', [
            'order_id' => $order['data']['order_id'],
            'payment_method' => $order['data']['payments_form'],
            'paymentMethods' => $this->paymentMethods(),
            'order' => base64_encode(json_encode($order)),
            'total' => $order['data']['price_sum'],
            'platonPaymentKey' => config('app.PLATON_GOOGLE_AND_APPLE_PAYMENT_KEY'),
            'googlePayMerchantId' => config('app.GOOGLE_MERCHANT_ID'),
            'googlePayMerchantName' => config('app.GOOGLE_MERCHANT_NAME'),
            'applePayMerchantId' => config('app.APPLE_MERCHANT_ID'),
            'applePayMerchantName' => config('app.APPLE_MERCHANT_NAME'),
            'mode' => $this->mode,
        ]);
    }

    /**
     * Load platon bank card form
     * @return Application|Factory|View
     */
    public function orderPayment() {

        $order = $this->getCookieOrder();

        $order_id = $order['data']['order_id'];

        $this->telegramMessage($order, $order_id, 'PLATON BANK CARD LOAD PAYMENT FORM');

        $amount = number_format($order['data']['price_sum'], 2, '.', '');

        $dataPayment = $this->requestBankCardPayment($order_id, $amount);

        return view('site.orders.paymentFrame',
            $dataPayment
        );
    }

    /**
     * Create request for bank card payment
     * @param $order_id
     * @param $amount
     * @return array
     */
    public function requestBankCardPayment($order_id, $amount): array
    {
        $order = $this->getCookieOrder();

        if($this->mode === 'TEST') $data_description = "Bank card order payment. Order ID: $order_id" ;
        else $data_description = 'ORDER_ID #'  . $order_id;

        $key = config('app.PLATON_PAYMENT_KEY');
        $pass = config('app.PLATON_PAYMENT_PASSWORD');
        $payment = 'CC';
        $data = base64_encode(
            json_encode(
                array(
                    'amount' => $amount,
                    'description' => $data_description ,
                    'currency' => 'UAH',
                    'recurring' => 'Y'
                )
            )
        );

        $req_token = 'Y';
        $url = route('site.check-transaction-status');
        $sign = md5(
            strtoupper(
                strrev($key).
                strrev($payment).
                strrev($data).
                strrev($url).
                strrev($pass)
            )
        );


        if($this->mode === 'TEST') $order['data']['order_id'] = 'TEST BANK CARD PAYMENT -' . $order['data']['order_id'] ;
        else $order['data']['order_id'] = 'ORDER_ID #'  . $order_id;

        $request = [
            'order' => $order['data']['order_id'],
            'payment' => $payment,
            'key' => $key,
            'url' => $url,
            'data' => $data,
            'req_token' => $req_token,
            'sign' => $sign
        ];

        $this->telegramMessage($request, $order_id, "PLATON REQUEST BANK CARD");

        return $request;
    }

    /**
     * Load empty page in frame
     */
    public function frame() {
        return view('site.orders.frame');
    }

    /**
     * Create request for google pay
     * @return array|Application|Factory|View
     */
    public function requestGooglePay()
    {
        $paymentToken = request()->get('paymentToken');

        if(empty($paymentToken)) return redirect()->route('site.cart');

        $paymentToken = base64_decode($paymentToken);

        $order = $this->getCookieOrder();

        $order_id = $order['data']['order_id'];

        $this->telegramMessage($paymentToken, $order_id, 'GOOGLE PAY TOKEN');

        $amount = number_format($order['data']['price_sum'], 2, '.', '');

        $key = config('app.PLATON_GOOGLE_AND_APPLE_PAYMENT_KEY');
        $pass = config('app.PLATON_GOOGLE_AND_APPLE_PAYMENT_PASSWORD');

        if($this->mode === 'TEST') $data_order_id = 'TEST GooglePay-' . $order_id ;
        else $data_order_id = 'ORDER_ID #'  . $order_id;

        $CLIENT_PASS = $pass;
        $data['action'] = 'GOOGLEPAY';
        $data['CLIENT_KEY'] = $key;
        $data['order_id'] = $data_order_id;
        $data['order_amount'] = $amount;
        $data['order_currency'] = 'UAH';
        $data['order_description'] = "Google Pay order payment. Order ID: $order_id";
        $data['payment_token'] = $paymentToken;
        $data['payer_email'] = '';
        $data['term_url_3ds'] = route('site.google-pay-success');
        $hash = md5(
            strtoupper(
                strrev(
                    $data['payer_email']
                ).
                ($CLIENT_PASS).
                strrev(
                    $data['payment_token']
                )
            )
        );
        // info($data);
        $data['client_key'] = $data['CLIENT_KEY'];
        $data['hash'] = $hash;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://secure.platononline.com/post/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Access-Control-Allow-Origin: *'));

        if(!($response = curl_exec($ch)))
        {
            $this->telegramMessage(curl_error($ch), $order_id, 'PLATON GOOGLE PAY CURL REQUEST ERROR');
            $this->telegramMessage($ch, $order_id);

            $this->updatePaymentOrder($order_id, self::GOOGLE_PAY, curl_error($ch), 0);

            return Redirect::route('site.order-checkout')->withErrors([
                'error'=>'Во время инициализации платежа произошла ошибка! Выберите другой способ оплаты или свяжитесь с поддержкой сайта для завершения оформления заказа!']);
        }

        curl_close($ch);

        $responseArr = json_decode($response, true);

        if(isset($responseArr["result"]) && $responseArr["result"] === "REDIRECT" && $responseArr["status"] === "3DS" && $responseArr["hash"] === $hash) {

            $this->telegramMessage($response, $order_id, 'PLATON GET 3DS REDIRECT');

            return view('site.orders.googlePay3DSredirect', [
                'data' => [
                    'PaReq' => $responseArr['redirect_params']['PaReq'],
                    'TermUrl' => $responseArr['redirect_params']['TermUrl'],
                ],
                'redirect_url' => $responseArr['redirect_url']
            ]);
        }
        else {

            $this->telegramMessage($response, $order_id, 'PLATON CURL GOOGLE PAY REQUEST DECLINED');
            // неудачный платеж
            $this->updatePaymentOrder($order_id, self::GOOGLE_PAY, $response, 0);

            return Redirect::route('site.order-checkout')->withErrors([
                'error'=>'Не удалось выполнить транзакцию платежа. Выберите другой способ оплаты или свяжитесь с поддержкой сайта для завершения оформления заказа!']);
        }
    }

    /**
     * If GooglePay order payment success
     * @return RedirectResponse
     */
    public function googlePayTransactionSuccess() {
        // успешный платеж
        $response = ["action" => "SALE", 'result' => 'SUCCESS'];

        $order = $this->getCookieOrder();

        $order_id = $order['data']['order_id'];

        $this->updatePaymentOrder($order_id, self::GOOGLE_PAY, $response);

        $this->telegramMessage($response, $order_id, 'PLATON GOOGLE PAY SALE SUCCESS');

        return $this->moveToSuccessCheckoutPage($order_id, self::GOOGLE_PAY, false);
    }

    /**
     * Apple validation request
     */
    public function applePayValidation() {

        $validation_url = request()->get('u');

        if( "https" == parse_url($validation_url, PHP_URL_SCHEME) && substr( parse_url($validation_url, PHP_URL_HOST), -10 )  == ".apple.com" ){

            $order = $this->getCookieOrder();

            $this->telegramMessage($validation_url, $order['data']['order_id'], "PLATON APPLE PAY CURL REQUEST VALIDATION");

            $cert_path = storage_path('apple_cert/ApplePay.crt.pem');
            $cert_key = storage_path('apple_cert/ApplePay.key.pem');
            $cert_pass = config('app.PRODUCTION_CERTIFICATE_KEY_PASS');

            $data = '{"merchantIdentifier":"'. config('app.APPLE_MERCHANT_ID') .'", "domainName":"' . $_SERVER["HTTP_HOST"] . '", "displayName":"'. config('app.APPLE_MERCHANT_NAME') .'"}';

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $validation_url);
            curl_setopt($ch, CURLOPT_SSLCERT, $cert_path);
            curl_setopt($ch, CURLOPT_SSLKEY, $cert_key);
            curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $cert_pass);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            if(!($response = curl_exec($ch)))
            {
                $this->telegramMessage("Error: ApplePay validation. CURL_ERROR" . curl_error($ch) , $order['data']['order_id'], "PLATON APPLE PAY ERROR CURL REQUEST VALIDATION");

                echo '{"curlError":"' . curl_error($ch) . '"}';
            }

            // close cURL resource, and free up system resources
            curl_close($ch);
            $this->telegramMessage($response , $order['data']['order_id'], "PLATON APPLE PAY VALIDATION CURL SUCCESS");
        } else {
            info('Failed get Apple url:' . $validation_url);
        }
    }

    /**
     * Create request for apple pay
     */
    public function requestApplePayPlaton()
    {
        $paymentToken = request()->get('paymentToken');

        if(empty($paymentToken)) return redirect()->route('site.cart');

        $paymentToken = base64_decode($paymentToken);

        $order = $this->getCookieOrder();

        $order_id = $order['data']['order_id'];

        $this->telegramMessage($paymentToken, $order_id, 'APPLE PAY TOKEN');

        $email = '';

        $key = config('app.PLATON_GOOGLE_AND_APPLE_PAYMENT_KEY');
        $pass = config('app.PLATON_GOOGLE_AND_APPLE_PAYMENT_PASSWORD');

        $amount = number_format($order['data']['price_sum'], 2, '.', '');

        $hash = md5(
            strtoupper(
                strrev($email).
                $pass.
                strrev($paymentToken)
            )
        );

        $ip_address = $_SERVER['REMOTE_ADDR'];

        if($this->mode === 'TEST') $data_order_id = 'TEST ApplePay-' . $order_id ;
        else $data_order_id = 'ORDER_ID #'  . $order_id;

        $data = [
            'action' => 'APPLEPAY',
            'client_key' => $key,
            'order_id' => $data_order_id,
            'order_amount' => $amount,
            'order_currency' => 'UAH',
            'order_description' => "Apple Pay order payment. Order ID: $order_id",
            'payment_token' => $paymentToken,
            'payer_ip' => $ip_address,
            'term_url_3ds' => route('site.apple-pay-success'),
            'hash' => $hash
        ];

        // create a new cURL resource
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://secure.platononline.com/post/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Access-Control-Allow-Origin: *'));

        if(!($response = curl_exec($ch)))
        {
            $this->telegramMessage(curl_error($ch), $order_id, 'PLATON APPLE PAY CURL REQUEST ERROR');
            $this->telegramMessage($ch, $order_id);

            $this->updatePaymentOrder($order_id, self::APPLE_PAY, curl_error($ch), 0);
            return Redirect::route('site.order-checkout')->withErrors([
                'error'=>'Во время инициализации платежа произошла ошибка! Выберите другой способ оплаты или свяжитесь с поддержкой сайта для завершения оформления заказа!']);
        }

        curl_close($ch);

        $responseArr = json_decode($response, true);

        if(isset($responseArr["result"]) && $responseArr["result"] === "REDIRECT" && $responseArr["status"] === "3DS") {

            $this->telegramMessage($response, $order_id, 'PLATON GET 3DS REDIRECT');

            return view('site.orders.applePay3DSredirect', [
                'data' => [
                    'PaReq' => $responseArr['redirect_params']['PaReq'],
                    'TermUrl' => $responseArr['redirect_params']['TermUrl'],
                ],
                'redirect_url' => $responseArr['redirect_url']
            ]);
        }
        else {

            $this->telegramMessage($response, $order_id, 'PLATON CURL APPLE PAY REQUEST DECLINED');
            // неудачный платеж
            $this->updatePaymentOrder($order_id, self::APPLE_PAY, $response, 0);

            return Redirect::route('site.order-checkout')->withErrors([
                'error'=>'Не удалось выполнить транзакцию платежа. Выберите другой способ оплаты или свяжитесь с поддержкой сайта для завершения оформления заказа!']);
        }
    }

    /**
     * If GooglePay order payment success
     * @return RedirectResponse
     */
    public function applePayTransactionSuccess() {
        // успешный платеж
        $response = ["action" => "SALE", 'result' => 'SUCCESS'];

        $order = $this->getCookieOrder();

        $order_id = $order['data']['order_id'];

        $this->updatePaymentOrder($order_id, self::APPLE_PAY, $response);

        $this->telegramMessage($response, $order_id, 'PLATON APPLE PAY SALE SUCCESS');

        return $this->moveToSuccessCheckoutPage($order_id, self::APPLE_PAY, false);
    }

    /**
     * Check transaction status
     */
    public function checkTransactionStatus() {

        return  view('site.orders.checkTransactionStatus', [

        ]);
    }

    /**
     * Redirect to success checkout page
     * @param $order_id
     * @param $payment_method
     * @param bool $paid
     * @return RedirectResponse
     */
    public function moveToSuccessCheckoutPage($order_id, $payment_method, $paid = true): RedirectResponse
    {
        if($paid) {

            $response = 'success';

            $this->updatePaymentOrder($order_id, $payment_method, $response);
        }

        \App\Jobs\sentOrder::dispatch($order_id)->onQueue('checkout');

        Cookie::queue(Cookie::forget('products_cart'));

        return Redirect::route('site.success-checkout')->with(['order_id' => $order_id, 'payment_method' => $payment_method ]);
    }

    /**
     * Create record of payment attempt for order
     * @param $order_id
     * @param $payment_form
     * @param int $attempts
     * @param array $details
     * @param int $status
     * @return PaymentOrder
     */
    public function createOrderPaymentMethodeRecord($order_id, $payment_form, $attempts = 0, $details = [], $status = 0): PaymentOrder
    {
        $payment = new PaymentOrder;

        $payment->order_id = $order_id;

        $payment->payment_method = $payment_form;

        $payment->attempts = $attempts;

        $payment->details = $details;

        $payment->status = $status;

        $payment->save();

        return $payment;
    }

    /**
     * Create or update payment order attempt
     * @param $order_id
     * @param $payment_method
     * @param string $response
     * @param int $status
     */
    public function updatePaymentOrder($order_id, $payment_method, $response = 'success', $status = 1) {

        $payment = PaymentOrder::where('order_id', $order_id)->where('payment_method', $payment_method)->limit(1)->first();

        // $payment->order_id = $order_id;
        if(!empty($payment)) {

            if($payment->status !== 1) {

                $details = json_decode($payment->details, true);

                $payment->attempts = $payment->attempts + 1;

                $details[$payment->attempts + 1] = $response;

                $payment->details = $details;

                $payment->status = $status;

                $payment->save();
            }
        }
        else {

            $attempts = 1;

            $details = [ 1 => $response ];

            $this->createOrderPaymentMethodeRecord($order_id, $payment_method, $attempts, $details, $status);
        }
    }

    /**
     * Success checkout page
     * @return Application|Factory|RedirectResponse|View
     */
    public function successCheckout()
    {
        if(empty($order_id = session('order_id'))) {
            $order = $this->getCookieOrder();

            if(!empty($order)) $order_id = $order['data']['order_id'];
        }

        if(empty($order_id)) return Redirect::route('site./');

        $payment_method = $_COOKIE["pay"]??0;

        Cookie::queue(Cookie::forget('pay'));

        Cookie::queue(Cookie::forget('order'));

        session()->forget('payment_method');

        session()->forget('order_id');

        Cookie::queue(Cookie::forget('pay'));

        return view('site.orders.stripe_checkout', [
            'order_id' => $order_id,
            'payment_method' => $payment_method,
        ]);
    }

    /**
     * Payment methods
     * @return string[]
     */
    public function paymentMethods(): array
    {
        return [
            self::BANK_CARD => 'Оплата банковской картой (Visa, MasterCard)',
            self::GOOGLE_PAY => 'Google Pay',
            self::APPLE_PAY => 'Apple Pay',
        ];
    }

    /**
     * Save new order in data
     * @param $data
     * @param $orderProducts
     * @return bool|int
     */
    public function saveNewOrder($data, $orderProducts)
    {
        if(empty($data) || empty($orderProducts)) {

            info("Ошибка! Не удалось сохранить заказ! Не пришли необходимые данные!");

            info($data);

            info($orderProducts);
        }

        $order = Orders::create([
            'status' => 0,
        ]);

        if(!empty($order)) {

            $orderShipping = OrderShipping::create([
                'order_id' => $order->id,
                'areas_ref' => $data['new_mail_region'],
                'settlement_ref' => $data['new_mail_city'],
                'street_ref' => $data['new_mail_street'],
                'house' => $data['new_mail_house'],
                'apartment' => $data['new_mail_apartment'],
                'warehouse_ref' => $data['new_mail_warehouse'],
                'first_name' => $data['new_mail_name'],
                'middle_name' => $data['new_mail_patronymic'],
                'last_name' => $data['new_mail_surname'],
                'phone' => $data['new_mail_phone'],
                'cashless_payment' => $data['new_mail_non_cash_payment'],
                'payments_form' => $data['new_mail_payment_type'],
                'cash_sum' => $data['new_mail_payment_sum'],
                'company' => json_encode([
                    'name' => $data['new_mail_company_name'],
                    'email' => $data['new_mail_company_email'],
                    'representative_surname' => $data['new_mail_company_user_surname'],
                    'representative_name' => $data['new_mail_company_user_name'],
                    'representative_middlename' => $data['new_mail_company_user_patronymic'],
                    'phone' => $data['new_mail_company_phone'],
                    'document_email' => $data['new_mail_company_address'],
                ]),
                'insurance_sum' => $data['new_mail_insurance_sum'],
                'comments' => $data['new_mail_comment'],
            ]);

            if(!empty($orderShipping)) {

                foreach ($orderProducts as $product):

                    $dataOrderProduct = OrderProduct::create([
                        'order_id' => $order->id,
                        'product_barcode' => $product['sku'],
                        'details' => json_encode($product),
                    ]);

                    if(empty($dataOrderProduct)) {

                        info("Ошибка! Не удалось сохранить товары заказа!");

                        info($orderProducts);

                        Orders::where('order_id', $order->id)->delete();

                        OrderShipping::where('order_id', $order->id)->delete();
                    }

                endforeach;

                return $order->id;

            } else {

                info("Ошибка! Не удалось сохранить параметры доставки заказа!");

                info($orderShipping);

                Orders::where('order_id', $order->id)->delete();

                return false;
            }
        }

        info("Ошибка! Не удалось сохранить заказ!");

        info($data);

        info($orderProducts);

        return false;
    }

    /**
     * Get order from cookie
     */
    public function getCookieOrder() {

        $order = (isset($_COOKIE["san"])) ? json_decode(base64_decode($_COOKIE["san"]), true) : [];

        if(!empty($order)) return $order;

        return false;
    }

    /**
     * Get data resources of New Post from b2b
     * @param $data
     * @return bool|string
     */
    public function sentOrderToB2B($data)
    {
        if(isset($data['order_id'])) unset($data['order_id']);

        $curl = curl_init();

        curl_setopt_array($curl,
            array(
                CURLOPT_URL => "https://b2b-sandi.com.ua/api/orders/checkout?token=" . config('app.ORDER_TOKEN_FOR_B2B'),
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 1000,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                )
            )
        );

        $response = curl_exec($curl);

        $err = curl_error($curl);

        $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if($err || $info !== 200 ) {

            info("Ошибка! Не удалось получить ответ от сервера. Код ошибки: $info!");

            info($response);

            $this->telegramMessage($info, $data['data']['order_id'], 'SENT ORDER TO 1C FAILED');

            return false;
        }

        $this->telegramMessage($response, $data['data']['order_id'], 'SENT ORDER TO 1C');

        return $response;
    }

    /**
     * Get order
     * @param $order_id
     * @return array
     */
    public function getOrder($order_id): array
    {
        $order = Orders::where('id', $order_id)->limit(1)->first();

        $restoreOrder = [];

        $products = $order->products()->get();

        $orderProducts = [];

        foreach($products as $product):

            $orderProducts[$product['product_barcode']] = 1;

        endforeach;

        $restoreOrder['order'] = $orderProducts;

        $dataShipping = $order->shipping()->limit(1)->first();

        $dataOrderShipping = [];

        $dataOrderShipping['new_mail_surname'] = $dataShipping->last_name;

        $dataOrderShipping['new_mail_name'] = $dataShipping->first_name;

        $dataOrderShipping['new_mail_patronymic'] = $dataShipping->middle_name;

        $dataOrderShipping['new_mail_phone'] = $dataShipping->phone;

        $dataOrderShipping['new_mail_region'] = $dataShipping->areas_ref;

        $dataOrderShipping['new_mail_city'] = $dataShipping->settlement_ref;

        $dataOrderShipping['new_mail_warehouse'] = $dataShipping->warehouse_ref;

        $dataOrderShipping['new_mail_comment'] = null;

        $dataOrderShipping['new_mail_street'] = $dataShipping->street_ref;

        $dataOrderShipping['new_mail_house'] = $dataShipping->house;

        $dataOrderShipping['new_mail_apartment'] = $dataShipping->apartment;

        $dataOrderShipping['new_mail_insurance_sum'] = $dataShipping->insurance_sum;

        $dataOrderShipping['payments_form'] = $dataShipping->payments_form;

        // $dataOrderShipping['payments_form'] = $dataShipping->payments_form;

        if(!empty($dataOrderShipping['new_mail_warehouse'])) $dataOrderShipping['new_mail_delivery_type'] = 'storage_storage';
        else $dataOrderShipping['new_mail_delivery_type'] = 'storage_door';

        $dataOrder = (new \App\Http\Controllers\Site\CartController())->createDataOrder($dataOrderShipping);

        $dataOrder['is_employee'] = 0;

        if(!empty($dataShipping->comments)) {

            $employee = json_decode($dataShipping->comments, true);

            if(!empty($employee)) {

                if(isset($employee['is_employee'])) $dataOrder['is_employee'] = (int)$employee['is_employee'];

                if(isset($employee['new_post_delivery']) && isset($employee['employee_region'])) {
                    // if(empty($employee['new_post_delivery']) && !empty($employee['employee_region'])) $dataOrder['region_ref'] = $employee['employee_region'];
                    if(empty($employee['new_post_delivery']) && !empty($employee['employee_region'])) $dataOrder['region'] = str_replace("Регион ", "", $employee['employee_region']);
                    else $dataOrder['new_mail'] = $employee['new_post_delivery'];
                }

                // $dataOrder['region_ref'] = (empty($dataOrder['new_mail'])) ? $employee['employee_region'] : null;

                if(!empty($employee['comments'])) $dataOrder['new_mail_comment'] = $employee['comments'];
            }
        }

        $dataOrder['order_id'] = $order->id;

        $restoreOrder['data'] = $dataOrder;

        return $restoreOrder;
    }

    /**
     * Sent message to telegram bot
     * @param $text
     * @param $order_id
     * @param string $title
     */
    public function telegramMessage($text, $order_id, $title = '')
    {
        if(!$this->telegramMessage) return;

        if(!empty($title)) $title = "$title\n\n";

        $message = "Date: " . date("d.m.Y, H:i:s") . "\norder_id: $order_id\n\n$title" . ((is_array($text) || is_object($text)) ? json_encode($text) : $text);

        $ch = curl_init();

        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot1868751198:AAEy9DHEsKWzcNt8U1yuJBcjUNymYr_PvCY/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => 143719460,
                    'text' => $message,
                ),
            )
        );

        curl_exec($ch);
    }
}
