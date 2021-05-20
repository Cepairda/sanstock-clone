<?php

namespace App\Classes;

use App\ProductGroupImage;
use App\ProductImage;
use GuzzleHttp\Client;
use PhpParser\Node\Expr\Cast\Object_;
use Storage;
use File;
use Image;
use Cache;
use Jenssegers\Agent\Agent;
use App\Product;
use App\Jobs\ProcessImportImage;

/**
 * Class ImportImage
 * @package App\Classes
 */
class ImportImage
{

    private const DEFAULT_API_URL = 'http://94.131.241.126/api/products?token=368dbc0bf4008db706576eb624e14abf&only_defectives=1';
    private const FORMAT_IMG_ORIGINAL = ['jpg', 'png', 'webp'];

    private static $formatImg;
    private static $imageRegister;
    private static $apiProductImage;

    private static $dbProductImage;
    private static $requestProductImage;

    private static $dbProductGroupImage;
    private static $requestProductGroupImage;

    public static $params = [
        'defaultImg' => '/image/site/default.jpg'
    ];

    private static $init = false;

    /**
     * @return void
     */
    private static function init(): void
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit','5024M');

        self::$params['sizeMainImg'] = config('settings-file.import_image.main.size');
        self::$params['sizePreviewImg'] = config('settings-file.import_image.preview.size');
        self::$params['formatPreviewImg'] = config('settings-file.import_image.preview.format');
        self::$params['defaultImg'] = config('settings-file.import_image.defaultImg');

        self::$formatImg = array_combine(self::FORMAT_IMG_ORIGINAL, self::FORMAT_IMG_ORIGINAL);
    }

    /**
     * @param string$name
     * @param array $arguments
     * @return false|mixed
     */
    public static function __callStatic(string $name, array $arguments)
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

    /**
     * @param array|null $ids
     * @return void
     */
    public static function addToQueue(array $ids = null): void
    {
        $products = isset($ids)
            ? Product::where('details->published', 1)->whereIn('details->sku', explode(',', $ids))->get()
            : Product::where('details->published', 0)->get();

        foreach ($products as $product) {
            ProcessImportImage::dispatch($product->getDetails('sku'))->onQueue('imageImport');
        }
    }

    /**
     * @param int $sku
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private static function import(int $sku): void
    {
        $product = Product::where('details->published', 0)->where('details->sku', $sku)->first();
        $sdCode = $product->sdCode;

        if (!empty($product)) {
            info('Ins Img');
            $apiUrl = self::DEFAULT_API_URL . "&sku_in={$sku}";
            self::$imageRegister = self::getDataJson($apiUrl);
            self::$apiProductImage = self::$imageRegister;
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

            self::$dbProductGroupImage = ProductGroupImage::where('details->product_sd_code', $sdCode)->first();

            if (!self::$dbProductGroupImage) {
                self::$dbProductGroupImage = new ProductGroupImage();
                self::$dbProductGroupImage->setRequest([
                    'details' => [
                        'product_sd_code' => $sdCode
                    ]
                ]);
                self::$dbProductGroupImage->storeOrUpdate();
            }

            self::downloadMainImage($sdCode, $sku);
            self::downloadAdditional($sdCode, $sku);
            self::downloadDefectiveImages($sdCode, $sku);

            self::$requestProductImage['details']['product_sku'] = $sku;
            self::$dbProductImage->setRequest(self::$requestProductImage);
            self::$dbProductImage->storeOrUpdate();

            self::$requestProductGroupImage['details']['product_sd_code'] = $sdCode;
            self::$dbProductGroupImage->setRequest(self::$requestProductGroupImage);
            self::$dbProductGroupImage->storeOrUpdate();

            self::$apiProductImage = null;
            self::$requestProductImage = null;
            self::$dbProductImage = null;
            self::$requestProductGroupImage = null;
            self::$dbProductGroupImage = null;

            sleep(1);
        }
    }

    /**
     * @param $data
     * @return string
     */
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

    /**
     * @param $data
     * @return string
     */
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

    /**
     * @param string $sdCode
     * @param int $sku
     * @return void
     */
    private static function downloadMainImage(string $sdCode, int $sku): void
    {
        $mainImagePath = self::$apiProductImage['data'][$sku]['images']['main'] ?? null;
        $size = self::$params['sizeMainImg']; // size for original images in PX

        if (isset($mainImagePath)) {
            $urlString = parse_url($mainImagePath);
            parse_str($urlString['query'], $params);
            $timeImageUpdateMd5 = $params['hash'];

            $pathSdCode = 'storage/product/' . $sdCode . '/';
            $publicPathImg = public_path($pathSdCode . $sdCode);
            $pathMainImg = $publicPathImg . '.' . self::$formatImg['jpg'];

            if ($timeImageUpdateMd5 != (self::$dbProductGroupImage['details']['main']['filemtime_md5'] ?? null)
                || !file_exists($pathMainImg)
            ) {
                $contents = Image::make($mainImagePath)->contrast(5);
                $contents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {
                    $constraint->aspectRatio();
                })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);

                $savePathSdCode = public_path($pathSdCode);

                if (!file_exists($savePathSdCode)) {
                    mkdir($savePathSdCode, 0777, true);
                }

                $contents->save($pathMainImg); // save original

                self::$requestProductGroupImage['details']['main']['filemtime_md5'] = $timeImageUpdateMd5;
                self::generatePreview($publicPathImg, clone $contents);
            } elseif ($timeImageUpdateMd5 == (self::$dbProductGroupImage['details']['main']['filemtime_md5'] ?? null)) {
                self::$requestProductGroupImage['details']['main']['filemtime_md5'] = $timeImageUpdateMd5;
            }
        }
    }

    /**
     * @param string $sdCode
     * @param int $sku
     * @return void
     */
    private static function downloadAdditional(string $sdCode, int $sku): void
    {
        $additionalImages = self::$apiProductImage['data'][$sku]['images']['additional'] ?? null;

        if (isset($additionalImages)) {
            foreach ($additionalImages as $key => $imagePath) {
                $urlString = parse_url($imagePath);
                parse_str($urlString['query'], $params);
                $timeImageUpdateMd5 = $params['hash'];

                $pathSdCode = 'storage/product/' . $sdCode . '/';
                $pathAdditional = $pathSdCode . 'additional/';
                $publicPathImg = public_path($pathAdditional . $sdCode . '_' . $key);
                $pathAddImg =  $publicPathImg . '.' . self::$formatImg['jpg'];

                if ($timeImageUpdateMd5 != (self::$dbProductGroupImage['details']['additional'][$key]['filemtime_md5'] ?? null)
                    || !file_exists($pathAddImg)
                ) {
                    $url = $imagePath;
                    $contents = Image::make($url);
                    $savePathSdCode = public_path($pathSdCode);
                    $savePathAdditional = public_path($pathAdditional);

                    if (!file_exists($savePathSdCode)) {
                        mkdir($savePathSdCode, 0777, true);
                    }

                    if (!file_exists($savePathAdditional)) {
                        mkdir($savePathAdditional, 0777, true);
                    }

                    $contents->save($pathAddImg); // save additional
                    self::generatePreview($publicPathImg, clone $contents);
                }

                self::$requestProductGroupImage['details']['additional'][$key]['filemtime_md5'] = $timeImageUpdateMd5;
            }
        } else {
            self::$requestProductGroupImage['details']['additional'] = null;
        }
    }

    /**
     * @param string $sdCode
     * @param int $sku
     * @return void
     */
    private static function downloadDefectiveImages(string $sdCode, int $sku): void
    {
        $defectiveImages = self::$apiProductImage['data'][$sku]['main']['defective_attributes']['images'] ?? null;
        if (isset($defectiveImages)) {
            foreach ($defectiveImages as $key => $imagePath) {
                $urlString = parse_url($imagePath);
                parse_str($urlString['query'], $params);
                $timeImageUpdateMd5 = $params['hash'];

                $pathSdCode = 'storage/product/' . $sdCode . '/';
                $pathSku = $pathSdCode . $sku . '/';
                $publicPathImg = public_path($pathSku . $sku . '_' . $key);
                $pathAddImg = $publicPathImg . '.' . self::$formatImg['jpg'];

                if ($timeImageUpdateMd5 != (self::$dbProductImage['details']['additional'][$key]['filemtime_md5'] ?? null)
                    || !file_exists($pathAddImg)
                ) {
                    $url = $imagePath;
                    $contents = Image::make($url);
                    $savePathSdCode = public_path($pathSdCode);
                    $savePathSku = public_path($pathSku);

                    if (!file_exists($savePathSdCode)) {
                        mkdir($savePathSdCode, 0777, true);
                    }

                    if (!file_exists($savePathSku)) {
                        mkdir($savePathSku, 0777, true);
                    }

                    $contents->save($pathAddImg); // save additional
                    self::generatePreview($publicPathImg, clone $contents);
                }

                self::$requestProductImage['details']['additional'][$key]['filemtime_md5'] = $timeImageUpdateMd5;
            }
        }
    }

    /**
     * @param string $publicPathImg
     * @param object $contents Object of type Image
     * @return void
     */
    private static function generatePreview(string $publicPathImg, object $contents): void
    {
        $sizes = config('settings-file.import_image.preview.size');
        $formats = config('settings-file.import_image.preview.format');

        if ($contents) {
            foreach($sizes as $size) {
                $tmpContents = clone $contents;

                foreach($formats as $format) { // formats for resized images webp, png
                    $tmpContents->trim(null, null, 5, 50)->resize($size, $size, function ($constraint) {
                        $constraint->aspectRatio();
                    })->resizeCanvas($size, $size, 'center', false, [255, 255, 255, 0]);

                    $tmpContents->encode($format, 90)->save($publicPathImg . '-' . $size . '.' . $format);
                }
            }
        }
    }

    /**
     * @param string $apiUrl
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getDataJson(string $apiUrl): array
    {
        $client = new Client();
        $res = $client->request('GET', $apiUrl);
        $prices = json_decode($res->getBody(), true);

        return $prices;
    }
}
