<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use XMLWriter;

class XMLController extends Controller
{
    /**
     * @var XMLWriter
     */
    private $xw;

    private $server_url = "https://sandistock.com.ua";

    private $locale = 'ru';

    public function __construct()
    {
        $this->xw = new XMLWriter();
    }

    public function createPromXMLFeeder()
    {
        $memory_start = memory_get_usage();

        $time_start = time();

        // return ;
        LaravelLocalization::setLocale('ru');

        $categories = [];

        $categoriesList = Category::joinLocalization('ru')->get();

        foreach ($categoriesList as $dataCategory) {

            $category = [
                'name' => $dataCategory->name,
                'id' => $dataCategory->id,
                'parent_id' => $dataCategory->parent_id??0,
            ];

            $categories[$dataCategory->ref] = $category;
        }

        $products = $this->getProducts('ru');

//        $dataProducts = Product::joinLocalization('ru')->with(['productSort.productGroup', 'defectiveImages'])->withProductsSort()->get();
//
//        foreach ($dataProducts as $dataProduct) {
//
//            $product = [
//                'sku' => $dataProduct->sku,
//                'name' => $dataProduct->name,
//                'description' => $dataProduct->description,
//                'category_id' => $categories[$dataProduct->category_id]['id']??'',
//                'price' => $dataProduct->productSort->price,
//                'oldprice' => $dataProduct->productSort->old_price,
//                //'vendor' => "Lidz",
//                //'vendor_code' => "Lidz/ZXC",
//                'quantity_in_stock' => "1",
//            ];
//
//            $picture = [];
//
//            foreach ($dataProduct->allDefectiveImages as $key => $value) {
//                $picture[] = "https://sandistock.com.ua/storage/product/{$dataProduct->productSort->productGroup->sdCode}/{$dataProduct->sku}/{$dataProduct->sku}_{$key}.jpg?access=true";
//            }
//
//            $product['picture'] = $picture;
//
//            $attributes = [];
//
//            $characteristics = $dataProduct->productSort->productGroup->characteristics;
//
//            foreach ($characteristics as $value) {
//                $attributes[$value->name] = $value->value ;
//            }
//
//            $product['attributes'] = $attributes;
//
//            $products[] = $product;
//        }

        $xml = new XMLController;

        $content = $xml->createXMLFeeder($products, $categories);

        Storage::disk('local')->put('yml_prom_feeder.xml', $content);

        echo "Total categories: " . count($categories) . PHP_EOL;

        echo "Total products: " . count($products) . PHP_EOL;

        echo "Time: " . (time() - $time_start) . "c.". PHP_EOL;

        echo "Memory: " . ((memory_get_usage() - $memory_start) / 1000) . "KB" . PHP_EOL;

        echo "Max memory: " . (memory_get_peak_usage() / 1000) . "KB";
    }

    /**
     * Create xml feeder for Prom.ua
     * @param $products
     * @param $categories
     */
    public function createXMLFeeder($products, $categories) {

        $this->xw->openMemory();

        $this->xmlStart();

        $this->createCurrencies();

        $this->createCategories($categories);

        $this->createOffers($products);

        $this->xmlEnd();

        return $this->xw->outputMemory();
    }

    /**
     * Create currencies
     */
    public function createCurrencies() {

        $this->xw->startElement('currencies');

        $this->xw->startElement('currency');

        foreach(['id' => 'UAH','rate' => 1] as $key => $value):

            $this->xw->startAttribute($key);

            $this->xw->text($value);

            $this->xw->endAttribute();

        endforeach;

        $this->xw->endElement();

        $this->xw->endElement();
    }

    /**
     * Create offers
     * @param $products
     */
    public function createOffers($products) {

        foreach($products as $product):

            if(empty($product['name']) || empty($product['category_id'])) {
                // $this->telegramMessage($product, $product['sku'], $title = 'EMPTY NAME OR CATEGORY');
                continue;
            }

            $this->createOffer($product);

        endforeach;
    }

    /**
     * Create categories
     * @param $categories
     */
    public function createCategories($categories) {

        $this->xw->startElement('categories');

        foreach($categories as $category):

            $this->createTag('category', $category['name'], ['id' => $category['id'],'parentId' => $category['parent_id']]);

        endforeach;

        $this->xw->endElement();
    }

    /**
     * Create offer|product
     * @param $data
     */
    public function createOffer($data) {

        $this->xw->startElement('offer');

        $this->xw->startAttribute('id');
        $this->xw->text($data['sku']);
        $this->xw->endAttribute();

        $this->xw->startAttribute('available');
        $this->xw->text('true');
        $this->xw->endAttribute();

        $this->createTag('name', $data['name']);

        if(empty($data['description'])) $this->createTag('description', $data['name']);
        else $this->createTag('description', $data['description'], [], 1);

        $this->createTag('categoryId', $data['category_id']);

        $this->createTag('price', $data['price']);

        $this->createTag('oldprice', $data['oldprice']);

        $this->createTag('minimum_order_quantity', 1);

        $this->createTag('quantity_in_stock', 1);

        $this->createTag('currencyId', 'UAH');

        //$this->createTag('vendor', $data['vendor']);

        $this->createTag('vendorCode', $data['vendor_code']);

        // $this->createTag('available', 'true');

        // $this->createTag('country', $data['country']);

        foreach($data['picture'] as $picture):

            $this->createTag('picture', $picture);

        endforeach;

        foreach($data['attributes'] as $attribute_name => $attribute_value):

            $this->createTag('param', $attribute_value, ['name' => $attribute_name]);

        endforeach;

        $this->xw->endElement();
    }

    /**
     * Create tag
     * if not empty $attributes tag attribute is created
     * @param $name
     * @param $value
     * @param array $attributes
     * @param null $CData
     */
    public function createTag($name, $value, $attributes = [], $CData = null)
    {
        $this->xw->startElement($name);

        foreach($attributes as $attribute_name => $attribute_value):

            $this->xw->startAttribute($attribute_name);
            $this->xw->text($attribute_value);
            $this->xw->endAttribute();

        endforeach;

        if($CData === null) $this->xw->text($value);
        else $this->xw->writeCData($value);

        $this->xw->endElement();
    }

    /**
     * Begin xml document
     */
    public function xmlStart() {

        date_default_timezone_set('Europe/Kiev');

        $this->xw->startDocument("1.0", "UTF-8", "yes");

        $this->xw->startElement('yml_catalog');

        $this->xw->startAttribute('date');

        $this->xw->text(date('Y-m-d H:i'));

        $this->xw->endAttribute();

        $this->xw->startElement('shop');
    }

    /**
     * Return xml document
     */
    public function xmlEnd() {

        $this->xw->endElement();

        $this->xw->endDocument();
    }

    /**
     * Get products for export
     * @param $locale
     */
    public function getProducts($locale) {

        $localizations = DB::table('resource_localizations')->where('locale', $locale)->get()->groupBy('resource_id')->toArray();

        $products = DB::table('resources')->select('id','type','details')->where('type', 'App\Product')->get();

        $productGroups = DB::table('resources')->select('id','type','details')->where('type', 'App\ProductGroup')->get();

        $productGroupsMap = $this->createProductGroupsMap($productGroups) ;

        $productGroupImages = DB::table('resources')->select('id','type','details')->where('type', 'App\ProductGroupImage')->get();

        $productPhotos = $this->createImageMap($productGroupImages, 'product_sd_code');

        $productImages = DB::table('resources')->select('id','type','details')->where('type', 'App\ProductImage')->get();

        $defectPhotos = $this->createImageMap($productImages, 'product_sku');

        $characteristics = DB::table('resources')->select('id','type','details')->where('type', 'App\Characteristic')->get();

        $characteristicsMap = $this->characteristicMap($characteristics, $localizations);

        $characteristicValuesData = DB::table('resources')->select('id','type','details')->where('type', 'App\CharacteristicValue')->get();

        $characteristicsValuesMap = $this->characteristicValuesMap($characteristicValuesData, $localizations, $characteristicsMap);

        $resourcesRelationships = DB::table('resource_resource')->get()->toArray();

        $productGroup_CharacteristicValue = $this->createMap($resourcesRelationships, 'App\ProductGroup', 'App\CharacteristicValue');

        $result = [];

        foreach($products as $item):

            $product = [];

            $product_id = $item->id;

            $product['id'] = $product_id;

            $product['type'] = $item->type;

            $product_details = json_decode($item->details);

            if(empty($product['quantity_in_stock'] = $product_details->balance)) continue;

            $product['sku'] = $product_details->sku;

            $product['sd_code'] = $product_details->sd_code;

            $product['brand_id'] = $product_details->brand_id??'';

            $product['category_id'] = $product_details->category_id??'';

            $product['vendor_code'] = $product['sku'];

            $product['price'] = $product_details->price??0;

            $product['oldprice'] = $product_details->old_price??0;

            if(empty($product['brand_id']) || empty($product['category_id']) || empty($product['price'])) continue;

            $product['sort'] = $product_details->grade;

            if(!isset($localizations[$product_id])) continue;

            $localization = $localizations[$product_id][0];

            $localizationData = json_decode($localization->data);

            $product['name'] = $localizationData->name??'';

            if(empty($product['name'])) continue;

            $product['name'] = 'Уцененный товар (СОРТ-' . $product['sort'] . ') - ' . $product['name'] . ' (' . $product['sku'] . ')';

            $product['description'] = $localizationData->description??$product['name'];

            if($locale === 'ru') $product['description'] .= "<br><br>Уцененный товар относится к сорту-" . $product['sort'] . ".";
            else $product['description'] .= "<br><br>Знижений у ціні товар відноситься до сорту-" . $product['sort'] . ".";

            $defects = '';

            if(isset($localizationData->defective_attributes)) {

                if($locale === 'ru') $product['description'] .= "<br><br>Дефекты:";
                else $product['description'] .= "<br><br>Дефекти:";

                $defects = implode(', ', $localizationData->defective_attributes);

                $defects = str_replace(', , ', ', ', $defects);

                foreach($localizationData->defective_attributes as $defect):

                    $product['description'] .= "<br>&nbsp;&bull;&nbsp;$defect";

                endforeach;
            }

            $product['picture'] = $productPhotos[$product['sd_code']]??[];

            if(isset($defectPhotos[$product['sku']])):

                array_splice($product['picture'], 5);

                foreach($defectPhotos[$product['sku']] as $image_key):

                    $product['picture'][] = "$this->server_url/storage/product/" . $product['sd_code'] ."/" . $product['sku'] . "/" . $product['sku'] . "_$image_key.jpg";

                endforeach;

            endif;

            $product['attributes'] = [];

            $product['attributes']['Сорт'] = $product['sort'];

            $product['attributes']['Дефекты'] = $defects;

            if(isset($productGroup_CharacteristicValue['App\ProductGroup-' . $productGroupsMap[$product['sd_code']]])) {

                foreach($productGroup_CharacteristicValue['App\ProductGroup-' . $productGroupsMap[$product['sd_code']]] as $productCharacteristic):

                    if(isset($characteristicsValuesMap["App\CharacteristicValue-" . $productCharacteristic['relation_id']])) {

                        $attribute = $characteristicsValuesMap["App\CharacteristicValue-" . $productCharacteristic['relation_id']];

                        if($locale === 'ru') {
                            if($attribute['name'] === 'Страна-производитель') $attribute['name'] = 'Страна производитель';
                            else if($attribute['name'] === 'Тип установки') $attribute['name'] = 'Способ установки';
                        }

                        $product['attributes'][$attribute['name']] = $attribute['value'];
                    }

                endforeach;

                // if(!empty($product['attributes'])) dd($product['attributes']);
            }

            $result[] = $product;

//            $item = [
//                'sku' => $dataProduct->sku,
//                'name' => $dataProduct->name,
//                'description' => $dataProduct->description,
//                'category_id' => $categories[$dataProduct->category_id]['id']??'',
//                'price' => $dataProduct->productSort->price,
//                'oldprice' => $dataProduct->productSort->old_price,
//                //'vendor' => "Lidz",
//                //'vendor_code' => "Lidz/ZXC",
//                'quantity_in_stock' => "1",
//            ];

        endforeach;

        return $result;
    }

    /**
     * Creat map resources
     * @param $data
     * @param $resource_type
     * @param $relation_type
     * @return array
     */
    private function createMap($data, $resource_type, $relation_type): array
    {
        $result = [];

        foreach($data as $item):

            $item = (array)$item;

            // product groups - characteristics value Map
            if($item['resource_type'] === $resource_type && $item['relation_type'] === $relation_type) {
                if(!isset($result[$item['resource_type'] . "-" . $item['resource_id']])) $result[$item['resource_type'] . "-" . $item['resource_id']] = [];

                $result[$item['resource_type'] . "-" . $item['resource_id']][] = $item;
            }

        endforeach;

        return $result;
    }

    private function createProductGroupsMap($data) {

        $result = [];

            foreach($data as $item):

                $details = json_decode($item->details);

                if(isset($details->sd_code)) $result[$details->sd_code] = $item->id;

            endforeach;

        return $result;
    }

    private function createImageMap($data, $product_key): array
    {

        $result = [];

        foreach($data as $item):

            $image = [];

            $item = (array)$item;

            $details = json_decode($item['details'], true);

            if(!isset($details[$product_key])) continue;

            if(isset($details['main'])) {
                if($product_key === 'product_sd_code') $image[] = "$this->server_url/storage/product/$details[$product_key]/$details[$product_key].jpg";
                else $image[] = 0;
            }

            if(isset($details['additional'])) {

                foreach($details['additional'] as $image_key => $timeCreation):

                    if($product_key === 'product_sd_code') $image[] = "$this->server_url/storage/product/$details[$product_key]/additional/$details[$product_key]_$image_key.jpg";
                    else $image[] = $image_key;

                endforeach;
            }

            $result[$details[$product_key]] = $image;

        endforeach;

        return $result;
    }

    private function characteristicMap($data, $localizations): array
    {
        $result = [];

        foreach($data as $item):

            $characteristic = [];

            $characteristic['id'] = $item->id;

            $characteristic['type'] = $item->type;

            // $details = json_decode($item->details);

            // if(isset($details->characteristic_id)) $characteristic['characteristic_id'] = $details->characteristic_id;

            if(!isset($localizations[$characteristic['id']])) continue;

            $characteristicDescription = json_decode($localizations[$characteristic['id']][0]->data);

            if(!isset($characteristicDescription->name)) continue;

            $characteristic['name'] = $characteristicDescription->name;

            //dd($characteristic);

            $result[ $characteristic['type'] . "-" . $characteristic['id']] = $characteristic;

        endforeach;

        return $result;
    }

    /**
     * Characteristics values map
     * @param $data
     * @param $localizations
     * @param $characteristics
     * @return array
     */
    private function characteristicValuesMap($data, $localizations, $characteristics): array
    {

        $result = [];

        foreach($data as $item):

            $characteristicValues = [];

            $characteristicValues['id'] = $item->id;

            $characteristicValues['type'] = $item->type;

            $details = json_decode($item->details);

            if(isset($details->characteristic_id)) $characteristicValues['characteristic_id'] = $details->characteristic_id;

            if(!isset($localizations[$characteristicValues['id']])) continue;

            $characteristicDescription = json_decode($localizations[$characteristicValues['id']][0]->data);

            if(!isset($characteristicDescription->value)) continue;

            $characteristicValues['value'] = $characteristicDescription->value;

            if(!isset($characteristics['App\Characteristic-' . $characteristicValues['characteristic_id']])) continue;

            $characteristicValues['name'] = $characteristics['App\Characteristic-' . $characteristicValues['characteristic_id']]['name'];

            $result[ $characteristicValues['type'] . "-" . $characteristicValues['id'] ] = $characteristicValues;

        endforeach;

        return $result;
    }

    /**
     * Sent message to telegram bot
     * @param $text
     * @param $order_id
     * @param string $title
     */
    public function telegramMessage($text, $order_id, $title = '')
    {
        if(!empty($title)) $title = "$title\n\n";

        $message = "SANDISTOCK\n\nDate: " . date("d.m.Y, H:i:s") . "\nitem: $order_id\n\n$title" . ((is_array($text) || is_object($text)) ? json_encode($text) : $text);

        $ch = curl_init();

        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot1932081629:AAHtkIkpdksXRWpkJW3pwWD_EdmfAN7pVzA/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => 143719460,
                    'text' => $message,
                ),
            )
        );

        curl_exec($ch);
    }
}
