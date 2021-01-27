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
                'selected' => $resource->getDetails('comments')['App\Product']['enable'] ?? null,
                'empty_value' => ' '
            ])
            ->add('details[comments][App\Product][stars]', 'select', [
                'label' => 'Товары(Звезды в Комментариях)',
                'rules' => ['required'],
                'choices' => ['Выключено', 'Включено'],
                'selected' => $resource->getDetails('comments')['App\Product']['stars'] ?? null,
                'empty_value' => ' '
            ])
            ->add('details[reviews][App\Product][enable]', 'select', [
                'label' => 'Товары(Отзывы)',
                'rules' => ['required'],
                'choices' => ['Выключено', 'Включено'],
                'selected' => $resource->getDetails('reviews')['App\Product']['enable'] ?? null,
                'empty_value' => ' '
            ])
            ->add('details[reviews][App\Product][stars]', 'select', [
                'label' => 'Товары(Звезды в Отзывах)',
                'rules' => ['required'],
                'choices' => ['Выключено', 'Включено'],
                'selected' => $resource->getDetails('reviews')['App\Product']['stars'] ?? null,
                'empty_value' => ' '
            ])
            ->add('details[comments][files][enable]', 'select', [
                'label' => 'Разрешить прикреплять файлы',
                'rules' => ['required'],
                'choices' => ['Выключено', 'Включено'],
                'selected' => $resource->getDetails('comments')['files']['enable'] ?? null,
                'empty_value' => ' '
            ])
            ->add('details[comments][files][count]', 'number', [
                'label' => 'Количество файлов',
                'rules' => ['required'],
                'value' => $resource->getDetails('comments')['files']['count'] ?? null,
            ])
            ->add('details[comments][files][size]', 'number', [
                'label' => 'Max размер файла в МБ',
                'rules' => ['required'],
                'value' => $resource->getDetails('comments')['files']['size'] ?? null,
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
