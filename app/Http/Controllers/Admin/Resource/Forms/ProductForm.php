<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use Kris\LaravelFormBuilder\Form;

class ProductForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $categories = Category::joinLocalization()->with('ancestors')->get()->toFlatTree();
        $categoryChoices = to_select_options($categories);
        $categoryIds = $resource->categories()->get()->keyBy('id')->keys();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('slug', 'text', [
                'label' => 'Slug',
                'rules' => ['required', 'max:255', 'unique:resources,slug,' . $resource->id],
                'value' => $resource->slug
            ])
            ->add('details[sku]', 'text', [
                'label' => 'Sku',
                'rules' => ['required', 'unique:resources,details->sku,' . $resource->id],
                'value' => $resource->getDetails('sku')
            ])
            ->add('details[price]', 'number', [
                'label' => 'Price',
                'rules' => ['required'],
                'value' => $resource->getDetails('price'),
            ])

            ->add('details[category_id]', 'select', [
                'label' => 'Основная категория',
                'rules' => ['required'],
                'choices' => $categoryChoices,
                'selected' => $resource->getDetails('category_id'),
                'empty_value' => ' '
            ])

            ->add('relations[App\Category]', 'choice', [
                'multiple' => true,
                'label' => 'Категории',
                'choices' => $categoryChoices,
                'selected' => $categoryIds,
                'attr' => [
                    'class' => 'select2bs4 form-control',
                ],
            ])

            ->add('data[name]', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $resource->getData('name')
            ])
            ->add('data[description]', 'textarea', [
                'label' => 'Description',
                'rules' => [],
                'value' => $resource->getData('description')
            ])
            ->add('data[text]', 'textarea', [
                'label' => 'Text',
                'rules' => [],
                'value' => $resource->getData('text')
            ])
            ->add('submit', 'submit', [
                'label' => 'Сохранить'
            ])
            ->formOptions = [
            'method' => ($resource->id ? 'PUT' : 'POST'),
            'url' => ($resource->id ?
                action([$controllerClass, 'update'], $resource->id) :
                action([$controllerClass, 'store']))
        ];
    }
}
