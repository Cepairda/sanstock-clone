<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use App\Brand;
use App\Product;
use App\Icon;
use Kris\LaravelFormBuilder\Form;

class SettingForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('details[comments][App\Product][enable]', 'select', [
                'label' => 'Товары(Комментарии)',
                'rules' => ['required'],
                'choices' => ['Выключено', 'Включено'],
                'selected' => $resource->getDetails('comments')['App\Product']['enable'],
                'empty_value' => ' '
            ])
            ->add('details[comments][App\Product][stars]', 'select', [
                'label' => 'Товары(Звездв)',
                'rules' => ['required'],
                'choices' => ['Выключено', 'Включено'],
                'selected' => $resource->getDetails('comments')['App\Product']['stars'],
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
