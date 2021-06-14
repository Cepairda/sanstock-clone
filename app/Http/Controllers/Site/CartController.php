<?php

namespace App\Http\Controllers\Site;

use App\OrderProduct;
use App\Orders;
use App\OrderShipping;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class CartController
{
    private $order_sum = 0;
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
            'order_sum' => $this->order_sum
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

        $shipping['new_mail_payment_type'] = ($request->new_mail_payment_type === 'yes') ? 1 : 0 ;


        $orderData = [];

        $orderData['new_mail_surname'] = $shipping['new_mail_surname'];

        $orderData['new_mail_name'] = $shipping['new_mail_name'];

        $orderData['new_mail_patronymic'] = $shipping['new_mail_patronymic'];

        $orderData['new_mail_phone'] = $shipping['new_mail_phone'];

        $orderData['new_mail_region'] = $shipping['new_mail_region'];

        $orderData['new_mail_city'] = $shipping['new_mail_city'];

        $orderData['new_mail_comment'] = $shipping['new_mail_comment'];

        $orderData['new_mail_delivery_type'] = $shipping['new_mail_delivery_type'];

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

        $orderShipping->payments_form = 0;

        $orderShipping->cash_sum = 0;

        $orderShipping->company = json_encode([]);

        $orderShipping->insurance_sum = 0;

        $orderShipping->comments = '';

        $orderShipping->save();

        $products = [];

        foreach($orderProducts as $product):
            // order products
            $orderProduct = new OrderProduct;

            $orderProduct->order_id = $newOrder->id;

            $orderProduct->product_barcode = $product['sku'];

            $orderProduct->details = json_encode($product);

            $orderProduct->save();

            $products[$product['sku']] = $product['quantity'];

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

       \App\Jobs\sentOrder::dispatch($newOrder->id, $order)->onQueue('checkout');

        //unset($_COOKIE["products_cart"]);
        //$cookie = Cookie::forget('products_cart');
        Cookie::queue(Cookie::forget('products_cart'));

        return view('site.orders.stripe_checkout', [
            'order_id' => $newOrder->id,
        ]);
//
//        if(!$order_id = $this->saveNewOrder($order, $orderProducts)) {
//
//            return view('site.orders.cart', [
//                'order_id' => $order_id,
//                'message' => 'Ваш заказ принят и отправлен в обработку!',
//            ]);
//
//
//        }
//
//        return Redirect::back()->withErrors('Не удалось оформить заказ!');
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

        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => "https://b2b-sandi.com.ua/api/orders/checkout?token=368dbc0bf4008db706576eb624e14abf",
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
