<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use App\Characteristic;
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
            ->add('virtual_id', 'number', [
                'label' => 'ID(Excel файл)',
                'rules' => ['required', 'max:255', 'unique:resources,virtual_id,' . $resource->id],
                'value' => $resource->r_id
            ])
            ->add('parent_id', 'select', [
                'label' => 'Категория',
                'choices' => $categoryChoices,
                'selected' => $resource->parent_id,
                'disabled' => ['14'],
                'rules' => [],
                'empty_value' => 'Родительская категория'
            ])
            ->add('details[published]', 'select', [
                'label' => 'Опубликовано',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('published'),
                'empty_value' => ' '
            ])
            ->add('details[is_menu_item]', 'select', [
                'label' => 'Пункт меню',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('is_menu_item'),
                'empty_value' => ' '
            ])
            ->add('details[sort]', 'text', [
                'label' => 'Сортировка',
                'value' => $resource->getDetails('sort')
            ])
            ->add('data[meta_title]', 'text', [
                'label' => 'Meta Title',
                'value' => $resource->getData('meta_title')
            ])
            ->add('data[meta_description]', 'text', [
                'label' => 'Meta Description',
                'value' => $resource->getData('meta_description')
            ])
            ->add('data[h1]', 'text', [
                'label' => 'H1',
                'rules' => ['required'],
                'value' => $resource->getData('h1')
            ])
            ->add('data[name]', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $resource->getData('name')
            ])
            ->add('data[description]', 'textarea', [
                'label' => 'Description',
                'value' => $resource->getData('description')
            ])
            ->add('data[text]', 'textarea', [
                'label' => 'Text',
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
