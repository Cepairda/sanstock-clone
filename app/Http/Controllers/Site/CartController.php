<?php

namespace App\Http\Controllers\Site;

use App\OrderProduct;
use App\Orders;
use App\OrderShipping;
use App\PaymentOrder;
use App\Product;
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


    function __construct() {

        // dd(request()->ip());

        $this->is_employee = $_COOKIE["access"]??0;
    }

    /**
     * Получение данных о товарах в корзине
     */
    public function getCartProducts(): array
    {

        $orderProducts = (isset($_COOKIE["products_cart"])) ? json_decode($_COOKIE["products_cart"], true) : [];

        $sku = array_keys($orderProducts);

        $products = Product::joinLocalization()->withCharacteristics()->whereIn('details->sku', $sku)->get()->keyBy('sku');

        // получаем товары из базы и формируем данные для отображения корзины
        foreach($products as $product):

            $orderItem = [];

            $orderItem['sku'] = $product->getDetails('sku');

            $orderItem["sdCode"] = $product->getDetails('sd_code');

            $orderItem['name'] = $product->name;

            $orderItem['quantity'] = $orderProducts[$product->getDetails('sku')];

            $orderItem['price'] = $product->getPriceAttribute();

            $this->order_sum += $orderItem['price'];

            $orderItem['grade'] = $product->getDetails('grade');

            $orderItem['defective_attributes'] = $product->data['defective_attributes'];
// dd($orderItem['defective_attributes']);
            // $orderItem['max_quantity'] = $product->getDetails('quantity');

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
        return view('site.orders.checkout', [
            'paymentMethods' => $this->paymentMethods(),
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
            'new_mail_delivery_type' => 'required',
            'new_mail_region' => 'required|size:36',
            'new_mail_city' => 'required|size:36',
            //'new_mail_delivery_type' => 'required',
//            'new_mail_insurance_sum' => 'required|numeric|min:200',
        ];

        dd($this->is_employee);


//        if($request->input['new_mail_non_cash_payment'] === 1) {
//
//            $rules['new_mail_company_name'] = 'required';
//
//            $rules['new_mail_company_email'] = 'required|regex:/.+@.+\..+/i';
//
//            $rules['new_mail_company_user_surname'] = 'required';
//
//            $rules['new_mail_company_user_name'] = 'required';
//
//            $rules['new_mail_company_user_patronymic'] = 'required';
//
//            $rules['new_mail_company_phone'] = 'required|regex:/\d+\+\-/i';
//
//            $rules['new_mail_company_address'] = 'required|regex:/.+@.+\..+/i';
//
//        } else {
//
//            if($request->input['new_mail_payment_type'] === 'yes') {
//
//                $rules['new_mail_payment_sum'] = 'required|numeric';
//            }
//        }

//        if($request->input['new_mail_delivery_type'] === 'storage_door') {
//
//            $rules['new_mail_house'] = 'required';
//        }
        //dd('************');

        $shipping = [];
//dd($request->new_mail_surname);
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

        $orderData = [];

        $orderData['new_mail_surname'] = $shipping['new_mail_surname'];

        $orderData['new_mail_name'] = $shipping['new_mail_name'];

        $orderData['new_mail_patronymic'] = $shipping['new_mail_patronymic'];

        $orderData['new_mail_phone'] = $shipping['new_mail_phone'];

        $orderData['new_mail_region'] = $shipping['new_mail_region'];

        $orderData['new_mail_city'] = $shipping['new_mail_city'];

        $orderData['new_mail_comment'] = $shipping['new_mail_comment'];

        $orderData['new_mail_delivery_type'] = $shipping['new_mail_delivery_type'];

        $orderData['payments_form'] = $shipping['payments_form'];

        if($shipping['new_mail_delivery_type'] === 'storage_storage') {

            $orderData['new_mail_warehouse'] = $shipping['new_mail_warehouse'];

            $shipping['new_mail_street'] = '';

            $shipping['new_mail_house'] = '';

            $shipping['new_mail_apartment'] = '';

            $rules['new_mail_warehouse'] = 'required|size:36';

        } else {

            $orderData['new_mail_street'] = $shipping['new_mail_street'];

            $orderData['new_mail_house'] = $shipping['new_mail_house'];

            $orderData['new_mail_apartment'] = $shipping['new_mail_apartment'];

            $shipping['new_mail_warehouse'] = '';

            $rules['new_mail_house'] = 'required';

        }

        $validated = $request->validate($rules);
// dd($validated);
//        if ($validated->fails()) {
//            return Redirect::back()->withErrors('Не заполнены все обязательные поля!');
////            return view("user.home", [
////                "errors" => $validator->errors()
////            ]);
//        }

//        if($order['new_mail_delivery_type'] === 'storage_door') {
//
//            $order['new_mail_street'] = $request->input['new_mail_street'];
//
//            $order['new_mail_house'] = $request->input['new_mail_house'];
//
//            $order['new_mail_apartment'] = $request->input['new_mail_apartment'];
//
//            $order['new_mail_warehouse'] = '';
//
//        } else {
//
//            $order['new_mail_street'] = '';
//
//            $order['new_mail_house'] = '';
//
//            $order['new_mail_apartment'] = '';
//
//            $order['new_mail_warehouse'] = $request->input['new_mail_warehouse'];
//        }

//        if($order['new_mail_non_cash_payment'] = $request->input['new_mail_non_cash_payment'] === 1) {
//
//            $order['new_mail_payment_type'] = '';
//
//        } else {
//
//            if($order['new_mail_payment_type'] = $request->input['new_mail_payment_type'] === 'yes') {
//
//                $order['new_mail_payment_sum'] = $request->input['new_mail_payment_sum'];
//
//            } else {
//
//                $order['new_mail_payment_sum'] = '';
//
//            }
//        }

//        $order['new_mail_insurance_sum'] = $request->input['new_mail_insurance_sum'];
//
//        $order['new_mail_comment'] = $request->input['new_mail_comment'];
//
//        $order['new_mail_company_name'] = $request->input['new_mail_company_name'];
//
//        $order['new_mail_company_email'] = $request->input['new_mail_company_email'];
//
//        $order['new_mail_company_user_surname'] = $request->input['new_mail_company_user_surname'];
//
//        $order['new_mail_company_user_name'] = $request->input['new_mail_company_user_name'];
//
//        $order['new_mail_company_user_patronymic'] = $request->input['new_mail_company_user_patronymic'];
//
//        $order['new_mail_company_phone'] = $request->input['new_mail_company_phone'];
//
//        $order['new_mail_company_address'] = $request->input['new_mail_company_address'];

        $orderProducts = $this->getCartProducts();

        // $orderProducts = (isset($_COOKIE["products_cart"])) ? json_decode($_COOKIE["products_cart"], true) : [];
        if(count($orderProducts) === 0) return Redirect::back()->withErrors('Для оформления заказа необходимо выбрать хотя бы один товар!');
        // order
        $newOrder = new Orders;

        $newOrder->status = 0;

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

        $orderShipping->comments = '';

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

            $orderData['price_sum'] += (int)$product['price'];

            Product::where('details->sku', $product['sku'])->update([
                //'details->price' => $price,
                //'details->old_price' => $oldPrice,
                'details->balance' => 0
            ]);

        endforeach;

        //dd($products);

        $orderData['order_id'] = $newOrder->id;

        $order = [
            'order' => $products,
            'data' => $orderData,
        ];

        // $this->sentOrderToB2B($order);
        // dd($order);
        if(!empty($shipping['payments_form'])) {
            return Redirect::route('site.payment')->with( ['order' => $order] );
        }

        return $this->moveToSuccessCheckoutPage($order);
    }

    /**
     * Payment page
     * @param Request $request
     * @return Application|Factory|View
     */
    public function payment(Request $request) {

        $order = session('order');

        session()->keep(['order']);

        return view('site.orders.payment', [
            'order_id' => $order['data']['order_id'],
            'order' => $order
        ]);
    }

    /**
     * Load platon bank card form
     * @return Application|Factory|View
     */
    public function orderPayment() {

        $order = session('order');

        session()->keep(['order']);

        $order_id = $order['data']['order_id'];

        $amount = number_format($order['data']['price_sum'], 2, '.', '');

        // $order_id = $order['data']['order_id'];
        // $order_id = 118;

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

        $order = session('order');

        session()->keep(['order']);

        $key = env('PLATON_PAYMENT_KEY');
        $pass = env('PLATON_PAYMENT_PASSWORD');
        $payment = 'CC';
        $data = base64_encode(
            json_encode(
                array(
                    'amount' => $amount,
                    'description' => 'Оплата заказа #' . $order_id,
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

        return [
            'order' => session()->get('data'),
            'payment' => $payment,
            'key' => $key,
            'url' => $url,
            'data' => $data,
            'req_token' => $req_token,
            'sign' => $sign
        ];
    }

    /**
     * Create request for google pay
     * @param $order_id
     * @param $amount
     * @return array
     */
    public function requestGooglePay($order_id, $amount): array
    {
        $key = env('PLATON_PAYMENT_KEY');
        $pass = env('PLATON_PAYMENT_PASSWORD');

        $CLIENT_PASS = $pass;
        $data['action'] = 'GOOGLEPAY';
        $data['CLIENT_KEY'] = $key;
        $data['order_id'] = $order_id;
        $data['order_amount'] = $amount;
        $data['order_currency'] = 'UAH';
        $data['order_description'] = 'test';
        $data['payment_token'] = '{"signature":"MEUCIQD+9/PnFvB+Lo6d/eHpgqQrMvmRDZdW1AcjQKavHrcPmQIgeVjR1hXqH7hkCn+VZqx/kjdofMIYbyL15Xp52mR9+2s\u003d","intermediateSigningKey":{"signedKey":"{\"keyValue\":\"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEBOHyOhwWk6SK5nqhFBBI1hSvWHAaOO0Ukbrl56zx7fPNttFFKs2U10f6EWbdhULrv4QT4qMNbyVAq8ig1jdsYA\\u003d\\u003d\",\"keyExpiration\":\"1570945959000\"}","signatures":["MEYCIQCe6t42U5OemtGGdYC6npBNbVxe1HbTF8pUkSD7mO+CWAIhAI/0M/XQuW6i8reT0LCNHKoNfgWYwOWHBoj2wpZdgKHh"]},"protocolVersion":"ECv2","signedMessage":{\"encryptedMessage\":\"U9ChAIukmQ85TdZKAU/26mJUwUt3cVpJmx/JtFi350F/KiRNiIEGi1CmkgVe+ohzikkKLo37Ty3YQjyjVHNTHmF3AyNVTIJCL7qYybt+aFNI1XFlpv3ArWU+fH8Bi190tl7lLyyeNjWx8L402spsLpuUe9OLLjazIq0Vfjw3wRZ2B2+ybUrnoz5Iydapn8B7c/QqR7w53n6svIK58q7eL159Ano0GyfLpUOLLQ949MhP1ze***UzapUGtMd0k0c/4Nnkfs2TnN6ETEtP8y9J29hYKGVOCo79rRSN2xLsYXGNawIiPc6082HWB82JyuW2bfWAL1R0W+2iql2dBWY\\u003d\",\"ephemeralPublicKey\":\"BPYYpVT5INyXSwoNbP/HuGkjQnfnUwUPMH2bCp6Od3EoihnegFZObjP0IVvDA5YfNlLDJjHutBDj30GW5Fei8xw\\u003d\",\"tag\":\"qt4FcCGO4rp969CBBTPJ0nhAeQeR+rOM0FmXk8DdGLQ\\u003d\"}"}';
        $data['payer_email'] = '';
        $data['term_url_3ds'] = 'http://google.com';
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

        return [
            'data' => $data,
            'hash' => $hash
        ];
    }

    /**
     * Check transaction status
     */
    public function checkTransactionStatus() {

        session()->keep(['order']);

        return  view('site.orders.checkTransactionStatus', [

        ]);
    }

    /**
     * Redirect to success checkout page
     * @param null $order
     * @return RedirectResponse
     */
    public function moveToSuccessCheckoutPage($order = null)
    {
        if($order === null) {

            $order = session('order');

            session()->keep(['order']);
//dd($order);

            $payment = new PaymentOrder;

            $payment->order_id = $order['data']['order_id'];

            $payment->payment_method = $order['data']['payments_form'];

            $payment->status = 1;

            $payment->save();

            session()->forget('order');
        }

        \App\Jobs\sentOrder::dispatch($order['data']['order_id'], $order)->onQueue('checkout');

        Cookie::queue(Cookie::forget('products_cart'));

        return Redirect::route('site.success-checkout')->with(['order_id' => $order['data']['order_id'], 'payments_form' => $order['data']['payments_form'] ]);
    }

    /**
     * Success checkout page
     * @return Application|Factory|RedirectResponse|View
     */
    public function successCheckout()
    {
        if(empty($order_id = session('order_id'))) return Redirect::route('site./');

        $payments_form = session('payments_form');

        return view('site.orders.stripe_checkout', [
            'order_id' => $order_id,
            'payments_form' => $payments_form,
        ]);
    }

    /**
     * Payment methods
     * @return string[]
     */
    public function paymentMethods(): array
    {
        return [
            self::BANK_CARD => 'Оплата банковской картой',
            self::GOOGLE_PAY => 'Оплата GooglePay',
            self::APPLE_PAY => 'Оплата ApplePay',
        ];
    }

    /**
     * Save new order in data
     * @param $data
     * @param $orderProducts
     * @return false
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
     * Get data resources of New Post from b2b
     * @param $url
     * @return false|mixed
     */
    public function sentOrderToB2B($data)
    {
        // $start = time();
        // $url = 'http://94.131.241.126/api/nova-poshta/cities';
        return;
        unset($data['order_id']);

        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => "https://b2b-sandi.com.ua/api/orders/checkout?token=" . env('ORDER_TOKEN_FOR_B2B'),
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
        info($data);
        //        var_dump('Время получения ответа: ' . (time() - $start));
        //        var_dump('Код ответа: ' . $info);
        //        var_dump('Ответ:');


        if($err || $info !== 200 ) {
            info("Ошибка! Не удалось получить ответ от сервера. Код ошибки: $info!");
            info($response);
            return false;
        }

        //$result = json_decode($response, true);

        //echo "Код ответа: $info" . PHP_EOL;
        //echo "Страница " . $response . PHP_EOL;

        return $response;
    }


}
