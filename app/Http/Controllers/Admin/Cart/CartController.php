<?php

namespace App\Http\Controllers\Admin\Cart;

use App\Orders;
use App\OrderShipping;
use App\Product;
use Illuminate\Http\Request;

class CartController
{

    /**
     * Отправка данных о товарах в корзине
     */
    public function getCartProducts() {

    }

    /**
     * Show checkout view
     * @param null $input
     * @return mixed
     */
    public function loadCheckoutView($input = null)
    {
        if($input == null)
            return View::make('members.register');
        else
            return View::make('members.register', $input);
    }

    /**
     * Show cart view
     */
    public function loadCartView() {

        $products = $_COOKIE["products_cart"];

        $orderProducts = [];

        $sku = [];

        $products = Product::whereIn('details->sku', $sku)->get()->keyBy('sku')->keys()->toArray();

        // получаем товары из базы и формируем данные для отображения корзины
        foreach($products as $sku => $product):

            $orderItem = [];

            $orderItem['sku'] = $sku;

            $orderItem['name'] = '';

            $orderItem['image'] = '';

            $orderItem['quantity'] = '';

            $orderItem['price'] = '';

            $orderItem['max_quantity'] = '';

            $orderProducts[] = $orderItem;

        endforeach;

        // возвращаем view с данными о товарах

        return view('site.home.index', [
            'products' => [],
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
            'new_mail_phone' => 'required|size:19',
            'new_mail_insurance_sum' => 'required|numeric|min:200',
        ];

        if($request->input['new_mail_non_cash_payment'] === 1) {

            $rules['new_mail_company_name'] = 'required';

            $rules['new_mail_company_email'] = 'required|regex:/.+@.+\..+/i';

            $rules['new_mail_company_user_surname'] = 'required';

            $rules['new_mail_company_user_name'] = 'required';

            $rules['new_mail_company_user_patronymic'] = 'required';

            $rules['new_mail_company_phone'] = 'required|regex:/\d+\+\-/i';

            $rules['new_mail_company_address'] = 'required|regex:/.+@.+\..+/i';
        } else {

            if($request->input['new_mail_payment_type'] === 'yes') {

                $rules['new_mail_payment_sum'] = 'required|numeric';
            }
        }

        if($request->input['new_mail_delivery_type'] === 'storage_door') {

            $rules['new_mail_house'] = 'required';
        }

        $validated = $request->validate($rules);

        $order = [];

        $order['new_mail_surname'] = $request->input['new_mail_surname'];

        $order['new_mail_name'] = $request->input['new_mail_name'];

        $order['new_mail_patronymic'] = $request->input['new_mail_name'];

        $order['new_mail_phone'] = $request->input['new_mail_name'];

        $order['new_mail_delivery_type'] = $request->input['new_mail_delivery_type'];

        $order['new_mail_region'] = $request->input['new_mail_region'];

        $order['new_mail_city'] = $request->input['new_mail_city'];

        if($order['new_mail_delivery_type'] === 'storage_door') {

            $order['new_mail_street'] = $request->input['new_mail_street'];

            $order['new_mail_house'] = $request->input['new_mail_house'];

            $order['new_mail_apartment'] = $request->input['new_mail_apartment'];

            $order['new_mail_warehouse'] = '';

        } else {

            $order['new_mail_street'] = '';

            $order['new_mail_house'] = '';

            $order['new_mail_apartment'] = '';

            $order['new_mail_warehouse'] = $request->input['new_mail_warehouse'];
        }

        if($order['new_mail_non_cash_payment'] = $request->input['new_mail_non_cash_payment'] === 1) {

            $order['new_mail_payment_type'] = '';

        } else {

            if($order['new_mail_payment_type'] = $request->input['new_mail_payment_type'] === 'yes') {

                $order['new_mail_payment_sum'] = $request->input['new_mail_payment_sum'];

            } else {

                $order['new_mail_payment_sum'] = '';

            }
        }

        $order['new_mail_insurance_sum'] = $request->input['new_mail_insurance_sum'];

        $order['new_mail_comment'] = $request->input['new_mail_comment'];

        $order['new_mail_company_name'] = $request->input['new_mail_company_name'];

        $order['new_mail_company_email'] = $request->input['new_mail_company_email'];

        $order['new_mail_company_user_surname'] = $request->input['new_mail_company_user_surname'];

        $order['new_mail_company_user_name'] = $request->input['new_mail_company_user_name'];

        $order['new_mail_company_user_patronymic'] = $request->input['new_mail_company_user_patronymic'];

        $order['new_mail_company_phone'] = $request->input['new_mail_company_phone'];

        $order['new_mail_company_address'] = $request->input['new_mail_company_address'];

        $this->saveNewOrder($order);
    }

    /**
     * Save new order in data
     * @param $data
     */
    public function saveNewOrder($data) {

        $order = Orders::create([
            'status' => 1,
        ]);

        if(!empty($order)) {

            $orderShipping = OrderShipping::create([
                'order_id' => $order->id,
                'areas_ref' => $data['new_mail_region'],
                'settlement_ref' => $data['new_mail_city'],
                'street_ref' => $data['new_mail_street'],
                'house' => $data['new_mail_house'],                             // <= ?
                'apartment' => $data['new_mail_apartment'],                     // <= ?
                'warehouse_ref' => $data['new_mail_warehouse'],
                'first_name' => $data['new_mail_name'],
                'middle_name' => $data['new_mail_patronymic'],
                'last_name' => $data['new_mail_surname'],
                'phone' => $data['new_mail_phone'],                             // <= email in database
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

            return $orderShipping;
        }

        return false;
    }


    /**
     * Get data resources of New Post from b2b
     * @param $url
     * @return false|mixed
     */
    public function sentOrderToB2B($url)
    {
        // $start = time();
        // $url = 'http://94.131.241.126/api/nova-poshta/cities';

        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 1000,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                )
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        //        var_dump('Время получения ответа: ' . (time() - $start));
        //        var_dump('Код ответа: ' . $info);
        //        var_dump('Ответ:');
        //        dd(json_decode($response, true));

        if($err || $info !== 200) {
            info("Ошибка! Не удалось получить ответ от сервера. Код ошибки: $info!");
            info("Ссылка: $url!");
            info($response);
            return false;
        }

        $result = json_decode($response, true);

        echo "Код ответа: $info" . PHP_EOL;
        echo "Страница " . $result['current_page'] . " из " . $result['last_page'] . PHP_EOL;

        //  dd($result);
        return $result;

    }
}
