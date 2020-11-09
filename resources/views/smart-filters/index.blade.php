@extends('layouts.admin')
@section('meta_title', 'products')
@section('body_id', 'smartFiltersIndex')
@section('body_class', 'smartFilters')

@section('content')

    <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Роли пользователей</h4>
            </div>
        </div>
    </div>

    <div class="content pt-0">
        <div class="card">

            <div class="card-header header-elements-inline flex-wrap bg-light">
                {{ $smart_filters->links() }}
                <div class="ml-auto">
                    <a href="{{ route('smartFilters.create') }}" class="btn btn-sm btn-success">Добавить</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Разрешения</th>
                        <th class="text-center">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($smart_filters as $smart_filter)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer header-elements-inline flex-wrap">
                {{ $smart_filters->links() }}
                <div class="ml-auto">
                    <a href="{{ route('smartFilters.create') }}" class="btn btn-sm btn-success">Добавить</a>
                </div>
            </div>

        </div>
    </div>

@endsection