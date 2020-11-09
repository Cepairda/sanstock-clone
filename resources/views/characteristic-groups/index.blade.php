@extends('layouts.admin')
@section('meta_title', 'Characteristic groups')
@section('body_id', 'characteristicGroupsIndex')
@section('body_class', 'characteristicGroups')

@section('content')

    <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Группы характеристик</h4>
            </div>
        </div>
    </div>

    <div class="content pt-0">
        <div class="card">

            <div class="card-header header-elements-inline flex-wrap bg-light">
                {{ $characteristic_groups->links() }}
                <div class="ml-auto">
                    <a href="{{ route('characteristic-groups.create') }}" class="btn btn-sm btn-success">Добавить</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Категории</th>
                        <th class="text-center">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($characteristic_groups as $characteristic_group)
                        <tr>
                            <td>{{ $characteristic_group->id }}</td>
                            <td>{{ $characteristic_group->name }}</td>
                            <td>
                                @foreach($characteristic_group->categories as $category)
                                    {{ $category->name }} (ID: {{ $category->id }});
                                @endforeach
                            </td>
                            <td class="text-center" nowrap>

                                @if(auth()->user()->accesses->contains('characteristic-groups.edit'))
                                    <a href="{{ route('characteristic-groups.edit', $characteristic_group->id) }}"
                                       class="btn btn-warning btn-sm"
                                       data-toggle="tooltip" data-placement="top" title="Редактировать">
                                        <i class="icon-pencil"></i>
                                    </a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer header-elements-inline flex-wrap">
                {{ $characteristic_groups->links() }}
                <div class="ml-auto">
                    <a href="{{ route('characteristic-groups.create') }}" class="btn btn-sm btn-success">Добавить</a>
                </div>
            </div>

        </div>
    </div>

@endsection