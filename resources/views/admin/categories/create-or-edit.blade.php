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
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Категория</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Характеристики</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        <div class="card-body">
                            {!! form($form) !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                         @foreach($characteristics as $characteristic)
                             <input type="checkbox">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
