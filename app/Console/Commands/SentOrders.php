<?php

namespace App\Console\Commands;

use App\Orders;
use App\OrderShipping;
use App\PaymentOrder;
use Illuminate\Console\Command;

class SentOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sent:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent orders with attempts more 3 times';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Orders::where('status', 0)->where('attempts', '>', 2)->get();

        foreach($orders as $order):

//            $restoreOrder = [];
//
//            $products = $order->products()->get();
//
//            $orderProducts = [];
//
//            foreach($products as $product):
//
//                $orderProducts[$product['product_barcode']] = 1;
//
//            endforeach;
//
//            $restoreOrder['order'] = $orderProducts;
//
//            $dataShipping = $order->shipping()->limit(1)->first();
//
//            $dataOrderShipping = [];
//
//            $dataOrderShipping['new_mail_surname'] = $dataShipping->last_name;
//
//            $dataOrderShipping['new_mail_name'] = $dataShipping->first_name;
//
//            $dataOrderShipping['new_mail_patronymic'] = $dataShipping->middle_name;
//
//            $dataOrderShipping['new_mail_phone'] = $dataShipping->phone;
//
//            $dataOrderShipping['new_mail_region'] = $dataShipping->areas_ref;
//
//            $dataOrderShipping['new_mail_city'] = $dataShipping->settlement_ref;
//
//            $dataOrderShipping['new_mail_warehouse'] = $dataShipping->warehouse_ref;
//
//            $dataOrderShipping['new_mail_comment'] = $dataShipping->comments;
//
//            $dataOrderShipping['new_mail_street'] = $dataShipping->street_ref;
//
//            $dataOrderShipping['new_mail_house'] = $dataShipping->house;
//
//            $dataOrderShipping['new_mail_apartment'] = $dataShipping->apartment;
//
//            $dataOrderShipping['new_mail_insurance_sum'] = $dataShipping->insurance_sum;
//
//            $dataOrderShipping['payments_form'] = $dataShipping->payments_form;
//
//            if(!empty($dataOrderShipping['new_mail_warehouse'])) $dataOrderShipping['new_mail_delivery_type'] = 'storage_storage';
//            else $dataOrderShipping['new_mail_delivery_type'] = 'storage_door';
//
//            $dataOrder = (new \App\Http\Controllers\Site\CartController())->createDataOrder($dataOrderShipping);
//
//            if(empty($dataOrder['new_mail_warehouse']) && empty($dataOrder['new_mail_warehouse']))
//                $dataOrder['is_employee'] = 1;
//            else $dataOrder['is_employee'] = 0;
//
//            $dataOrder['order_id'] = $order->id;
//
//            $restoreOrder['data'] = $dataOrder;
//
//            $order->attempts = 2;
//
//            $order->save();

            $orderShipping = OrderShipping::where('order_id', $order->id)->limit(1)->first();

            if(!empty($orderShipping->payments_form)) $payment = PaymentOrder::where('order_id', $order->id)->where('status', 1)->limit(1)->first();

            if(empty($orderShipping->payments_form) || !empty($payment)) \App\Jobs\sentOrder::dispatch($order->id)->onQueue('checkout');

        endforeach;

        echo "Отправлено заказов: " . count($orders) ;

        return 0;
    }
}
