<?php


namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Characteristic;
use App\CharacteristicValue;
use App\Http\Controllers\Controller;

use App\Product;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use LaravelLocalization;

class ImportController extends Controller
{
    private $token = '87cbacd82eca60a44f2abaa6d8dcf2d6a6368fd35e071f7c27d1cc5ca24486ca';
    protected $data = null;

    public function __construct()
    {
        ini_set('default_socket_timeout', 10000);
        ini_set('memory_limit', -1);
        ini_set('max_input_time', -1);
        ini_set('max_execution_time', 10000);
        set_time_limit(0);
    }

    private function getData($resource)
    {
        $client = new Client();
        $res = $client->request('GET', 'https://b2b-sandi.com.ua/api/content/' . $resource . '?token=' . $this->token);

        return json_decode($res->getBody(), true);
    }

    public function updateOrCreate($brandRef = null)
    {
        $this->data = $this->getData('brand/' . 'a0ca0cab-c450-11e7-82f5-00155dacf604');
        $this->data = $this->getData('brand/' . '462a44b3-920c-11e6-8148-00155db18262');

        $t['start'] = \Carbon\Carbon::now()->format('H:i:s');

        $brand = $this->firstOrCreateBrand();
        $this->firstOrCreateProducts($brand);

        $t['end'] = \Carbon\Carbon::now()->format('H:i:s');

        dd($t);
    }

    public function firstOrCreateBrand()
    {
        $brand = Brand::where('details->ref', $this->data['brand']['ref'])->first();

        if (!isset($brand)) {

            $brand = new Brand();
            $name = trim($this->data['brand']['description']);

            $brand->setRequest([
                'slug' => Str::slug(str_replace('/', '', $name)),
                'details' => ['ref' => $this->data['brand']['ref']],
                'data' => ['name' => $name]
            ]);

            LaravelLocalization::setLocale('ru');
            $brand->storeOrUpdate();
        }

        return $brand;
    }

    public function firstOrCreateProducts($brand = null)
    {
        foreach ($this->data['products'] as $productRef => $productData) {

            $product = Product::where('details->ref', $productRef)->first();

            if (!isset($product)) {

                $product = new Product();
                $name = trim($productData['description']);
                $categoryName = ($this->data['categories'][$productData['category_ref']]['description'] ?? 'uncategorized');
                $slug = (Str::slug($categoryName) . '/' . Str::slug($name));

                $product->setRequest([
                    'slug' => $slug,
                    'details' => [
                        'ref' => $productRef,
                        'sku' => $productData['old_base_code'],
                        'brand_id' => $brand->id ?? null,
                        'category_id' => null,
                    ],
                    'data' => ['name' => $name]
                ]);

                LaravelLocalization::setLocale('ru');
                $product->storeOrUpdate();
            }

            if (isset($this->data['characteristics'][$productRef])) {

                $product->setRequest([
                    'relations' => [
                        CharacteristicValue::class => $this->updateOrCreateCharacteristics($this->data['characteristics'][$productRef])
                    ]
                ]);
            }

            $product->updateRelations();
        }
    }

    public function updateOrCreateCharacteristics($characteristics)
    {
        $characteristicValueIds = [];

        foreach ($characteristics as $characteristic) {

            $characteristicDataName = mb_ucfirst(trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['description_characteristic'], 'UTF-8'))));
            $characteristicValueDataValue = trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['value'], 'UTF-8')));

            if (!empty($characteristicDataName) && !empty($characteristicValueDataValue)) {

                $c = Characteristic::where('data->name', $characteristicDataName)->joinLocalization('ru')->first();

                if (!isset($c)) {

                    $c = new Characteristic();

                    $c->setRequest([
                        'data' => ['name' => $characteristicDataName]
                    ]);

                    LaravelLocalization::setLocale('ru');
                    $c->storeOrUpdate();
                }

                $characteristicDataNameUk = mb_ucfirst(trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['description_characteristic_uk'], 'UTF-8'))));

                if (!empty($characteristicDataNameUk)) {

                    $c->setRequest([
                        'details' => [
                            'is_filter' => 1,
                            'published' => 1,
                            'sort' => 0
                        ],
                        'data' => ['name' => $characteristicDataNameUk],
                    ]);

                    LaravelLocalization::setLocale('uk');
                    $c->storeOrUpdate();
                }

                $cV = CharacteristicValue::where('details->characteristic_id', $c->id)
                    ->where('data->value', $characteristicValueDataValue)->joinLocalization('ru')->first();

                if (!isset($cV)) {

                    $cV = new CharacteristicValue();

                    $cV->setRequest([
                        'details' => ['characteristic_id' => $c->id],
                        'data' => ['value' => $characteristicValueDataValue]
                    ]);

                    LaravelLocalization::setLocale('ru');
                    $cV->storeOrUpdate();
                }

                $characteristicValueDataValueUk = trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['value_uk'], 'UTF-8')));

                if (!empty($characteristicValueDataValueUk)) {

                    $cV->setRequest([
                        'details' => ['characteristic_id' => $c->id],
                        'data' => ['value' => $characteristicValueDataValueUk]
                    ]);

                    LaravelLocalization::setLocale('uk');
                    $cV->storeOrUpdate();
                }

                array_push($characteristicValueIds, $cV->id);
            }
        }

        return $characteristicValueIds;
    }
}
