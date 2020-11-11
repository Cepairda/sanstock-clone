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
        $characteristics = Characteristic::joinLocalization()->get();
        $characteristic = $this->getData('characteristic');

        //foreach ($characteristics as $characteristic) {
            $this
                ->add('use', 'checkbox', [
                    'label' => $characteristic->getData('name'),
                    'checked' => $resource->getDetails('characteristics')[$characteristic->id]['use'] ?? null
                ])
                ->add('filter', 'checkbox', [
                    'label' => $characteristic->getData('name'),
                    'checked' => $resource->getDetails('characteristics')[$characteristic->id]['filter'] ?? null
                ])
                ->add('details[characteristics][' . $characteristic->id .'][sort]', 'text', [
                    'label' => $characteristic->getData('name'),
                    //'rules' => ['required'],
                    'value' => $resource->getDetails('characteristics')[$characteristic->id]['sort'] ?? null
                ])
                ->add('details[characteristics][' . $characteristic->id .'][id]', 'hidden', [
                    'label' => 'Name',
                    'rules' => ['required'],
                    'value' => $characteristic->id,
                ]);
        //}
    }
}
