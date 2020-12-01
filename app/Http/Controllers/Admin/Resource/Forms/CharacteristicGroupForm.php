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
        $characteristics = Characteristic::joinLocalization()->where('details->published', 1)->get();
        $this->data['characteristics'] = $characteristics;
        $categories = Category::joinLocalization()->with('ancestors')->get()->toFlatTree();
        $categoryChoices = to_select_options($categories);
        $categoryIds = $resource->categories()->get()->keyBy('id')->keys();
        $categoriesDisabledIds = Category::join('resource_resource', function ($query) use ($resource) {
            $query->on('resource_resource.relation_id', 'resources.id')
                ->where('resource_resource.resource_id', '!=', $resource->id)
                ->where('resource_type', get_class($resource));
        })
        ->get()->keyBy('id')->toArray();

        foreach ($categoriesDisabledIds as &$categoriesDisabledId) {
            $categoriesDisabledId = ['disabled' => 'disabled'];
        }

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
                'option_attributes' => $categoriesDisabledIds,
                'attr' => [
                    'class' => 'select2bs4 form-control',
                ],
            ]);

            foreach ($characteristics as $characteristic) {
                $this->add('details[characteristics][' . $characteristic->id .']', 'form', [
                    'class' => 'App\Http\Controllers\Admin\Resource\Forms\SubCharacteristicGroupForm',
                    'formOptions' => [],
                    'data' => [
                        'characteristic' => $characteristic,
                        'resource' => $resource
                    ],
                     'label' => false
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
