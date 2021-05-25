<?php

namespace App\Jobs;

use App\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sentOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = '' ;

        if($result = (new \App\Http\Controllers\Site\CartController)->sentOrderToB2B($url)) {

            $order = Orders::find($result['order_id']);

            if(!empty($order)) {

                $order->status = 1;

                $order->save();

            } else info('Не удалось обновить статус заказа! Заказ с id = ' . $result['order_id'] . ' не найден!');

            // отнимаем 1 от количества товара

        }
    }
}
