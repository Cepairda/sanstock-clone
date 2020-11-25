<?php

namespace App\Http\Controllers\Admin\Resource\Forms;

use App\Product;
use App\ResourceResource;
use App\CharacteristicValue;
use App\Category;
use Kris\LaravelFormBuilder\Form;

class SmartFilterForm extends Form
{
    public function buildForm()
    {
        $resource = $this->getModel();
        $categories = Category::joinLocalization()->with('ancestors')->get()->toFlatTree();
        $categoryChoices = to_select_options($categories);
        $controllerClass = get_class(request()->route()->controller);

        $categoryId = request()->route('category');
        $category = Category::joinLocalization()->withCharacteristicGroup()->whereId($categoryId)->firstOrFail();
        $characteristics = $category->characteristic_group[0]->getDetails('characteristics');

        if (isset($characteristics)) {
            foreach ($characteristics as $id => $characteristic) {
                if (isset($characteristic['filter']))
                    $characteristicIds[] = $id;
            }
        }

        $characteristicIds = $characteristicIds ?? null;

        $productIds = Product::select('id')->where('details->category_id', 4)->get()->keyBy('id')->keys();

        $characteristicValueIds = ResourceResource::whereIn('resource_id', $productIds)->where('relation_type', 'App\CharacteristicValue')->get()->keyBy('relation_id')->keys();
        $characteristicValues = CharacteristicValue::joinLocalization()
            ->whereCharacteristicIsFilter($characteristicIds)
            ->whereIn('id', $characteristicValueIds)->orderBy('data->value')->orderBy('id')->get();

        foreach ($characteristicValues as $characteristicValue) {
            $this
                ->add('details[smart_filters][' . $characteristicValue->id . ']', 'select', [
                    'label' => $characteristicValue->getData('value'),
                    'choices' => $categoryChoices,
                    'selected' => $resource['details']['smart_filters'][$characteristicValue->id] ?? null,
                    'empty_value' => ' '
                ]);
        }

        $this
            ->add('details[category_id]', 'hidden', [
                'rules' => ['required'],
                'value' => $categoryId,
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
