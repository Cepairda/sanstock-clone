<?php

namespace App\Http\Controllers\Site;

use App\OrderProduct;
use App\Orders;
use App\OrderShipping;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CartController
{
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
        return response()->json(
            [
                'body' => view('site.orders.components.modal', compact('orderProducts'))->render()
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

        $orderProducts = $this->getCartProducts();

        if(!$order_id = $this->saveNewOrder($order, $orderProducts)) {

            \App\Jobs\sentOrder::dispatch()->onQueue('checkout');

            return view('site.orders.cart', [
                'order_id' => $order_id,
                'message' => 'Ваш заказ принят и отправлен в обработку!',
            ]);
        }

        return Redirect::back()->withErrors('Не удалось оформить заказ!');
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

        return $result;
    }


}
