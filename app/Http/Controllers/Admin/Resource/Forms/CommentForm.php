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
            ->add('details[type]', 'hidden', [
                'rules' => ['required'],
                'value' => $resource->getDetails('type')
            ])
            ->add('details[status]', 'select', [
                'label' => 'Промодерировано',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('status'),
                'empty_value' => ' '
            ])
            ->add('details[star]', 'number', [
                'label' => 'Оценка',
                'rules' => ['required'],
                'selected' => $resource->getDetails('star'),
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
                'rules' => ['required'],
                'value' => $resource->getDetails('body'),
            ]);

        if ($resource->getDetails('attachment')) {
            foreach ($resource->getDetails('attachment') as $key => $attachment) {
                $this
                    ->add('details[attachment][' . $key . ']', 'hidden', [
                        'label' => 'Attachment ' . $key,
                        'value' => $attachment,
                    ])
                    ->add('link[' . $key . ']', 'static', [
                        'tag' => 'a',
                        'attr' => ['href' => asset('storage/' . $attachment), 'target' => '_blank'],
                        'label' => 'Attachment ' . $key,
                        'value' => $attachment,
                    ]);
            }
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
