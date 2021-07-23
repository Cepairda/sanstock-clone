<?php

namespace App\Http\Controllers\Admin\Export;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Export\XMLController;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function __construct()
    {
//        ini_set('default_socket_timeout', 10000);
//        ini_set('memory_limit', -1);
//        ini_set('max_input_time', -1);
//        ini_set('max_execution_time', 10000);
//        set_time_limit(0);

    }

    public function createPromXMLFeeder()
    {
        $memory_start = memory_get_usage();

        $time_start = time();

        $products = [];

        for($i = 1; $i <= 10; $i++):

            $product = [
                'sku' => "SKU$i",
                'name' => "Товар $i",
                'description' => "Описание товара $i",
                'category_id' => "1",
                'price' => "77.9",
                'oldprice' => "80",
                'vendor' => "Lidz",
                'vendor_code' => "Lidz/$i",
                'quantity_in_stock' => "1",
                'picture' => [
                    "https://sanstock.com.ua/img-1.jpg",
                    "https://sanstock.com.ua/img-2.jpg",
                    "https://sanstock.com.ua/img-3.jpg"
                ],
                'attributes' => [
                    'Цвет' => 'Белый',
                    'Материал' => 'Керамика',
                    'Производитель' => 'Китай',
                ]
            ];

            $products[] = $product;

        endfor;

        $categories = [];

        $categoriesList = Category::joinLocalization('ru')->get();

        foreach ($categoriesList as $category) {

            $category = [
                'name' => $category->name,
                'id' => $category->id,
                'parent_id' => $category->parent_id,
            ];

            $categories[] = $category;
        }

        $xml = new XMLController;

        $content = $xml->createXMLFeeder($products, $categories);

        Storage::disk('public')->put('yml_prom_feeder.xml', $content);

        echo "Total categories: " . count($categories) . PHP_EOL;

        echo "Total products: " . count($products) . PHP_EOL;

        echo "Time: " . (time() - $time_start) . "c.". PHP_EOL;

        echo "Memory: " . ((memory_get_usage() - $memory_start) / 1000) . "KB" . PHP_EOL;

        echo "Max memory: " . (memory_get_peak_usage() / 1000) . "KB";
    }

}
