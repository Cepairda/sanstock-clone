@extends('layouts.admin')
@section('meta_title', 'Smart filters')
@section('body_id', 'smartFiltersShow')
@section('body_class', 'smartFilters')

@section('content')

    <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Смарт фильтры для категории "{{ $category->name }}"</h4>
            </div>
        </div>
    </div>

    <div class="content pt-0">
        <div class="card">

            <form method="post" action="{{ route('smart-filters.update', $category->id) }}">

                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <div class="card-header header-elements-inline bg-light">
                    {{ $characteristic_values->links() }}
                    <div class="ml-auto">
                        @include('admin.components.formBtns', [
                            'data_attributes' => [
                                'data-success' => 'validation success',
                            ]
                        ])
                    </div>
                </div>

                <div class="card-body">
                    @foreach($characteristic_values as $characteristic_value)
                        @php($smartFilterData = $category->smart_filter_data->where('characteristic_value_id', $characteristic_value->id)->first())
                        <div class="form-group row">
                            <label for="inputPassword"
                                   class="col-sm-2 col-form-label">{{ $characteristic_value->value }}</label>
                            <div class="col-sm-10">
                                <select name="smart_filters[{{ $characteristic_value->id }}]" class="form-control">
                                    <option></option>
                                    @include('admin.components.categoryOptions', [
                                        'category_tree' => $category_tree,
                                        'offset' => '',
                                        'disabled_id' => 0,
                                        'selected_id' => isset($smartFilterData) ? $smartFilterData->filter_category_id : 0
                                    ])
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card-footer header-elements-inline">
                    {{ $characteristic_values->links() }}
                    <div class="ml-auto">
                        @include('admin.components.formBtns', [
                            'data_attributes' => [
                                'data-success' => 'validation success',
                            ]
                        ])
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection