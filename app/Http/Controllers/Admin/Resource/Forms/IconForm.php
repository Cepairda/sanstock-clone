<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use App\Brand;
use App\Product;
use Kris\LaravelFormBuilder\Form;

class IconForm extends Form
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
            ->add('details[color]', 'color', [
                'label' => 'Цвет',
                'rules' => [],
                'value' => $resource->getData('description')
            ])
            ->add('data[img]', 'one-image', [
                'label' => 'Изображение',
                'rules' => [],
                'value' => $resource->getData('img')
            ])
            ->add('details[sort]', 'number', [
                'label' => 'Сортировка',
                'rules' => [],
                'value' => $resource->getData('text')
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
