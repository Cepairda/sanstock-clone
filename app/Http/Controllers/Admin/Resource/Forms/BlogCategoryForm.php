<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\BlogCategory;
use Kris\LaravelFormBuilder\Form;

class BlogCategoryForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $blogCategories = BlogCategory::joinLocalization()->with('ancestors')->get()->toFlatTree();
        $blogCategoryChoices = to_select_options($blogCategories);
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('slug', 'text', [
                'label' => 'Slug',
                'rules' => ['required', 'max:255', 'unique:resources,slug,' . $resource->id],
                'value' => $resource->slug
            ])
            ->add('parent_id', 'select', [
                'label' => 'Категория',
                'choices' => $blogCategoryChoices,
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
            ->add('details[sort]', 'text', [
                'label' => 'Сортировка',
                'rules' => ['required'],
                'value' => $resource->getDetails('sort')
            ])
            ->add('data[meta_title]', 'text', [
                'label' => 'Meta Title',
                'rules' => ['required'],
                'value' => $resource->getData('meta_title')
            ])
            ->add('data[meta_description]', 'text', [
                'label' => 'Meta Description',
                'rules' => ['required'],
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
            ->add('data[description]', 'tinymce', [
                'label' => 'Description',
                'rules' => [],
                'value' => $resource->getData('description')
            ])
            ->add('data[text]', 'tinymce', [
                'label' => 'Text',
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
