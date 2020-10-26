@extends('layouts.admin')
@section('meta_title', 'users')
@section('body_id', 'usersIndex')
@section('body_class', 'users')

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
                {{ $users->links() }}
                <div class="ml-auto">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">Добавить</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Данные</th>
                        <th>Разрешения</th>
                        <th class="text-center">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td nowrap>
                                <p class="mb-1"><b>Ф.И.О.:</b> {{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}</p>
                                <p class="mb-1"><b>E-mail:</b> {{ $user->email }}</p>
                                <p class="mb-1"><b>Роль:</b> {{ $roles[$user->role_id]->name }}</p>
                                <p class="mb-1"><b>Персональный доступ:</b> {!! $user->personal_access ? '<span class="text-danger">Да</span>' : '<span class="text-success">Нет</span>' !!}</p>
                            </td>
                            <td>
                                @php($accesses = isset($user_accesses[$user->id]) ? $user_accesses[$user->id] : (isset($role_accesses[$user->role_id]) ? $role_accesses[$user->role_id] : null))
                                @isset($accesses)
                                    @foreach($accesses as $access)
                                        <span class="badge badge-secondary font-size-100 mb-1">
                                            <b>{{ $access->access_name }}</b>
                                            {{ isset($access->access) ? $access->access->description : '' }}
                                        </span>
                                    @endforeach
                                @endisset
                            </td>
                            <td class="text-center" nowrap>

                                @if(auth()->user()->accesses->contains('admin.users.edit'))
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning text-white"
                                       data-toggle="tooltip" data-placement="top" title="Редактировать">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endif

                                @if(auth()->user()->accesses->contains('admin.users.accesses'))
                                    <a href="{{ route('admin.users.accesses', $user->id) }}" class="btn btn-info text-white"
                                       data-toggle="tooltip" data-placement="top" title="Разрешения">
                                        <span class="fas fa-cogs"></span>
                                    </a>
                                @endif

                                @if(auth()->user()->accesses->contains('admin.users.destroy') && $user->id != auth()->user()->id)
                                    <a href="#" class="btn btn-danger text-white" title="Удалить"

                                 >
                                        <span class="fa fa-trash-alt"></span>
                                    </a>
                                    <button type="button" class="d-none ajaxAction" id="usersDestroy{{ $user->id }}"
                                            data-success="removeRow ajaxActionErrorAlert"
                                            data-_method="DELETE" data-error-alert-text="Ошибка!"
                                            data-url="{{ route('admin.users.destroy', $user->id) }}">DELETE</button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer header-elements-inline flex-wrap">
                {{ $users->links() }}
                <div class="ml-auto">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">Добавить</a>
                </div>
            </div>

        </div>
    </div>

@endsection
