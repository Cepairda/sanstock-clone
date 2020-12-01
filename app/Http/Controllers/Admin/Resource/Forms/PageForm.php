<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use Kris\LaravelFormBuilder\Form;

class PageForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('slug', 'text', [
                'label' => 'Slug',
                'rules' => ['required', 'max:255', 'unique:resources,slug,' . $resource->id],
                'value' => $resource->slug
            ])
            ->add('details[published]', 'select', [
                'label' => 'Опубликовано',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('published'),
                'empty_value' => ' '
            ])
            ->add('data[meta_title]', 'text', [
                'label' => 'Meta Title',
                'rules' => [],
                'value' => $resource->getData('meta_title')
            ])
            ->add('data[meta_description]', 'textarea', [
                'label' => 'Meta Description',
                'rules' => [],
                'value' => $resource->getData('meta_description')
            ])
            ->add('data[name]', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $resource->getData('name')
            ])
            ->add('data[description]', 'tinymce', [
                'label' => 'Description',
                'rules' => [],
                'value' => $resource->getData('description')
            ])
            ->add('submit', 'submit', [
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
