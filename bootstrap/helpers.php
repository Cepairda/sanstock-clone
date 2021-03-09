<?php

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
     * Format text.
     *
     * @param  string  $text
     * @return string
     */

    function img($data)
    {
        $ikey = $data['size'] . '-' . $data['sku'];

//        if (Cache::has($ikey) ) {
//            return Cache::get($ikey);
//        }

        if (!empty($data)) {
            $class = !empty($data['class']) ? ' class="' . implode(' ', $data['class']) . '"' : '';
            $alt = !empty($data['alt']) ? ' alt="' . htmlspecialchars($data['alt']) . '"': '';

            if (isset($data['data-src'])) {
                $uri = 'data-src="' . \App\Classes\ImportImage::getImage($data) . '" src="' . asset('images/site/default_white.jpg') . '"';
            } else {
                $uri = ' src="' . \App\Classes\ImportImage::getImage($data) . '"';
            }

            $tag = '<img' . $class . $alt . $uri . ' />';

            Cache::put($ikey, $tag, now()->addMinutes(60));

            return $tag;
        } else {
            return null;
        }
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

    function temp_additional($sku, $firstAddition = false)
    {

//        $data = [];
//
//        $s = Storage::disk('public');
//
//        $additional_path = 'storage/product/' . $sku . '/';
//
//        if (file_exists($additional_path)) {
//
//            foreach (['-1', '-2', '-3', '_1', '_2', '_3',] as $sufix) {
//
//                $file_path = 'product/' . $sku . '/' . $sku . $sufix . '.jpg';
//
//                if ($s->exists($file_path)) {
//
//                    $data[] = asset('/storage/' . $file_path);
//
//                    if ($firstAddition) {
//                        break;
//                    }
//                }
//
//            }
//
//        }

        $additional = \App\ProductImage::where('details->product_sku', $sku)->first();

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
