<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $categories = Category::joinLocalization()->with('ancestors')->get()->toFlatTree();
        $categoryChoices = to_select_options($categories);
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('slug', 'text', [
                'label' => 'Slug',
                'rules' => ['required', 'max:255', 'unique:resources,slug,' . $resource->id],
                'value' => $resource->slug
            ])
            ->add('parent_id', 'select', [
                'label' => 'Категория',
                'choices' => $categoryChoices,
                'selected' => $resource->parent_id,
                'disabled' => ['14'],
                'rules' => [],
                'empty_value' => 'Родительская категория'
            ])
            ->add('data[name]', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $resource->data['name']
            ])
            ->add('data[description]', 'textarea', [
                'label' => 'Description',
                'rules' => [],
                'value' => $resource->data['description']
            ])
            ->add('data[text]', 'textarea', [
                'label' => 'Text',
                'rules' => [],
                'value' => $resource->data['text']
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
