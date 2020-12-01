<?php

namespace App\Http\Controllers;

use App\Category;
use App\Characteristic;
use App\CharacteristicValue;
use App\Classes\Slug;
use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::select(['details->sku as sku'])->whereIn('id', [155, 160, 164, 166])->get();

        //$p = Product::joinLocalization('uk')->get();
        //print_r($p);

        //echo Slug::create();

        return view('home', compact('products'));

        $category = Category::where('id', 11)->with('products')->first();

        //dd($category[0]->products);

        $characteristicsIds = [];

        /*foreach ($category->products as $product) {
            echo $product->details['sku'] . '<br>';
            //dd($product->characteristics);

            foreach ($product->characteristics as $characteristic) {
                $characteristicsIds[$characteristic->details['characteristic_id']] = $characteristic->details['characteristic_id'];
                echo '---' . $characteristic->details['characteristic_id'] . '<br>';
            }
        }

        $characteristics = Characteristic::joinLocalization()->whereIn('id', $characteristicsIds)->get();

        foreach ($characteristics as $characteristic) {
            echo $characteristic->data['name'] . '<br>';
        }*/
    }

    public function filter()
    {
        $characteristics = Characteristic::joinLocalization()->get();
        $characteristicsValue = CharacteristicValue::joinLocalization()->get();

        $valuesForView = [];

        foreach ($characteristicsValue as $value) {
            if (!isset($valuesForView[$value->getDetails('characteristic_id')])) {
                $valuesForView[$value->attribute_id] = [];
            }

            $valuesForView[$value->getDetails('characteristic_id')][] = $value;
        }

        return view('filter', compact('characteristics', 'valuesForView'));
    }
}
