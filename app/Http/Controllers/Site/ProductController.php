<?php

namespace App\Http\Controllers\Site;

use App\Classes\Imports\PriceImport;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductSort;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search()
    {

    /*    return view('site.components.header.liveSearch', [
            'products' => ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0)
                ->where(function ($query) {
                    foreach (explode(' ', request()->get('query')) as $value) {
                        $query->orWhere('search_string', 'LIKE', '%' . $value . '%');
                    }
                })->get()
        ]);*/


        $productsSort = ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0)
            ->where(function ($query) {
                foreach (explode(' ', request()->get('query')) as $value) {
                    $query->orWhere('search_string', 'LIKE', '%' . $value . '%');
                }
            })
            ->limit(15)
            ->get();

        //if ($productsSort->isEmpty()) {
            //$productsSdCode = Product::where('details->sku', 'LIKE', '%' . request()->get('query') . '%')->get()->pluck('details->grade', 'details->sd_code');
            $productsSdCode = Product::where('details->sku', 'LIKE', '%' . request()->get('query') . '%')->get();

            $productsSortByBarCode = collect([]);

            if ($productsSdCode->isNotEmpty()) {
                $productsSortByBarCode = ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0);
                $productsSortByBarCode = $productsSortByBarCode->where(function ($query) use ($productsSdCode) {
                    foreach ($productsSdCode as $product) {
                        $query->orWhere([['details->grade', $product->grade], ['details->sd_code', $product->sdCode]]);
                    }
                })
                ->limit(15)
                ->get();
            }
        //}
        $productsSort = $productsSort->merge($productsSortByBarCode);

        return view('site.components.header.liveSearch', [
            'products' => $productsSort,
        ]);
    }



    public function updatePrice(Request $request)
    {
        $datas = $request->post('data');
        $pageType = $request->post('type');
        //$productSku = ProductSort::whereIn('details->sku', $sku)->get()->keyBy('sku')->keys()->toArray();

//        $datas = [
//            ['SD00042543', 1],
//            ['SD00042551', 1],
//            ['SD00033009', 1],
//            ['SD00037240', 2],
//        ];

        $productsSkuArrayAll = [];

        foreach ($datas as [$sdCode, $grade]) {
            $productsSkuArrayBySort = Product::where([['details->sd_code', $sdCode], ['details->grade', $grade]])->get()->keyBy('details->sku')->keys()->toArray();
            $productsSkuArrayAll = [...$productsSkuArrayAll, ...$productsSkuArrayBySort];
        }

        $skuStr = implode(',', $productsSkuArrayAll);
        $apiUrl = PriceImport::DEFAULT_API_URL . "&sku_in={$skuStr}";
        $pricesWithBalances = PriceImport::pricesApi($apiUrl);
        $forUpdate = [];

        if ($pageType == 'category') {
            foreach ($pricesWithBalances['data'] as $sku => [
                     'main' => [
                     'sku' => $sdCode,
                     'price' => $price,
                     'old_price' => $oldPrice,
                     'balance' => $balance,
                     'defective_attributes' => [
                     'grade' => $grade,
            ],
            ]
            ]) {
                $forUpdate[$sdCode . '_' . $grade] = [
                    'sku' => $sku,
                    'sdCode' => $sdCode,
                    'price' => $price,
                    'oldPrice' => $oldPrice,
                    'balance' => $balance,
                    'grade' => $grade,
                ];
            }
        } elseif ($pageType == 'product') {
            foreach ($pricesWithBalances['data'] as $sku => [
                'main' => [
                    'sku' => $sdCode,
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'balance' => $balance,
                    'defective_attributes' => [
                        'grade' => $grade,
                    ],
                ]
            ]) {
                $forUpdate[] = [
                    'sku' => $sku,
                    'sdCode' => $sdCode,
                    'price' => $price,
                    'oldPrice' => $oldPrice,
                    'balance' => $balance,
                    'grade' => $grade,
                ];
            }
        }


        PriceImport::import($pricesWithBalances);

        return $forUpdate;
    }

    public function getFirstAdditional(Request $request)
    {
        $sku = $request->post('sku');
        //$additional = temp_additional($sku, true);
        $additionalPath = 'storage/product/' . $sku . '/300-' . $sku . '_1.jpg';

        if (file_exists($additionalPath)) {
            return response()->json(['additional' => [asset($additionalPath)]]);
        }

        return null;
    }
}
