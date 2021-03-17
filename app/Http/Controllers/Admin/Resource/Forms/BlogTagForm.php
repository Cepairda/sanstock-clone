<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use Kris\LaravelFormBuilder\Form;

class BlogTagForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('data[name]', 'text', [
                'label' => 'Название',
                'rules' => ['required'],
                'value' => $resource->getData('name')
            ])
            ->add('details[published]', 'select', [
                'label' => 'Опубликовано',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('published'),
                'empty_value' => ' '
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
