<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Cache;
use Jenssegers\Agent\Agent;

class ImportImage
{
    private const FORMAT_IMG_ORIGINAL = ['jpg', 'png', 'webp'];
    private static $formatImg;

    private static $params = [];
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

    private static function getXmlImage($data) {

        $data['format'] = 'webp';

        $s = Storage::disk('public');

        $filePath = '/' . $data['type'] . '/' . $data['size'] . '-' . $data['name'] . '.' . $data['format'];

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
            $imagesFormat = ($agent->is('iPhone') || $agent->is('OS X')) ? self::$formatImg['png'] : self::$formatImg['webp'];
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
                return asset(self::$params['defaultImg']);
            }
        }

        if ($data['type'] == 'category') {
            if ($s->exists($filePath)) {
                return asset('/storage' . $filePath);
            } else {
                $data['original'] = $data['name'] . '.' .  self::$formatImg['jpg'];
                //self::create($data);

                return asset(self::$params['defaultImg']);
            }
        }

        return  asset(self::$params['defaultImg']);
    }

    private static function downloadMainImage($products)
    {
        $s = Storage::disk('public');
        $size = self::$params['sizeMainImg']; // size for original images in PX

        foreach ($products as $data) {
//            if (!$s->exists('product/' . $data['sku'] . '.jpg')) { // if not exists original files, download from B2B

            $url = 'https://b2b-sandi.com.ua/imagecache/large/' . $data['sku'] . '.' . self::$formatImg['jpg'];

            if (@getimagesize($url)) {
                $contents = @Image::make($url)->contrast(5);
                $contents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {
                    $constraint->aspectRatio();
                })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);
                $contents->save(public_path('storage/product/' . $data['sku']) . '.' . self::$formatImg['jpg']); // save original
            }
//            }
        }
    }

    private static function downloadAdditional($products)
    {
        $s = Storage::disk('public');
        $sufixs = [];

        for ($i = 1; $i <= 15; $i++) {
            $sufixs[] = '-' . $i;
            $sufixs[] = '_' . $i;
        }

        foreach ($products as $data) {
            foreach ($sufixs as $sufix) {
                $url = 'https://b2b-sandi.com.ua/imagecache/large/' .
                    substr($data['sku'], 0, 1) . '/' .
                    substr($data['sku'], 1, 1) . '/' .
                    $data['sku'] . '/' . $data['sku'] .
                    $sufix . '.' . self::$formatImg['jpg'];

                if (@getimagesize($url)) {
                    $contents = @Image::make($url);
                    $savePath = 'storage/product/'. $data['sku'] . '/';

                    if (!file_exists($savePath)) {
                        mkdir($savePath);
                    }

                    $contents->save(public_path($savePath . $data['sku'] . $sufix) . '.' . self::$formatImg['jpg']); // save additional
                }
            }
        }
    }

    private static function generatePreview($products)
    {
        $s = Storage::disk('public');
        $sizes = config('settings.import_image.preview.size');
        $formats = config('settings.import_image.preview.format');

        //$watermark = Image::make( $s->get('watermark.png') );

        foreach ($products as $data) {
            $productPath = null;

            $dir = 'product/' . $data['sku'];

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

                            $tmpContents->encode($format, 80)->save( public_path('storage/product/' . $size . '-' . $data['sku']) . '.' . $format);
                        }
                    }
                }
            }
        }
    }

    private static function import($products)
    {
        self::downloadMainImage($products);
        self::generatePreview($products);
        self::downloadAdditional($products);
    }
}
