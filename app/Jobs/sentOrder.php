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

    private $order;

    /**
     * Create a new job instance.
     *
     * @param $order_id
     * @param $order
     */
    public function __construct($order_id, $order)
    {
        $this->order = $order;

        $this->order_id = $order_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($result = (new \App\Http\Controllers\Site\CartController)->sentOrderToB2B($this->order)) {

            $order = Orders::find($this->order_id);

            if(!empty($order)) {

                $order->status = 1;

                $order->save();

            } else info('Не удалось обновить статус заказа! Заказ с id = ' . $this->order_id . ' не найден!');

            // отнимаем 1 от количества товара

        }
    }
}
