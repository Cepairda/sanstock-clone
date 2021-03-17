<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\BlogCategory;
use App\BlogTag;
use Kris\LaravelFormBuilder\Form;

class BlogPostForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $blogCategories = BlogCategory::joinLocalization()->with('ancestors')->get()->toFlatTree();
        $blogCategoryChoices = to_select_options($blogCategories);
        $blogCategoryIds = $resource->categories()->get()->keyBy('id')->keys();
        $tags = BlogTag::joinLocalization()->where('details->published', 1)->get();
        $tagsChoices = $tags->pluck('data.name', 'id')->toArray();
        $tagsIds = $resource->tags;
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('slug', 'text', [
                'label' => 'Slug',
                'rules' => ['required', 'max:255', 'unique:resources,slug,' . $resource->id],
                'value' => $resource->slug
            ])
            ->add('data[img]', 'one-image', [
                'label' => 'Image',
                'rules' => [],
                'value' => $resource->getData('img')
            ])
            ->add('details[published]', 'select', [
                'label' => 'Опубликовано',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('published'),
                'empty_value' => ' '
            ])

            ->add('details[category_id]', 'select', [
                'label' => 'Основная категория',
                'rules' => ['required'],
                'choices' => $blogCategoryChoices,
                'selected' => $resource->getDetails('category_id'),
                'empty_value' => ' '
            ])
            ->add('relations[App\BlogCategory]', 'choice', [
                'multiple' => true,
                'label' => 'Категории',
                'choices' => $blogCategoryChoices,
                'selected' => $blogCategoryIds,
                'attr' => [
                    'class' => 'select2bs4 form-control',
                ],
            ])
            ->add('relations[App\BlogTag]', 'choice', [
                'multiple' => true,
                'label' => 'Теги',
                'choices' => $tagsChoices,
                'selected' => $tagsIds,
                'attr' => [
                    'class' => 'select2bs4 form-control',
                ],
            ])
            ->add('data[meta_title]', 'text', [
                'label' => 'Meta Title',
                'rules' => [],
                'value' => $resource->getData('meta_title')
            ])
            ->add('data[meta_description]', 'textarea', [
                'label' => 'Meta Description',
                'rules' => [],
                'value' => $resource->getData('meta_description')
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
