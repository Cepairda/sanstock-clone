<?php

namespace App\Classes;

use App\ProductImage;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Cache;
use Jenssegers\Agent\Agent;
use App\Product;
use App\Jobs\ProcessImportImage;
use Illuminate\Support\Facades\DB;

class ImportImage
{
    private const FORMAT_IMG_ORIGINAL = ['jpg', 'png', 'webp'];
    private static $formatImg;

    private static $imageRegister;
    private static $imageRegisterUrl;

    private static $apiProductImage;
    private static $dbProductImage;
    private static $requestProductImage;

    public static $params = [
        'defaultImg' => '/image/site/default.jpg'
    ];

    private static $init = false;

    private static function init()
    {
        set_time_limit(0);
        ini_set('memory_limit','5024M');

        self::$params['sizeMainImg'] = config('settings-file.import_image.main.size');
        self::$params['sizePreviewImg'] = config('settings-file.import_image.preview.size');
        self::$params['formatPreviewImg'] = config('settings-file.import_image.preview.format');
        self::$params['defaultImg'] = config('settings-file.import_image.defaultImg');

        self::$formatImg = array_combine(self::FORMAT_IMG_ORIGINAL, self::FORMAT_IMG_ORIGINAL);

        self::$imageRegisterUrl = 'https://isw.b2b-sandi.com.ua/imagecache/full';

        $client = new Client();
        $res = $client->request('GET', 'https://b2b-sandi.com.ua/api/products/images/register');

        self::$imageRegister = json_decode($res->getBody(), true);
    }

    public static function __callStatic($name, $arguments)
    {
        if (!self::$init) {
            self::init();
            self::$init = true;
        }

        return call_user_func_array(
            array(self::class, $name),
            $arguments
        );
    }

    public static function addToQueue($ids = null)
    {
        $products = isset($ids)
            ? Product::where('details->published', 1)->whereIn('id', $ids)->get()
            : Product::where('details->published', 1)->get();

        foreach ($products as $product) {
            ProcessImportImage::dispatch($product->getDetails('sku'))->onQueue('imageImport');
        }
    }

    private static function import($sku)
    {
        $sku = 21650;
        $product = Product::where('details->published', 1)->where('details->sku', $sku)->first();

        if (!empty($product)) {
            self::$apiProductImage = self::$imageRegister[$sku];
            //dd(self::$imageRegister[$sku]);
            self::$dbProductImage = ProductImage::where('details->product_sku', $sku)->first();

            if (!self::$dbProductImage) {
                self::$dbProductImage = new ProductImage();
                self::$dbProductImage->setRequest([
                    'details' => [
                        'product_sku' => $sku
                    ]
                ]);
                self::$dbProductImage->storeOrUpdate();
            }

            //self::$dbProductImage = ProductImage::firstOrCreate(['details->product_sku' => $sku]);

            self::downloadMainImage($product);
            self::generatePreview($product);
            //self::downloadAdditional($product);

            //$mainImage = isset(self::$requestProductImage['details']['main']) ? self::$requestProductImage['details']['main'] : self::$dbProductImage['details']['main'];
            //$additionalImage = isset(self::$requestProductImage['details']['additional']) ? self::$requestProductImage['details']['additional'] : self::$dbProductImage['details']['additional'];
            //$request = [
            //    'details' =>
            //];
            self::$requestProductImage['details']['product_sku'] = $sku;
            self::$dbProductImage->setRequest(self::$requestProductImage);
            self::$dbProductImage->storeOrUpdate();
        }
    }

    public static function getXmlImage($data) {

        $data['format'] = 'webp';

        $s = Storage::disk('public');

        $filePath = '/' . $data['type'] . '/' . $data['size'] . '-' . $data['sku'] . '.' . $data['format'];

        if ($data['type'] == 'product') {
            if ($s->exists($filePath)) {
                return asset('/storage' . $filePath);
            } else {
                //self::create($data);
                return asset(self::$params['defaultImg']);
            }
        }

        if ($data['type'] == 'category') {
            if ($s->exists($filePath)) {
                return asset('/storage' . $filePath);
            } else {
                //self::create($data);
                return asset(self::$params['defaultImg']);
            }
        }

        return  asset(self::$params['defaultImg']);
    }

    private static function getImage($data)
    {


        if (session()->exists('images_format')) {
            $data['format'] = session('images_format');
        } else {
            $agent = new Agent();
//            $imagesFormat = ($agent->is('iPhone') || $agent->is('OS X')) ? self::$formatImg['png'] : self::$formatImg['webp'];
            $imagesFormat = ($agent->is('iPhone') || $agent->is('OS X')) ? self::$formatImg['jpg'] : self::$formatImg['jpg'];
            $data['format'] = $imagesFormat;

            session(['images_format' => $imagesFormat]);
        }

        $s = Storage::disk('public');

        $filePath = '/' . $data['type'] . '/' . $data['size'] . '-' . $data['sku'] . '.' . $data['format'];

        if ($data['type'] == 'product') {
            if ($s->exists($filePath)) {
                return asset('/storage' . $filePath);
            } else {
                //self::create($data);
                return asset('/images/site/default.jpg');
            }
        }

        if ($data['type'] == 'category') {
            if ($s->exists($filePath)) {
                return asset('/storage' . $filePath);
            } else {
                $data['original'] = $data['name'] . '.' .  self::$formatImg['jpg'];
                //self::create($data);
                return asset('/images/site/default.jpg');
            }
        }

        return  asset('/images/site/default.jpg');
    }

    private static function downloadMainImage($product)
    {
        $size = self::$params['sizeMainImg']; // size for original images in PX
        $url = self::$imageRegisterUrl . self::$apiProductImage['main']['path'];

        if (self::$apiProductImage['main']['filemtime'] != (self::$dbProductImage['main']['filemtime'] ?? null)) {
            $contents = @Image::make($url)->contrast(5);
            $contents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {
                $constraint->aspectRatio();
            })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);
            $contents->save(public_path('storage/product/' . $product->getDetails('sku')) . '.' . self::$formatImg['jpg']); // save original

            self::$requestProductImage['details']['main']['filemtime'] = self::$apiProductImage['main']['filemtime'];
//            ProductImage::where('details->product_sku', $product->getDetails('sku'))->update([
//                    //'details->product_sku' => $product->getDetails('sku'),
//                    'details->main' => [
//                        'filemtime' => self::$apiProductImage['main']['filemtime']
//                    ],//self::$apiProductImage['main']['filemtime']
//            ]);

            //$query = 'UPDATE `resources`
            //    SET `details` = JSON_SET(`details`, "$.main.n", "' . self::$apiProductImage['main']['filemtime'] . '") WHERE JSON_EXTRACT(`details`, "$.product_sku") = "21650"';

            //$query = 'UPDATE `resources`
            //    SET `details` = JSON_SET(`details`, "$.main", "23223") WHERE JSON_EXTRACT(`details`, "$.product_sku") = "21650"';
            //DB::statement($query);

//            Product::where('details->sku', $item['sku'])->update([
//                'details->price' => $item['discount_price'] ?? $item['price'],
//                'details->price_updated_at' => Carbon::now(),
//                'details->old_price' => isset($item['discount_price']) ? $item['price'] : null
//            ]);
        } elseif (self::$apiProductImage['main']['filemtime'] == (self::$dbProductImage['main']['filemtime'] ?? null)) {
            self::$requestProductImage['details']['main']['filemtime'] = self::$dbProductImage['details']['main']['filemtime'];
        }
    }

    private static function downloadAdditional($product)
    {
        foreach (self::$apiProductImage['additional'] as $key => $additional) {
            if ($additional['filemtime'] != (self::$dbProductImage['additional'][$key]['filemtime'] ?? null)) {
                $url = self::$imageRegisterUrl . $additional['path'];
                $contents = @Image::make($url);
                $path = 'storage/product/' . $product->getDetails('sku') . '/';
                $savePath = public_path($path);

                if (!file_exists($savePath)) {
                    mkdir($savePath, 0777, true);

                }

                $contents->save(public_path($path . $product->getDetails('sku') . '_' . $key) . '.' . self::$formatImg['jpg']); // save additional

                //self::$requestProductImage['details']['additional'][$key]['filemtime'] = $additional['filemtime'];
                ProductImage::where('details->product_sku', $product->getDetails('sku'))->update([
                    //'details->product_sku' => $product->getDetails('sku'),
                    'details->main->' . $key . '->filemtime' => self::$apiProductImage['main']['filemtime']
                ]);
            }
        }
    }

    private static function generatePreview($product)
    {
        $s = Storage::disk('public');
        $sizes = config('settings-file.import_image.preview.size');
        $formats = config('settings-file.import_image.preview.format');

        //$watermark = Image::make( $s->get('watermark.png') );

        $productPath = null;

        $dir = 'product/' . $product->getDetails('sku');

        if ($s->exists($dir . '.' . self::$formatImg['png'])) {
            $productPath = $dir . '.' . self::$formatImg['png'];
        } elseif ($s->exists($dir . '.' . self::$formatImg['jpg'])) {
            $productPath = $dir . '.' . self::$formatImg['jpg'];
        }

        if (!empty($productPath)) {
            $contents = Image::make( $s->get($productPath) );

            if ($contents) {
                //$contents->insert($watermark, 'center');

                foreach($sizes as $size) {
                    $tmpContents = $contents;

                    foreach($formats as $format) { // formats for resized images webp, png
                        $tmpContents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {
                            $constraint->aspectRatio();
                        })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);

                        $tmpContents->encode($format, 80)->save( public_path('storage/product/' . $size . '-' . $product->getDetails('sku')) . '.' . $format);
                    }
                }
            }
        }
    }
}
