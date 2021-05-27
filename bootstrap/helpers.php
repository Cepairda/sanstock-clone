<?php

use App\Resource;
use App\Classes\Image\Type\BaseType;

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($string, $enc = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) .
            mb_substr($string, 1, mb_strlen($string, $enc), $enc);
    }
}

if (!function_exists('to_select_options')) {
    function to_select_options($flat_tree)
    {
        return $flat_tree->mapWithKeys(function ($item) {
            $nesting = '- ';
            for ($i = 0; $i < $item->ancestors->count(); $i++) {
                $nesting .= ' - ';
            }
            return [$item->id => ($nesting . $item->getData('name'))];
        })->toArray();
    }
}

if (!function_exists('humanFileSize'))
{
    function humanFileSize($size, $unit = '') {
        if( (!$unit && $size >= 1 << 30) || $unit == 'GB')
            return number_format($size / (1 << 30),2) . ' GB';
        if( (!$unit && $size >= 1 << 20) || $unit == 'MB')
            return number_format($size / (1 << 20),2) . ' MB';
        if( (!$unit && $size >= 1 << 10) || $unit == 'KB')
            return number_format($size / (1 << 10),2) . ' KB';
        return number_format($size) . ' bytes';
    }
}

if (!function_exists('img')) {
    /**
     * @param string $type main|additional|defective|category
     * @param resource $resource need passed for - main: sdCode; additional: sdCode, sku, key; defective: sdCode, sku, key; category: ref
     * @param array $attributesHtml
     * @param int|null $size
     * @param int $key
     * @return string
     * @throws Exception
     */
    function img(string $type, Resource $resource, array $attributesHtml, int $size = null, int $key = 1): string
    {
        switch ($type) {
            case 'main':
                $path = "product/{$resource->sdCode}/{$resource->sdCode}";
                break;
            case 'additional':
                $path = "product/{$resource->sdCode}/additional/{$resource->sku}_{$key}";
                break;
            case 'defective':
                $path = "product/{$resource->sdCode}/{$resource->sku}/{$resource->sku}_{$key}";
                break;
            case 'category':
                $path = "category/{$resource['ref']}";
                break;
            default:
                throw new Exception('Not exists type');
        }

        $attributes = '';

        foreach ($attributesHtml as $name => $value) {
            $attributes .= "{$name}=\"{$value}\" ";
        }

        $path .= $size ?? "_{$size}";

        $src = '"' . asset('images/no_img.jpg') . '"';
        $dataSrc = '"' . asset('storage/' . $path) . '.jpg' . '"';
        $tag = "<img src={$src} data-src={$dataSrc} {$attributes} />";

        return $tag;
    }
}

if (!function_exists('xml_img')) {
    /**
     * Format text.
     *
     * @param  string  $text
     * @return string
     */

    function xml_img($data)
    {
//        return \App\Http\Controllers\ImageController::get_xml_image($data);

        return \App\Classes\ImportImage::getXmlImage($data);

    }

}

if (!function_exists('temp_img')) {
    /**
     * Format text.
     *
     * @param  string  $text
     * @return string
     */

    function temp_img($url)
    {

        if ( !@getimagesize($url) ) {

            return '<img style="height: 100%; width: 100%; opacity: 0.1;" src="/images/site/default.jpg" />';

        }

        return '<img src="' . $url . '" />';

    }
}

if (!function_exists('temp_xml_img')) {
    /**
     * Format text.
     *
     * @param  string  $text
     * @return string
     */

    function temp_xml_img($url)
    {

        if ( !@getimagesize($url) ) {

            return '/images/site/default.jpg';

        }

        return $url;

    }
}

if (!function_exists('temp_additional')) {
    /**
     * Format text.
     *
     * @param  string  $text
     * @return string
     */

    function temp_additional($sdKey, $firstAddition = false)
    {
        $additional = \App\ProductGroupImage::where('details->product_sd_code', $sdKey)->first();

        if (isset($additional) && $additional->getDetails('additional')) {
            if ($firstAddition) {
                return $additional->getDetails('additional')[1];
            }

            return $additional->getDetails('additional');
        }

        return [];
    }

    if (!function_exists('contains_access')) {
        function contains_access($name)
        {
            return auth()->user()->accesses->contains($name) ? true : false;
        }
    }
}
