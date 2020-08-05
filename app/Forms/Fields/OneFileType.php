<?php

namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class OneFileType extends FormField
{
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'fields.one-file';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        preg_match('/data\[(.+)\]/', $this->getName(), $matches);
        $name = trim($matches[1]);

        $file = 'file-one-' . $name;

        $options = [
            'data-input' => $file,
            'attr' => [
                'class' => config('laravel-form-builder.defaults.field_class'),
                'id' => $file,
            ],
        ];

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
