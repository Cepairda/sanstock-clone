<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Category;
use Kris\LaravelFormBuilder\Form;

class SalePointForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('details[online]', 'select', [
                'label' => 'Online',
                'rules' => ['required'],
                'choices' => ['Нет', 'Да'],
                'selected' => $resource->getDetails('online'),
            ])
            ->add('details[latitude]', 'number', [
                'label' => 'Широта',
                'rules' => ['required'],
                'value' => $resource->getDetails('latitude'),
                'attr' => ['step' => 'any'],
            ])
            ->add('details[longitude]', 'number', [
                'label' => 'Долгота',
                'rules' => ['required'],
                'value' => $resource->getDetails('longitude'),
                'attr' => ['step' => 'any'],
            ])
            ->add('data[name]', 'text', [
                'label' => 'Название',
                'rules' => ['required'],
                'value' => $resource->getData('name'),
            ])
            ->add('data[description]', 'text', [
                'label' => 'Описание',
                'rules' => ['required'],
                'value' => $resource->getData('description'),
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
