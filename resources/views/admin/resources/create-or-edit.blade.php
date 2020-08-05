@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('components/AdminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('components/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .form-group .col-lg-10 .col {
            padding: 0;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/resourses/create-or-edit.js') }}"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('components/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('.lfm-image').filemanager('image');
            $('.lfm-file').filemanager('file');
        });
    </script>
@endsection

@section('content')

    @php($controllerClass = get_class(request()->route()->controller))
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
                        <a href="{{ action([$controllerClass, 'index']) }}"
                           class="text-danger d-inline-block px-3">
                            <span class="far fa-times-circle"></span> Отмена
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
            </div>
        </div>
    </div>


@endsection
