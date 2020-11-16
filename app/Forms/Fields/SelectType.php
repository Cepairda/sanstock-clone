<?php

namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;;

class SelectType extends FormField
{

    /**
     * The name of the property that holds the value.
     *
     * @var string
     */
    protected $valueProperty = 'selected';

     /**
     * @inheritdoc
     */
    protected function getTemplate()
    {
        return 'vendor.laravel-form-builder.select';
    }

    /**
     * @inheritdoc
     */
    public function getDefaults()
    {
        return [
            'choices' => [],
            'empty_value' => null,
            'selected' => null,
            'option_attributes' => []
        ];
    }
}
