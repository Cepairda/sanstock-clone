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
