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
                        <span class="fas fa-grip-lines-vertical"></span>
                        <form action="{{ action([$controllerClass, 'store']) }}" method="post" class="d-inline-block">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <button class="text-success btn d-inline-block px-3">
                                <span class="far fa-plus-square"></span> Сделать Backup
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">

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

                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div id="example1_filter" class="dataTables_filter">
                                    <label>Поиск:
                                        <input type="search" class="form-control form-control-sm"
                                               placeholder="" aria-controls="example1">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr role="row">

                                        <th class="sorting_asc">Название</th>
                                        <th class="sorting">Размер</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($backups as $id => $backup)
                                        @php $backup = basename($backup) @endphp
                                        <tr>
                                            <td><a href="{{ route('admin.mysql-backup.download', $backup) }}">{{ $backup }}</a></td>
                                            <td>{{ humanFileSize(\Illuminate\Support\Facades\Storage::size('backup/' . $backup)) }}</td>

                                            <td nowrap>
                                                <a href="{{ action([$controllerClass, 'download'], $backup) }}"
                                                   class="btn btn-warning text-white">
                                                    <span class="fa fa-download"></span>
                                                </a>
                                                <form action="{{ action([$controllerClass, 'destroy'], $backup) }}" method="post" class="d-inline">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit"
                                                        class="btn btn-danger text-white">
                                                        <span class="fa fa-trash-alt"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
