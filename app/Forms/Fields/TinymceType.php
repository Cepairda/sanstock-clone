<?php

namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class TinymceType extends FormField
{
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'vendor.laravel-form-builder.textarea';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options = [
            'attr' => ['class' => config('laravel-form-builder.defaults.field_class') . ' tinymce'],
        ];

        return parent::render($options, $showLabel, $showField, $showError);
    }
}

