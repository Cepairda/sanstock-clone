@extends('layouts.admin')

@section('content')
    @php($controllerClass = get_class(request()->route()->controller))
    <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Разрешения для пользователя ({{ $user->email }} [ID:{{ $user->id }}])</h4>
            </div>
        </div>
    </div>

    <div class="content pt-0">
        <div class="card">
            <form action="{{ route('admin.users.accesses.update', $user->id) }}" method="POST">

                {{ csrf_field() }}

                <div class="card-header">
                    <h3 class="card-title">
                        {{ Str::before(class_basename($controllerClass), 'Controller') }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ action([$controllerClass, 'index']) }}"
                           class="text-danger d-inline-block px-3">
                            <span class="far fa-times-circle"></span> Отмена
                        </a>
                        <span class="fas fa-grip-lines-vertical"></span>
                        <button
                            class="btn text-success d-inline-block px-3">
                            <span class="far fa-plus-square"></span> Сохранить
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">
                                Выбрать
                            </th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Данные</th>
                            <th>Доступно ролям</th>
                            <th>Доступно пользователям (персонально)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($routes as $route)
                            @if(in_array('checkAccess', $route->gatherMiddleware()))
                                @php($routeName = $route->getName())
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check form-check-switch form-check-switch-left">
                                            <input type="checkbox" name="accesses[]" value="{{ $routeName }}" id="{{ $routeName }}"
                                                   {{ $available_accesses->contains($routeName) ? 'checked' : '' }}
                                                   class="form-check-input form-check-input-switch" data-on-text="On" data-size="small"
                                                   data-off-text="Off" data-on-color="success" data-off-color="default">
                                            <label for="{{ $routeName }}" class="form-check-label d-flex align-items-center"></label>
                                        </div>
                                    </td>
                                    <td>{{ $routeName }}</td>
                                    <td>{{ isset($accesses[$routeName]) ? $accesses[$routeName]->description : '' }}</td>
                                    <td>
                                        @php($actionName = $route->getActionName())
                                        <b>URI:</b> {{ $route->uri() }}<br>
                                        <b>METHOD:</b> {{ $route->methods()[0] }}<br>
                                        <b>CONTROLLER:</b>
                                        {{ mb_substr(mb_substr($actionName, 0, strrpos($actionName, '@')), strrpos($actionName, '\\') + 1, strlen($actionName)) }}
                                        <br>
                                        <b>ACTION:</b> {{ $route->getActionMethod() }}<br>
                                    </td>
                                    <td>
                                        @isset($grouped_role_accesses[$routeName])
                                            @foreach($grouped_role_accesses[$routeName] as $role_access)
                                                <div>
                                                    {{ $roles[$role_access->role_id]->name }}
                                                    (<b>ID:</b> {{ $roles[$role_access->role_id]->id }})
                                                </div>
                                            @endforeach
                                        @endisset
                                    </td>
                                    <td>
                                        @isset($grouped_user_accesses[$routeName])
                                            @foreach($grouped_user_accesses[$routeName] as $user_access)
                                                <div>
                                                    {{ $users[$user_access->user_id]->name }}
                                                    {{ $users[$user_access->user_id]->surname }}
                                                    (<b>E-mail:</b> {{ $users[$user_access->user_id]->email }},
                                                    <b>ID:</b> {{ $users[$user_access->user_id]->id }})
                                                </div>
                                            @endforeach
                                        @endisset
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="card-footer header-elements-inline">

                </div>

            </form>
        </div>
    </div>

@endsection
