<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use App\Characteristic;
use App\CharacteristicGroup;
use Kris\LaravelFormBuilder\Form;

class SubCharacteristicGroupForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getData('resource');
        $characteristic = $this->getData('characteristic');

        $this
            ->add('use', 'checkbox', [
                'label' => false,
                'checked' => $resource->getDetails('characteristics')[$characteristic->id]['use'] ?? null
            ])
            ->add('filter', 'checkbox', [
                'label' => false,
                'checked' => $resource->getDetails('characteristics')[$characteristic->id]['filter'] ?? null
            ])
            ->add('sort', 'number', [
                'label' => false,
                'rules' => ['required'],
                'value' => $resource->getDetails('characteristics')[$characteristic->id]['sort'] ?? 0
            ])
            ->add('id', 'hidden', [
                'rules' => ['required'],
                'value' => $characteristic->id,
            ]);
    }
}
