<?php

namespace App\Classes;

use App\Category;
use GuzzleHttp\Client;
use Storage;
use File;
use Image;
use Cache;
use Jenssegers\Agent\Agent;
use App\Jobs\ProcessImportImageCategory;

class ImportImageCategory
{
    private const DEFAULT_API_URL = 'https://b2b-sandi.com.ua/api/categories';

    private const FORMAT_IMG_ORIGINAL = ['jpg', 'png', 'webp'];
    private static $formatImg;
    private static $imageRegister;
    private static $apiProductImage;

    public static $params = [
        'defaultImg' => '/image/site/default.jpg'
    ];

    private static $init = false;

    private static function init()
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit','5024M');

        self::$params['sizeMainImg'] = config('settings-file.import_image.main.size');
        self::$params['sizePreviewImg'] = config('settings-file.import_image.preview.size');
        self::$params['formatPreviewImg'] = config('settings-file.import_image.preview.format');
        self::$params['defaultImg'] = config('settings-file.import_image.defaultImg');

        self::$formatImg = array_combine(self::FORMAT_IMG_ORIGINAL, self::FORMAT_IMG_ORIGINAL);

        $apiUrl = self::DEFAULT_API_URL;
        self::$imageRegister = self::getDataJson($apiUrl);
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
        $categories = isset($ids)
            ? Category::where('details->published', 0)->whereIn('details->sku', explode(',', $ids))->get()
            : Category::get();

        foreach ($categories as $category) {
            ProcessImportImageCategory::dispatch($category->getDetails('ref'))->onQueue('imageCategoryImport');
        }
    }

    private static function import($ref)
    {
        $category = Category::where('details->ref', $ref)->first();

        if (!empty($category)) {
            self::$apiProductImage = self::$imageRegister[$ref];
        }

        self::downloadMainImage($ref);

        sleep(1);
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

    public static function getImage($data)
    {


        if (session()->exists('images_format')) {
            $data['format'] = session('images_format');
        } else {
            $agent = new Agent();
//            $imagesFormat = ($agent->is('iPhone') || $agent->is('OS X')) ? self::$formatImg['png'] : self::$formatImg['webp'];
            //$imagesFormat = ($agent->is('iPhone') || $agent->is('OS X')) ? 'jpg' : 'jpg';
            $imagesFormat = 'jpg';
            $data['format'] = $imagesFormat;

            session(['images_format' => $imagesFormat]);
        }

        $s = Storage::disk('public');

        if (isset($data['additional'])) {
            $filePath = '/' . $data['type'] . '/' . $data['sku'] . '/' . $data['size'] . '-' . $data['sku'] . '_' . $data['key'] . '.' . $data['format'];
        } else {
            $filePath = '/' . $data['type'] . '/' . $data['size'] . '-' . $data['sku'] . '.' . $data['format'];
        }

        if ($data['type'] == 'product') {
            if ($s->exists($filePath)) {
                return asset('/storage' . $filePath);
            } else {
                //self::create($data);
                //dd($filePath);
                return asset('/images/site/' . $data['size'] . '-default.jpg');
            }
        }

        if ($data['type'] == 'category') {
            if ($s->exists($filePath)) {
                return asset('/storage' . $filePath);
            } else {
                $data['original'] = $data['name'] . '.' .  'jpg';
                //self::create($data);
                return asset('/images/site/default.jpg');
            }
        }

        return  asset('/images/site/default.jpg');
    }

    private static function downloadMainImage($ref)
    {
        $mainImagePath = self::$apiProductImage['image'] ?? null;
        $size = self::$params['sizeMainImg']; // size for original images in PX
        $isEmpty = stripos($mainImagePath, 'no_img.jpg');

        if (isset($mainImagePath) && !$isEmpty) {
            $path = 'storage/category/';
            $pathMainImg = public_path($path . $ref) . '.' . self::$formatImg['jpg'];

            $contents = Image::make($mainImagePath)->contrast(5);
            $contents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {
                $constraint->aspectRatio();
            })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);

            $savePath = public_path($path);

            if (!file_exists($savePath)) {
                mkdir($savePath, 0777, true);
            }

            $contents->save($pathMainImg); // save original
            //self::generatePreview($product);
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

                    $tmpContents = clone $contents;

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

    public static function getDataJson(string $apiUrl) : array
    {
        $client = new Client();
        $res = $client->request('GET', $apiUrl);
        $prices = json_decode($res->getBody(), true);

        return $prices;
    }
}
