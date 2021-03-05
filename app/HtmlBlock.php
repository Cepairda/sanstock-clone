<?php

namespace App;

class HtmlBlock extends Resource
{
    public function getBlockNameAttribute()
    {
        return $this->getDetails('block_name');
    }

    public function getHtmlAttribute()
    {
        return $this->getData('html');
    }

    public static function replaceShortCode($content)
    {
        if (preg_match('/\[block:(.+?)\]/i', $content, $matches)) {
            $block = $matches[1];

            return preg_replace_callback(
                '/\[block:(.+?)\]/i',
                function ($matches) {
                    return HtmlBlock::getBlock(trim($matches[1]));
                },
                $content
            );
        }

        return $content;
    }

    public static function getBlock($name)
    {
        if ($block = HtmlBlock::joinLocalization()->where('id', $name)->orWhere('details->block_name', $name)->first()) {
            return $block->html;
        }

        return '';
    }
}
