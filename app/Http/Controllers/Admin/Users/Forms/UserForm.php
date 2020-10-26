<?php

namespace App\Http\Controllers\Admin\Users\Forms;

use App\Role;
use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $user = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);
        $roles = Role::pluck('name', 'id')->toArray();

        $this
            ->add('email', 'text', [
                'label' => 'Email',
                'rules' => ['required', 'string', 'email', 'max:50', 'unique:users,email' . (isset($user->id) ? (',' . $user->id) : '')],
                'value' => $user->email,
            ])
            ->add('password', 'password', [
                'label' => 'Password',
                'rules' => (isset($user->id) ? ['min:8', 'nullable'] : ['required', ['min:8']]),
                'value' => '',
            ])
            ->add('old_password', 'hidden', [
                'rules' => (isset($user->id) ? ['required', 'string', 'exists:users,password,id,' . $user->id] : []),
                'value' => $user->password,
            ])
            ->add('role_id', 'select', [
                'label' => 'Role',
                'rules' => ['required', 'integer', 'exists:roles,id'],
                'choices' => $roles,
                'selected' => $user->role_id,
                'empty_value' => ' '
            ])
            ->add('patronymic', 'text', [
                'label' => 'Patronymic',
                'rules' => [],
                'value' => $user->patronymic,
            ])
            ->add('name', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $user->name
            ])
            ->add('surname', 'text', [
                'label' => 'Surname',
                'rules' => [],
                'value' => $user->surname,
            ])
            ->add('submit', 'submit', [
                'label' => 'Сохранить'
            ])
            ->formOptions = [
                'method' => ($user->id ? 'PUT' : 'POST'),
                'url' => ($user->id
                    ? action([$controllerClass, 'update'], $user->id)
                    : action([$controllerClass, 'store'])
                )
            ];
    }
}
