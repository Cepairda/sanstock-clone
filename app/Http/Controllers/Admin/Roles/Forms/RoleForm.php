<?php

namespace App\Http\Controllers\Admin\Roles\Forms;

use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $role = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('name', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $role->name
            ])
            ->add('description', 'textarea', [
                'label' => 'Description',
                'rules' => ['required'],
                'value' => $role->description,
            ])
            ->add('submit', 'submit', [
                'label' => 'Сохранить'
            ])
            ->formOptions = [
                'method' => ($role->id ? 'PUT' : 'POST'),
                'url' => ($role->id
                    ? action([$controllerClass, 'update'], $role->id)
                    : action([$controllerClass, 'store'])
                )
            ];
    }
}
