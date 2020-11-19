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
        //$categoryIds = $resource->categories()->get()->keyBy('id')->keys();
        $controllerClass = get_class(request()->route()->controller);


        $category = Category::joinLocalization()->withCharacteristicGroup()->whereId(4)->first();
        //dd($category);
        //dd($category->characteristic_group[0]->getDetails('characteristics'));

        $characteristics = $category->characteristic_group[0]->getDetails('characteristics');

        if (isset($characteristics)) {
            foreach ($category->characteristic_group[0]->details['characteristics'] as $id => $characteristic) {
                if ($characteristic['filter'] == 1)
                    $characteristicIds[] = $id;
            }
        }

        $characteristicIds = $characteristicIds ?? null;

        //dd($characteristicIds);

        $productIds = Product::select('id')->where('details->category_id', 4)->get()->keyBy('id')->keys();
        //dd($productIds);
        $characteristicValueIds = ResourceResource::whereIn('resource_id', $productIds)->where('relation_type', 'App\CharacteristicValue')->get()->keyBy('relation_id')->keys();
        //dd($characteristicValueIds);
        /*$characteristicValues = CharacteristicValue::joinLocalization()
            ->whereCharacteristicIsFilter($characteristicIds)
            ->whereIn('id', $characteristicValueIds)->orderBy('data->value')->orderBy('id')->get();*/

        $characteristicValues = CharacteristicValue::joinLocalization()
            ->whereExists(function ($query) {
                $query->select('id as characteristic_id')->from('resources as characteristics')
                    ->where('type', 'App\Characteristic')
                    ->whereRaw('characteristic_id = json_unquote(json_extract(`resources`.`details`, \'$."characteristic_id"\'))')
                    ->where('characteristics.details->is_filter', '1');
            })
            ->whereIn('id', $characteristicValueIds)->orderBy('data->value')->orderBy('id')->get();

        foreach ($characteristicValues as $characteristicValue) {
            //echo $characteristicValue->getData('value') . '<br>';
            $this
                ->add('details[smart_filter][' . $characteristicValue->id . ']', 'select', [
                    'label' => $characteristicValue->getData('value'),
                    'rules' => ['required'],
                    'choices' => $categoryChoices,
                    'selected' => '',
                    'empty_value' => ' '
                ]);
        }

        $this
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
