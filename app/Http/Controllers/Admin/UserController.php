<?php

namespace App\Http\Controllers\Admin;

use App\Access;
use App\Http\Controllers\Admin\Users\Forms\UserForm;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Role;
use App\RoleAccess;
use App\User;
use App\UserAccess;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Route;

class UserController extends Controller
{
    use FormBuilderTrait;

    public function index()
    {
        $users = User::paginate();

        $roleIds = $users->keyBy('role_id')->keys();
        $userIds = $users->keyBy('id')->keys();

        $data = [
            'users' => $users,
            'roles' => Role::getByIds($roleIds)->keyBy('id'),
            'role_accesses' => RoleAccess::getWithAccessByIds($roleIds)->groupBy('role_id'),
            'user_accesses' => UserAccess::getWithAccessByIds($userIds)->groupBy('user_id'),
        ];

        return view('admin.users.index', $data);
    }


    public function create(FormBuilder $formBuilder, User $user)
    {
        $data['roles'] = Role::all();

        $form = $formBuilder->create(UserForm::class, [
            'model' => $user,
        ]);

        return view('admin.resources.create-or-edit', compact('form'));
    }

    public function store(Request $request)
    {
        return $this->storeOrUpdate($request);
    }

    public function edit($id, FormBuilder $formBuilder)
    {
        $user = User::findOrFail($id);

        $form = $formBuilder->create(UserForm::class, [
            'model' => $user,
        ]);

        return view('admin.resources.create-or-edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        return $this->storeOrUpdate($request, $id);
    }

    public function destroy($id)
    {
        $result = User::deleteById($id);

        return redirect(action([get_class($this), 'index']));
    }

    public function storeOrUpdate($request, $id = null)
    {
        $user = $id ? User::findOrFail($id) : new User();
        $data = $request->all();
        $form = $this->form(UserForm::class, [
            'model' => $user,
        ]);
        $form->redirectIfNotValid();

        User::storeOrUpdate($data, $id);

        return redirect(action([get_class($this), 'index']));
    }

    public function accesses($id)
    {
        $roleAccesses = RoleAccess::all();
        $userAccesses = UserAccess::all();

        $data = [
            'user' => User::findOrFail($id),
            'routes' => Route::getRoutes(),
            'accesses' => Access::all()->keyBy('name'),
            'available_accesses' => UserAccess::getAccesses($id)->keyBy('access_name')->keys(),
            'roles' => Role::getByIds($roleAccesses->keyBy('role_id')->keys())->keyBy('id'),
            'grouped_role_accesses' => $roleAccesses->groupBy('access_name'),
            'users' => User::getByIds($userAccesses->keyBy('user_id')->keys())->keyBy('id'),
            'grouped_user_accesses' => $userAccesses->groupBy('access_name'),
        ];
       /* $data['user'] = User::findOrFail($id);
        $data['routes'] = Route::getRoutes();
        $data['accesses'] = Access::all()->keyBy('name');
        $data['available_accesses'] = UserAccess::getAccesses($id)->keyBy('access_name')->keys();

        $data['roles'] = Role::getByIds($roleAccesses->keyBy('role_id')->keys())->keyBy('id');
        $data['grouped_role_accesses'] = $roleAccesses->groupBy('access_name');

        $data['users'] = User::getByIds($userAccesses->keyBy('user_id')->keys())->keyBy('id');
        $data['grouped_user_accesses'] = $userAccesses->groupBy('access_name');*/
        return view('admin.users.accesses', $data);
    }

    public function updateAccesses(Request $request, $id)
    {
        UserAccess::updateById($id, $request->input('accesses'));

        return redirect(action([get_class($this), 'index']));
    }
}
