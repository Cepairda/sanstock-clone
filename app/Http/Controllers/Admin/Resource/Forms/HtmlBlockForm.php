<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use Kris\LaravelFormBuilder\Form;

class HtmlBlockForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $controllerClass = get_class(request()->route()->controller);

        $this
            ->add('details[block_name]', 'text', [
                'label' => 'Name',
                'rules' => ['required'],
                'value' => $resource->getDetails('block_name')
            ])
            ->add('data[html]', 'tinymce', [
                'label' => 'HTML',
                'rules' => [],
                'value' => $resource->getData('html')
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
