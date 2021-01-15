<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use Kris\LaravelFormBuilder\Form;

class CommentForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('details[status]', 'select', [
                'label' => 'Промодерировано',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('status'),
                'empty_value' => ' '
            ])
            ->add('details[resource_id]', 'number', [
                'label' => 'Resource ID',
                'rules' => ['required'],
                'value' => $resource->getDetails('resource_id')
            ])
            ->add('details[name]', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $resource->getDetails('name')
            ])
            ->add('details[email]', 'text', [
                'label' => 'Email',
                //'rules' => ['required'],
                'value' => $resource->getDetails('email')
            ])
            ->add('details[phone]', 'text', [
                'label' => 'Phone',
                //'rules' => ['required'],
                'value' => $resource->getDetails('phone')
            ])
            ->add('details[body]', 'textarea', [
                'label' => 'Comment',
                'rules' => [],
                'value' => $resource->getDetails('body'),
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
