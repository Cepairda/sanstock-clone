<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use Kris\LaravelFormBuilder\Form;

class PartnerForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('details[name]', 'text', [
                'label' => 'Name',
                'rules' => [],
                'value' => $resource->getDetails('name')
            ])
            ->add('details[host]', 'text', [
                'label' => 'Host',
                'rules' => [],
                'value' => $resource->getDetails('host')
            ])
            ->add('details[img]', 'one-image', [
                'label' => 'Image',
                'rules' => [],
                'value' => $resource->getDetails('img')
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
