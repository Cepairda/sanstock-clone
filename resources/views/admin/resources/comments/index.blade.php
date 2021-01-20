@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('components/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')

    @php($controllerClass = get_class(request()->route()->controller))
    @php($resourceClass = get_class($resources))

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ Str::before(class_basename($controllerClass), 'Controller') }}
                    </h3>
                    <div class="card-tools">
                        @include('admin.components.dropdown-languages')
                        <span class="fas fa-grip-lines-vertical"></span>
                        <a href="{{ action([$controllerClass, 'create']) }}"
                           class="text-success d-inline-block px-3">
                            <span class="far fa-plus-square"></span> Добавить
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                @if($resourceClass != 'Kalnoy\Nestedset\Collection')
                                    <div class="dataTables_length" id="example1_length">
                                        <label>
                                            Показывать
                                            <select name="example1_length" aria-controls="example1"
                                                    class="custom-select custom-select-sm form-control form-control-sm">
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="100">200</option>
                                            </select>
                                            записей
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="example1_filter" class="dataTables_filter">
                                    <form>
                                        <label>Поиск:
                                            <input type="search" name="search" class="form-control form-control-sm"
                                                   placeholder="" aria-controls="example1">
                                        </label>
                                        <button class="btn btn-primary">Найти</button>
                                        <a href="{{ action([$controllerClass, 'createSearchString']) }}"
                                           class="btn btn-success text-white">
                                            Генерировать Search String
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr role="row">
                                        @if($resourceClass == 'Kalnoy\Nestedset\Collection')
                                            <th></th>
                                        @endif
                                        @php($search = isset($_GET['search']) ? ('&search=' . $_GET['search']) : null)
                                        <th class="sorting_asc">
                                            <a href="{{ ((isset($_GET['id']) && $_GET['id'] == 'desc') ? '?id=asc' : '?id=desc') . $search}}">ID</a>
                                        </th>
                                        <th class="sorting">
                                            <a href="{{ ((isset($_GET['created_at']) && $_GET['created_at'] == 'desc') ? '?created_at=asc' : '?created_at=desc') . $search}}">Дата создания</a>
                                        </th>
                                        <th class="sorting">
                                            <a href="{{ ((isset($_GET['updated_at']) && $_GET['updated_at'] == 'desc') ? '?updated_at=asc' : '?updated_at=desc') . $search}}">Дата редактирования</a>
                                        </th>
                                        <th class="sorting">
                                            <a href="{{ ((isset($_GET['deleted_at']) && $_GET['deleted_at'] == 'desc') ? '?deleted_at=asc' : '?deleted_at=desc') . $search}}">Дата удаления</a>
                                        </th>
                                        <th>Детали</th>
                                        <th>Данные</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($resources as $resource)
                                        <tr class="{{ $resource->status ? 'table-success' : 'table-danger' }}">
                                            @if($resourceClass == 'Kalnoy\Nestedset\Collection')
                                                <td class="align-middle">
                                                    <span class="fa fa-circle"></span>
                                                    @for($i = 0; $i < $resource->ancestors->count(); $i++)
                                                        <span class="fa fa-circle"></span>
                                                    @endfor
                                                </td>
                                            @endif
                                            <td>{{ $resource->id }}</td>
                                            <td>{{ $resource->created_at->format('d.m.Y') }}</td>
                                            <td>{{ $resource->updated_at->format('d.m.Y') }}</td>
                                            <td>{{ isset($resource->deleted_at) ? $resource->deleted_at->format('d.m.Y') : '' }}</td>
                                            <td>
                                                @isset($resource->details)
                                                    @foreach($resource->details as $key => $value)
                                                        @if (!is_array($value))
                                                            <b>{{ $key }}</b>: {{ Str::limit($value, 20, '...') }}; <br>
                                                        @else
                                                            <b>{{ $key }}</b>:<br>
                                                            @foreach($value as $file)
                                                                <p><a href="{{ asset('storage/' . $file) }}">{{ $file }}</a></p>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endisset
                                            </td>
                                            <td>
                                                @isset($resource->data)
                                                    @foreach($resource->data as $key => $value)
                                                        <b>{{ $key }}</b>: {{ Str::limit($value, 20, '...') }}; <br>
                                                    @endforeach
                                                @endisset
                                            </td>
                                            <td nowrap>
                                                <a href="{{ action([$controllerClass, 'edit'], $resource->id) }}"
                                                   class="btn btn-warning text-white">
                                                    <span class="far fa-edit"></span>
                                                </a>
                                                <a href="{{ action([$controllerClass, 'destroy'], $resource->id) }}"
                                                   class="btn btn-danger text-white">
                                                    <span class="fa fa-trash-alt"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($resourceClass != 'Kalnoy\Nestedset\Collection')
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                        Показано с {{ $resources->firstItem() }} по {{ $resources->lastItem() }}
                                        из {{ $resources->total() }} записей
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        {{ $resources->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
