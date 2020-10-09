@extends('layouts.admin')
@section('meta_title', 'Roles')
@section('body_id', 'rolesIndex')
@section('body_class', 'roles')

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
                {{ $roles->links() }}
                <div class="ml-auto">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-success">Добавить</a>
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
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                @foreach($role->accesses as $access)
                                    <span class="badge badge-secondary font-size-100 mb-1"><b>{{ $access->access_name }}</b>
                                        {{ isset($access->access) ? $access->access->description : '' }}</span>
                                @endforeach
                            </td>
                            <td class="text-center" nowrap>

                                @if(auth()->user()->accesses->contains('roles.edit'))
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning btn-sm"
                                       data-toggle="tooltip" data-placement="top" title="Редактировать">
                                        <i class="icon-pencil"></i>
                                    </a>
                                @endif

                                @if(auth()->user()->accesses->contains('roles.accesses'))
                                    <a href="{{ route('admin.roles.accesses', $role->id) }}" class="btn btn-info btn-sm"
                                       data-toggle="tooltip" data-placement="top" title="Разрешения">
                                        <span class="icon-cogs"></span>
                                    </a>
                                @endif

                                @if(auth()->user()->accesses->contains('roles.destroy') && !in_array($role->id, [1, 2]))
                                    <a href="#" class="btn btn-danger btn-sm ajaxActionPrompt" title="Удалить"
                                       data-toggle="tooltip" data-target="#rolesDestroy{{ $role->id }}"
                                       data-prompt-text="Введите ID новой роли для пользователей этой группы:"
                                       data-prompt-default-value="1" data-placement="top" data-item-key="new_role_id">
                                        <span class="icon-bin"></span>
                                    </a>
                                    <button type="button" class="d-none ajaxAction" id="rolesDestroy{{ $role->id }}"
                                            data-success="removeRow ajaxActionErrorAlert" data-_method="DELETE"
                                            data-error-alert-text="Ошибка!"
                                            data-url="{{ route('admin.roles.destroy', $role->id) }}">DELETE</button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer header-elements-inline flex-wrap">
                {{ $roles->links() }}
                <div class="ml-auto">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-success">Добавить</a>
                </div>
            </div>

        </div>
    </div>

@endsection
