<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use App\Brand;
use App\Product;
use App\Icon;
use Kris\LaravelFormBuilder\Form;

class ProductForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $brandChoices = Brand::joinLocalization()->get()->pluck('data.name', 'id')->toArray();
        $icons = Icon::joinLocalization()->get();
        $iconsChoices = $icons->pluck('data.name', 'id')->toArray();
        $iconsIds = $resource->icons;
        $products = Product::joinLocalization()->get();
        $productsChoices = $products->pluck('details.sku', 'id')->toArray();
        $productsIds = $resource->relateProducts()->get();//->keyBy('id')->keys();
        $categories = Category::joinLocalization()->with('ancestors')->get()->toFlatTree();
        $categoryChoices = to_select_options($categories);
        $categoryIds = $resource->categories()->get()->keyBy('id')->keys();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('slug', 'text', [
                'label' => 'Slug',
                'rules' => ['required', 'max:255', 'unique:resources,slug,' . $resource->id],
                'value' => $resource->slug
            ])
            ->add('details[brand_id]', 'select', [
                'label' => 'Brand',
                'rules' => ['required'],
                'choices' => $brandChoices,
                'selected' => $resource->getDetails('brand_id'),
                'empty_value' => ' '
            ])
            ->add('relations[App\Icon]', 'choice', [
                'multiple' => true,
                'label' => 'Icons',
                'choices' => $iconsChoices,
                'selected' => $iconsIds,
                'attr' => [
                    'class' => 'select2bs4 form-control',
                ],
            ])
            ->add('details[sku]', 'text', [
                'label' => 'Sku',
                //'rules' => ['required', 'unique:resources,details->sku,' . $resource->id],
                'value' => $resource->getDetails('sku'),
                //'attr' => ['disabled' => true],
            ])
            ->add('details[ref]', 'text', [
                'label' => 'Ref',
                'rules' => ['required', 'unique:resources,details->ref,' . $resource->id],
                'value' => $resource->getDetails('ref'),
                //'attr' => ['disabled' => true],
            ])
            ->add('details[published]', 'select', [
                'label' => 'Опубликовано',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('published'),
                'empty_value' => ' '
            ])
            ->add('details[price]', 'number', [
                'label' => 'Price',
                'rules' => ['required'],
                'value' => $resource->getDetails('price'),
            ])
            ->add('relations[App\Product]', 'choice', [
                'multiple' => true,
                'label' => 'Связанные товары',
                'choices' => $productsChoices,
                'selected' => $productsIds,
                'attr' => [
                    'class' => 'select2bs4 form-control',
                ],
            ])
            ->add('details[category_id]', 'select', [
                'label' => 'Основная категория',
                'rules' => ['required'],
                'choices' => $categoryChoices,
                'selected' => $resource->getDetails('category_id'),
                'empty_value' => ' '
            ])
            ->add('relations[App\Category]', 'choice', [
                'multiple' => true,
                'label' => 'Категории',
                'choices' => $categoryChoices,
                'selected' => $categoryIds,
                'attr' => [
                    'class' => 'select2bs4 form-control',
                ],
            ])
            ->add('data[name]', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $resource->getData('name')
            ])
            ->add('data[description]', 'textarea', [
                'label' => 'Description',
                'rules' => [],
                'value' => $resource->getData('description')
            ])
            ->add('data[text]', 'textarea', [
                'label' => 'Text',
                'rules' => [],
                'value' => $resource->getData('text')
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
            ->add('details[enable_comments]', 'select', [
                'label' => 'Включить комментарии',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('enable_comments'),
                'empty_value' => ' '
            ])
            ->add('details[enable_stars_comments]', 'select', [
                'label' => 'Включить звёзды(Комментарии)',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('enable_stars_comments'),
                'empty_value' => ' '
            ])
            ->add('details[enable_reviews]', 'select', [
                'label' => 'Включить отзывы',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('enable_reviews'),
                'empty_value' => ' '
            ])
            ->add('details[enable_stars_reviews]', 'select', [
                'label' => 'Включить звёзды(Отзывы)',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('enable_stars_reviews'),
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
