<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Cache;

use Jenssegers\Agent\Agent;
use App\Classes\ImportImage;
use App\Product;
use App\ProductCharacteristicValue;

class ImageController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($productsID = null)
    {
        $products = isset($ids)
            ? Product::where('details->published', 1)->whereIn('id', $ids)->get()
            : Product::where('details->published', 1)->get();

        foreach ($products as $product) {
            ImportImage::import($product->getDetails('sku'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
         * Example input format for $ids
         * <input type="hidden" name="ids[]" value="160" /-->
         *
         */
        $ids = $request->post('ids') ?? null;

        /*$products = empty($ids)
            ? Product::select(['details->sku as sku'])->get()
            : Product::select(['details->sku as sku'])->whereIn('id', $ids)->get();*/

        //if ($products->isNotEmpty()) {
            ImportImage::addToQueue($ids);
        //}
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($sku)
    {

        $png_file_name = $sku . '.png';

        $jpg_file_name = $sku . '.jpg';

        $jpg_file_path = 'products/' . $jpg_file_name;

        $png_file_path = 'products/' . $png_file_name;

        $s = Storage::disk('public');

        if ($s->exists($png_file_path)) {

            return $s->download($png_file_path, $png_file_name);

        }

        $exists = $s->exists($jpg_file_path);

        if (!$exists) {

            if (self::create($sku)) {

                self::show($sku);

            } else {

                return $s->download('products/default.jpg', $jpg_file_name);

            }

        } else {

            $i = Image::make($s->get($jpg_file_path))->encode('webp', 75);

            return $i->response();

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
