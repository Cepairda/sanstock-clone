@extends('layouts.admin')
@section('meta_title', 'Characteristic groups')
@section('body_id', 'characteristicGroupsCreateOrEdit')
@section('body_class', 'characteristicGroups')

@section('scripts')
    <script src="{{ asset('components/limitless/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('components/limitless/js/form_multiselect.js') }}"></script>
@endsection

@section('content')

    <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>{{ isset($characteristic_group) ? 'Редактирование' : 'Добавление' }} группы характеристик</h4>
            </div>
        </div>
    </div>

    <div class="content pt-0">
        <div class="card">
            <form action="{{ isset($characteristic_group) ? route('characteristic-groups.update', $characteristic_group->id) : route('characteristic-groups.store') }}"
                  method="POST">

                {{ csrf_field() }}
                {{ method_field(isset($characteristic_group) ? 'PUT' : 'POST') }}

                <div class="card-header header-elements-inline bg-light">
                    @include('admin.components.formBtns', [
                        'data_attributes' => [
                            'data-success' => 'validation redirectTo',
                            'data-redirected-url' => route('characteristic-groups.index')
                        ]
                    ])
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-2 control-label" for="name">Название</label>
                        <div class="col-sm-10">
                            <input name="name" class="form-control" id="name" maxlength="100" value="{{ old('name', isset($characteristic_group) ? $characteristic_group->name : '') }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="category_ids" class="col-form-label col-lg-2">Категории</label>
                        <div class="col-lg-10">
                            <select class="form-control multiselect" multiple="multiple" id="category_ids"
                                    name="category_ids[]" required>
                                @include('admin.components.categoryOptions', [
                                    'category_tree' => $category_tree,
                                    'offset' => '',
                                    'disabled_id' => 0,
                                    'selected_id' => old('category_ids', isset($characteristic_group) && isset($characteristic_group->categories) ? $characteristic_group->categories->keyBy('id')->keys() : 0),
                                ])
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        @php($characteristicGroupCharacteristics = isset($characteristic_group) ? $characteristic_group->characteristic_group_characteristics->keyBy('characteristic_id') : null)
                        @foreach($characteristics->chunk(ceil($characteristics->count() / 2)) as $chunk)
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Название</th>
                                            <th class="text-center">Использовать</th>
                                            <th class="text-center">Фильтр</th>
                                            <th class="text-center">Сортировка</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($chunk as $characteristic)
                                            <tr>
                                                <td>{{ $characteristic->id }}</td>
                                                <td>{{ $characteristic->name }}</td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="characteristics[{{ $characteristic->id }}][use]"
                                                               {{ isset($characteristicGroupCharacteristics[$characteristic->id]) ? 'checked' : '' }}
                                                               value="1" class="custom-control-input" type="checkbox"
                                                               id="characteristics.{{ $characteristic->id }}.use">
                                                        <label class="custom-control-label"
                                                               for="characteristics.{{ $characteristic->id }}.use">
                                                            &nbsp;</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="characteristics[{{ $characteristic->id }}][is_filter]"
                                                               {{ isset($characteristicGroupCharacteristics[$characteristic->id]) && $characteristicGroupCharacteristics[$characteristic->id]->is_filter ? 'checked' : '' }}
                                                               value="1" class="custom-control-input" type="checkbox"
                                                               id="characteristics.{{ $characteristic->id }}.is_filter">
                                                        <label class="custom-control-label"
                                                               for="characteristics.{{ $characteristic->id }}.is_filter">
                                                            &nbsp;</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control text-center"
                                                           name="characteristics[{{ $characteristic->id }}][sort]"
                                                           min="0" step="1" value="{{ old('name', isset($characteristicGroupCharacteristics[$characteristic->id]) ? $characteristicGroupCharacteristics[$characteristic->id]->sort : 0) }}" required>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>

                <div class="card-footer header-elements-inline">
                    @include('admin.components.formBtns', [
                        'data_attributes' => [
                            'data-success' => 'validation redirectTo',
                            'data-redirected-url' => route('characteristic-groups.index')
                        ]
                    ])
                </div>

            </form>
        </div>
    </div>

@endsection