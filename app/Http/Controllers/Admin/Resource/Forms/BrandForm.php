<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use Kris\LaravelFormBuilder\Form;

class BrandForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('slug', 'text', [
                'label' => 'Slug',
                'rules' => ['required', 'max:255', 'unique:resources,slug,' . $resource->id],
                'value' => $resource->slug,
            ])
            ->add('data[name]', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $resource->data['name']
            ])
            ->add('data[description]', 'textarea', [
                'label' => 'Description',
                'rules' => [],
                'value' => $resource->data['description'],
                'attr' => ['class' => 'form-control tinymce'],
            ])
            ->add('data[text]', 'tinymce', [
                'label' => 'Text',
                'rules' => [],
                'value' => $resource->data['text']
            ])
            ->add('data[img]', 'one-image', [
                'label' => 'Image',
                'rules' => [],
                'value' => $resource->data['img']
            ])
            ->add('data[file]', 'one-file', [
                'label' => 'Image',
                'rules' => [],
                //'value' => $resource->data['file']
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
