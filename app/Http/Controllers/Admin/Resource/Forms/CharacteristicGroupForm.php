<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use App\Characteristic;
use Kris\LaravelFormBuilder\Form;

class CharacteristicGroupForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $characteristics = Characteristic::joinLocalization()->get();
        $categories = Category::joinLocalization()->with('ancestors')->get()->toFlatTree();
        $categoryChoices = to_select_options($categories);
        $categoryIds = $resource->categories()->get()->keyBy('id')->keys();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('data[name]', 'text', [
                'label' => 'Название',
                'value' => $resource->getData('name'),
            ])
            ->add('relations[App\Category]', 'choice', [
                'multiple' => true,
                'label' => 'Категории',
                'choices' => $categoryChoices,
                'selected' => $categoryIds,
                'disabled' => [4],
                'option_attributes' => [8 => [ 'disabled' => 'disabled', 'style' => 'border: 1px solid red;' ]],
                'attr' => [
                    'class' => 'select2bs4 form-control',
                ],
            ]);

            /*foreach ($characteristics as $characteristic) {
                $this
                    ->add('details[characteristics][' . $characteristic->id .'][use]', 'checkbox', [
                        'label' => $characteristic->getData('name'),
                        //'rules' => ['required'],
                        'checked' => $resource->getDetails('characteristics')[$characteristic->id]['use'] ?? null
                    ])
                    ->add('details[characteristics][' . $characteristic->id .'][filter]', 'checkbox', [
                        'label' => $characteristic->getData('name'),
                        //'rules' => ['required'],
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
            }*/


            foreach ($characteristics as $characteristic) {
                $this->add('details[characteristics][' . $characteristic->id .']', 'form', [
                    'class' => 'App\Http\Controllers\Admin\Resource\Forms\SubCharacteristicGroupForm',
                    //'class' => $this->formBuilder->create('App\Http\Controllers\Admin\Resource\Forms\SubCharacteristicGroupForm'),
                    'formOptions' => [],
                    'data' => [
                        'characteristic' => $characteristic,
                        'resource' => $resource
                    ],
                     'label' => $characteristic->getData('name')
                ]);
            }


            $this->add('submit', 'submit', [
                'label' => 'Сохранить'
            ])
            ->formOptions = [
                'method' => ($resource->id ? 'PUT' : 'POST'),
                'url' => ($resource->id
                    ? action([$controllerClass, 'update'], $resource->id)
                    : action([$controllerClass, 'store'])
                )
            ];
    }
}
