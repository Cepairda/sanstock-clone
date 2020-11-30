<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Cache;
use Jenssegers\Agent\Agent;
use App\Product;
use App\Jobs\ProcessImportImage;

class ImportImage
{
    private const FORMAT_IMG_ORIGINAL = ['jpg', 'png', 'webp'];
    private static $formatImg;

    public static $params = [
        'defaultImg' => '/image/site/default.jpg'
    ];

    private static $init = false;

    private static function init()
    {
        set_time_limit(0);
        ini_set('memory_limit','5024M');

        self::$params['sizeMainImg'] = config('settings.import_image.main.size');
        self::$params['sizePreviewImg'] = config('settings.import_image.preview.size');
        self::$params['formatPreviewImg'] = config('settings.import_image.preview.format');
        self::$params['defaultImg'] = config('settings.import_image.defaultImg');

        self::$formatImg = array_combine(self::FORMAT_IMG_ORIGINAL, self::FORMAT_IMG_ORIGINAL);
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
        $product = Product::where('details->published', 1)->where('details->sku', $sku)->first();

        if (!empty($product)) {
            self::downloadMainImage($product);
            self::generatePreview($product);
            self::downloadAdditional($product);
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
        $s = Storage::disk('public');
        $size = self::$params['sizeMainImg']; // size for original images in PX

//            if (!$s->exists('product/' . $data['sku'] . '.jpg')) { // if not exists original files, download from B2B

        $url = 'https://b2b-sandi.com.ua/imagecache/large/' . $product->getDetails('sku') . '.' . self::$formatImg['jpg'];

        if (@getimagesize($url)) {
            $contents = @Image::make($url)->contrast(5);
            $contents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {
                $constraint->aspectRatio();
            })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);
            $contents->save(public_path('storage/product/' . $product->getDetails('sku')) . '.' . self::$formatImg['jpg']); // save original
        }
//            }
    }

    private static function downloadAdditional($product)
    {
        $s = Storage::disk('public');
        $sufixs = [];

        for ($i = 1; $i <= 15; $i++) {
            $sufixs[] = '-' . $i;
            $sufixs[] = '_' . $i;
        }

        foreach ($sufixs as $sufix) {
            $url = 'https://b2b-sandi.com.ua/imagecache/large/' .
                substr($product->getDetails('sku'), 0, 1) . '/' .
                substr($product->getDetails('sku'), 1, 1) . '/' .
                $product->getDetails('sku') . '/' . $product->getDetails('sku') .
                $sufix . '.' . self::$formatImg['jpg'];

            if (@getimagesize($url)) {
                $contents = @Image::make($url);
                $path = 'storage/product/'. $product->getDetails('sku') . '/';
                $savePath = public_path($path);

                if (!file_exists($savePath)) {
                    mkdir($savePath, 0777, true);

                }

                $contents->save(public_path($path . $product->getDetails('sku') . $sufix) . '.' . self::$formatImg['jpg']); // save additional
            }
        }
    }

    private static function generatePreview($product)
    {
        $s = Storage::disk('public');
        $sizes = config('settings.import_image.preview.size');
        $formats = config('settings.import_image.preview.format');

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
