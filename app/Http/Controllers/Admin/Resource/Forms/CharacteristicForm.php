<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use Kris\LaravelFormBuilder\Form;

class CharacteristicForm extends Form
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
            ->add('details[is_filter]', 'select', [
                'label' => 'Фильтер',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('is_filter'),
            ])
            ->add('details[published]', 'select', [
                'label' => 'Опубликовано',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('published'),
            ])
            ->add('details[sort]', 'number', [
                'label' => 'Сортировка',
                'rules' => ['required'],
                'value' => $resource->getDetails('sort'),
                'default_value' => 0,
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
