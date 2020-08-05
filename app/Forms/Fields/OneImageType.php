<?php

namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class OneImageType extends FormField
{
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'fields.one-image';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        preg_match('/data\[(.+)\]/', $this->getName(), $matches);
        $name = trim($matches[1]);

        $thumbnail = 'thumbnail-one-' . $name;

        $options = [
            'data-input' => $thumbnail,
            'data-preview' => 'holder-one-' . $name,
            'attr' => [
                'class' => config('laravel-form-builder.defaults.field_class'),
                'id' => $thumbnail,
            ],
        ];

        return parent::render($options, $showLabel, $showField, $showError);
    }
}

