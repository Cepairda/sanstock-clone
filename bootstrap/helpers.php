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

        if (Cache::has($ikey) ) {
            return Cache::get($ikey);
        }

        if (!empty($data)) {
            $class = !empty($data['class']) ? ' class="' . implode(' ', $data['class']) . '"' : '';
            $alt = !empty($data['alt']) ? ' alt="' . $data['alt'] . '"': '';
            $uri = ' src="' . \App\Classes\ImportImage::getImage($data) . '"';

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
        return \App\Http\Controllers\ImageController::get_xml_image($data);
    }

}
