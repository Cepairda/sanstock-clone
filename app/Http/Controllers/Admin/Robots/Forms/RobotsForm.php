<?php

namespace App\Http\Controllers\Admin\Robots\Forms;

use Kris\LaravelFormBuilder\Form;

class RobotsForm extends Form
{
    public function buildForm()
    {
        if (file_exists($filePath = public_path('robots.txt'))) {
            $content = file_get_contents($filePath);
        }

        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('content', 'textarea', [
                'label' => 'Content',
                'rules' => ['required'],
                'value' => $content,
            ])
            ->add('submit', 'submit', [
                'label' => 'Сохранить'
            ])
            ->formOptions = [
                'method' => 'POST',
                'url' => action([$controllerClass, 'store']
                )
            ];
    }
}
