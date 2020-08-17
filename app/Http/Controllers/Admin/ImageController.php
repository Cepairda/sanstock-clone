<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Cache;

use Jenssegers\Agent\Agent;
use App\Product;
use App\ProductCharacteristicValue;

class ImageController extends Controller
{

    protected $default = []; //default params

    public function __construct()
    {
        $this->default = [
            'product' => [
                'format' => [],
                'size' => [],
                'default' => 'img/product/logo.jpg'
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($products)
    {

        set_time_limit(0);

        ini_set('memory_limit','5024M');

        //$products = Product::whereId(1)->get();

        //$products = Product::all();
        $products = Product::select(['details->sku as sku'])->get();
//
//        $products = [
//
//            ['sku' => '6163'],
//            ['sku' => '6164'],
//
//        ];

        self::mass_download($products);

        //self::mass_generate($products);

//        self::mass_download_additional($products);

        dd('MASS GENERATE DONE');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function create($data)
    {

        info('Create images: ');

        info($data);

        if ($data['type'] == 'product') {

            if ($data['name'] == $data['name']) {

                $url = 'https://b2b-sandi.com.ua/imagecache/large/' . $data['name'] . '.jpg';

                $contents = @Image::make($url);

                $contents->save(public_path('storage/' . $data['type'] . '/' . $data['name']) . '.jpg'); // save original

                if ($contents) {

//                    Trim around image
//
//                    $contents->trim(null, null, 5, 50)->resize($data['size'], $data['size'], function ($constraint) {
//
//                        $constraint->aspectRatio();
//
//                    })->resizeCanvas($data['size'], $data['size'], 'center', false, [255, 255, 255, 0]);

                    $contents->encode($data['format'], 75)->save( public_path('storage/' . $data['type'] . '/' . $data['size'] . '-' . $data['name']) . '.' . $data['format']);

                    return true;

                } else {

                    return false;

                }

            }

        }

        if ($data['type'] == 'category') {

            if ( file_exists(public_path('storage/' . $data['type'] . '/' . $data['original'])) ) {

                $contents = Image::make(public_path('storage/' . $data['type'] . '/' . $data['original']));

                if ($contents) {

//                    Trim around image
//
//                    $contents->trim(null, null, 5, 50)->resize($data['size'], $data['size'], function ($constraint) {
//
//                        $constraint->aspectRatio();
//
//                    })->resizeCanvas($data['size'], $data['size'], 'center', false, [255, 255, 255, 0]);

                    foreach (['webp', 'jpg'] as $format) {

                        $tmp = $contents;

                        //$tmp->encode($format, 90)->save( public_path('storage/' . $data['type'] . '/' . $data['size'] . '-' . $data['name']) . '.' . $format);

                        $tmp->encode($format, 80)->save( public_path('storage/' . $data['type'] . '/' . $data['size'] . '-' . $data['name']) . '.' . $format);

                    }

                    return true;

                } else { return false; }

            } else { return false; }

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
        //
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

    /***
     *
     * NEW FUNCTIONS
     *
     ***/

    public static function get_xml_image($data) {

        $data['format'] = 'webp';

        $s = Storage::disk('public');

        $file_path = '/' . $data['type'] . '/' . $data['size'] . '-' . $data['name'] . '.' . $data['format'];

        if ($data['type'] == 'product') {

            if ($s->exists($file_path)) {

                return asset('/storage' . $file_path);

            } else {

                //self::create($data);

                return asset('/img/product/logo.jpg');

            }

        }

        if ($data['type'] == 'category') {

            if ($s->exists($file_path)) {

                return asset('/storage' . $file_path);

            } else {

                //self::create($data);

                return asset('/img/product/logo.jpg');

            }

        }

        return  asset('/img/product/logo.jpg');

    }

    public static function get_image($data) {

        $data['format'] = 'webp';

        if ( session()->exists('images_format') ) {

            $data['format'] = session('images_format');

        } else {

            $agent = new Agent();

            $images_format = ( $agent->is('iPhone') || $agent->is('OS X') ) ? 'png' : 'webp';

            $data['format'] = $images_format;

            session(['images_format' => $images_format]);

        }

        $s = Storage::disk('public');

        $file_path = '/' . $data['type'] . '/' . $data['size'] . '-' . $data['name'] . '.' . $data['format'];

        if ($data['type'] == 'product') {

            if ($s->exists($file_path)) {

                return asset('/storage' . $file_path);

            } else {

                //self::create($data);

                return asset('/img/product/logo.jpg');

            }

        }

        if ($data['type'] == 'category') {

            if ($s->exists($file_path)) {

                return asset('/storage' . $file_path);

            } else {

                $data['original'] = $data['name'] . '.jpg';

                self::create($data);

                return asset('/img/product/logo.jpg');

            }

        }

        return  asset('/img/product/logo.jpg');

    }

    public static function get_products_by_filter_id($id) {

        $product_ids = ProductCharacteristicValue::whereCharacteristicValueId($id)->get()->keyBy('product_id')->keys();

        return Product::select('sku')->whereIn('id', $product_ids)->get()->keyBy('sku')->keys();

    }

    public static function mass_download($products) {

        info('-------------------------- MASS DOWNLOAD --------------------------');

        $s = Storage::disk('public');

        $size = 1000; // size for original images in PX

        foreach ($products as $data) {

//            if (!$s->exists('product/' . $data['sku'] . '.jpg')) { // if not exists original files, download from B2B

                $url = 'https://b2b-sandi.com.ua/imagecache/large/' . $data['sku'] . '.jpg';

                if (@getimagesize($url)) {

                    $contents = @Image::make($url)->contrast(5);

                    $contents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {

                        $constraint->aspectRatio();

                    })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);

                    $contents->save(public_path('storage/product/' . $data['sku']) . '.jpg'); // save original

                    info('created original for ' . $data['sku']);


                }

//            }

        }

    }

    public static function mass_download_additional($products) {

        info('-------------------------- MASS DOWNLOAD ADDITIONAL--------------------------');

        $s = Storage::disk('public');

        foreach ($products as $data) {

            foreach (['-1', '-2', '-3', '_1','_2','_3',] as $sufix) {

                //$url = 'https://b2b-sandi.com.ua/imagecache/large/' . $data['sku'] . $sufix . '.jpg';
                //https://b2b-sandi.com.ua/imagecache/large_w_w/2/1/21783/21783_1.jpg
                $url = 'https://b2b-sandi.com.ua/imagecache/large/' . substr($data['sku'], 0, 1) . '/' . substr($data['sku'], 1, 1) . '/' . $data['sku'] . '/' . $data['sku'] . $sufix . '.jpg';

                if (@getimagesize($url)) {

                    $contents = @Image::make($url);

                    info('download ' . $url);

                    $save_path = 'storage/product/'. $data['sku'] . '/';

                    if (!file_exists($save_path)) {

                        mkdir($save_path, 777, true);

                    }

                    $contents->save(public_path($save_path . $data['sku'] . $sufix) . '.jpg'); // save additional

                } else { info('empty ' . $url); }

            }

        }

    }

    public static function mass_generate($products) {

        info('-------------------------- MASS GENERATE --------------------------');

        $s = Storage::disk('public');

        $watermark = Image::make( $s->get('watermark.png') );

        foreach ($products as $data) {

            $product_path = null;

            $dir = 'product/' . $data['sku'];

            if ($s->exists($dir . '.png')) {

                $product_path = $dir . '.png';

            } elseif($s->exists($dir . '.jpg')) {

                $product_path = $dir . '.jpg';

            } else {

                //dd('NOT exists');

            }

            if (!empty($product_path)) {

                $contents = Image::make( $s->get($product_path) );

                if ($contents) {

                    $contents->insert($watermark, 'center');

                    foreach(['1000', '458', '237'] as $size) {
//                    foreach(['1000'] as $size) {

                        $tmp_contents = $contents;

                        foreach(['png', 'webp'] as $format) { // formats for resized images webp, png

                            $tmp_contents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {

                                $constraint->aspectRatio();

                            })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);

                            $tmp_contents->encode($format, 80)->save( public_path('storage/product/' . $size . '-' . $data['sku']) . '.' . $format);

                            info('created from ' . $product_path . ' => ' . $data['sku'] . ' ' . $size . ' ' . $format);

                        }

                    }

                }

            } else {

                info('Not exists original for - ' . $data['sku']);

            }

        }

    }

}
