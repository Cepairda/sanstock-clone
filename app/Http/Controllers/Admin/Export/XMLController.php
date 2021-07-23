<?php

namespace App\Http\Controllers\Admin\Export;

use App\Http\Controllers\Controller;
use XMLWriter;

class XMLController extends Controller
{
    /**
     * @var XMLWriter
     */
    private $xw;

    public function __construct()
    {
        $this->xw = new XMLWriter();
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

        $this->createTag('description', $data['description']);

        $this->createTag('categoryId', $data['category_id']);

        $this->createTag('price', $data['price']);

        $this->createTag('oldprice', $data['oldprice']);

        $this->createTag('minimum_order_quantity', 1);

        $this->createTag('quantity_in_stock', 1);

        $this->createTag('currencyId', 'UAH');

        $this->createTag('vendor', $data['vendor']);

        $this->createTag('vendorCode', $data['vendor_code']);

        $this->createTag('available', 'true');

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
     */
    public function createTag($name, $value, $attributes = [])
    {
        $this->xw->startElement($name);

        foreach($attributes as $attribute_name => $attribute_value):

            $this->xw->startAttribute($attribute_name);
            $this->xw->text($attribute_value);
            $this->xw->endAttribute();

        endforeach;

        $this->xw->text($value);

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
     * @return mixed
     */
    public function xmlEnd() {

        $this->xw->endElement();

        $this->xw->endDocument();
    }
}
