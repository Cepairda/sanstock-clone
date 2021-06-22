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

    private $order_id;

    /**
     * Create a new job instance.
     *
     * @param $order_id
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = (new \App\Http\Controllers\Site\CartController)->getOrder($this->order_id);

        if($result = (new \App\Http\Controllers\Site\CartController)->sentOrderToB2B($order)) {

            $ord = Orders::find($this->order_id);

            if(!empty($ord)) {

                $ord->status = 1;

                $ord->save();

            } else {

                info('Не удалось обновить статус заказа! Заказ с id = ' . $this->order_id . ' не найден!');
            }

            // отнимаем 1 от количества товара

        } else {
            // пишем попытки отправки заказа на b2b

            // attempts
            $ord = Orders::find($this->order_id);

            if(!empty($ord)) {

                if($ord->attempts < 3) {

                    \App\Jobs\sentOrder::dispatch($order['data']['order_id'])->onQueue('checkout');

                    $ord->attempts = $ord->attempts + 1;

                    $ord->save();

                } else {

                    // Отправляем сообщение о неудачных отправках заказа

                }

            } else {

                info('Не удалось обновить статус заказа! Заказ с id = ' . $this->order_id . ' не найден!');
            }

        }
    }
}
