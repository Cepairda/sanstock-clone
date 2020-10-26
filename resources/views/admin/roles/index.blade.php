@extends('layouts.admin')

@section('content')

    @php($controllerClass = get_class(request()->route()->controller))

    <div class="content pt-0">
        <div class="card">

            <div class="card-header">
                {{ $roles->links() }}

                <h3 class="card-title">
                    {{ Str::before(class_basename($controllerClass), 'Controller') }}
                </h3>
                <div class="card-tools">
                    <a href="{{ action([$controllerClass, 'create']) }}"
                        class="text-success d-inline-block px-3">
                        <span class="far fa-plus-square"></span> Добавить
                    </a>
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

                                @if(auth()->user()->accesses->contains('admin.roles.edit'))
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                        class="btn btn-warning text-white">
                                        <span class="far fa-edit"></span>
                                    </a>
                                @endif

                                @if(auth()->user()->accesses->contains('admin.roles.accesses'))
                                    <a href="{{ route('admin.roles.accesses', $role->id) }}"
                                        class="btn btn-info text-white">
                                        <span class="fa fa-cogs"></span>
                                    </a>
                                @endif

                                @if(auth()->user()->accesses->contains('admin.roles.destroy') && !in_array($role->id, [1, 2]))
                                    <a href="{{ route('admin.roles.destroy', $role->id) }}"
                                        class="btn btn-danger ajaxActionPrompt">
                                        <span class="fa fa-trash-alt"></span>
                                    </a>

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
