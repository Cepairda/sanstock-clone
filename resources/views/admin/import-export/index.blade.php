@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('components/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')

    @php ($controllerClass = get_class(request()->route()->controller)) @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ Str::before(class_basename($controllerClass), 'Controller') }}
                    </h3>
                    <div class="card-tools">
                        @include('admin.components.dropdown-languages')
                    </div>
                </div>
                <div class="card-body">
                    @if (contains_access('admin.categories.import') || contains_access('admin.categories.export'))
                    <form action="{{ route('admin.categories.import') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        @if (contains_access('admin.categories.import'))
                            <div class="form-group row">
                                <label for="categoriesExcelFile" class="col-form-label col-lg-2">Файл (.xlsx)</label>
                                <div class="col-lg-10">
                                    <input type="file" id="categoriesExcelFile" name="categories" class="form-control-uniform" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-danger">Импортировать категории</button>
                        @endif
                        @if (contains_access('admin.categories.export'))
                            <a href="{{ route('admin.categories.export') }}" class="btn btn-success">Экспортировать категории</a>
                        @endif
                    </form>
                    <hr>
                    @endif

                    @if (contains_access('admin.products.import') || contains_access('admin.products.export'))
                        <form action="{{ route('admin.products.import') }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}

                            @if (contains_access('admin.products.import'))
                                <div class="form-group row">
                                    <label for="productsExcelFile" class="col-form-label col-lg-2">Файл (.xlsx)</label>
                                    <div class="col-lg-10">
                                        <input type="file" id="productsExcelFile" name="products" class="form-control-uniform" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-danger">Импортировать товары</button>
                            @endif
                            @if (contains_access('admin.products.export'))
                                <a href="{{ route('admin.products.export') }}" class="btn btn-success">Экспортировать товары</a>
                            @endif
                        </form>
                        <hr>
                    @endif

                    @if (contains_access('admin.partners.import'))
                    <form action="{{ route('admin.partners.import') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="productsExcelFile" class="col-form-label col-lg-2">Файл (.xlsx)</label>
                            <div class="col-lg-10">
                                <input type="file" id="productsExcelFile" name="partners" class="form-control-uniform" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger">Импортировать партнеров</button>
                    </form>
                    <hr>
                    @endif
                    <div>
                    @if (contains_access('admin.import'))
                        <a href="{{ route('admin.import') }}" class="btn btn-success">Импорт(Бренды, Товары, Характеристики)</a>
                    @endif
                    @if (contains_access('admin.products.import-price'))
                            <form class="d-inline" method="post" action="{{ route('admin.products.import-price') }}">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <button type="submit" class="btn btn-success">Обновить цены</button>
                            </form>
                    @endif
                    </div>
                    <div class="mt-2">
                    @if (contains_access('admin.import-queue'))
                            <a href="{{ route('admin.import-queue') }}" class="btn btn-success">Импорт(Бренды, Товары, Характеристики) Очередь</a>
                    @endif
                    @if (contains_access('admin.import-image.store'))
                            <form class="d-inline" method="post" action="{{ route('admin.import-image.store') }}">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <button type="submit" class="btn btn-success">Импорт изображений</button>
                            </form>
                    @endif
                    </div>
                    </div>
            </div>
        </div>
    </div>

@endsection
