<?php

namespace App\Http\Controllers\Admin;

use App\Access;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Http\Controllers\Admin\Roles\Forms\RoleForm;
use App\Http\Controllers\Controller;
use App\Role;
use App\RoleAccess;
use App\UserAccess;
use App\User;
use Illuminate\Http\Request;
use Route;
use Validator;
use Session;

class RoleController extends Controller
{

    public function index()
    {
        $data['roles'] = Role::getWithAccesses();

        return view('admin.roles.index', $data);
    }

    public function create(FormBuilder $formBuilder, Role $role)
    {
        $form = $formBuilder->create(RoleForm::class, [
            'model' => $role,
        ]);

        return view('admin.resources.create-or-edit', compact('form'));
    }

    public function store(Request $request)
    {
        return $this->storeOrUpdate($request);
    }

    public function edit($id, FormBuilder $formBuilder)
    {
        $role = Role::findOrFail($id);

        $form = $formBuilder->create(RoleForm::class, [
            'model' => $role,
        ]);

        return view('admin.resources.create-or-edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        return $this->storeOrUpdate($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        $result = Role::deleteById($request->all(), $id);

        return redirect(action([get_class($this), 'index']));
    }

    public function storeOrUpdate($request, $id = null)
    {
        $data = $request->all();
        $validator = Validator::make($data, $this->rules($id));

        if ($validator->fails()) {
            $response = [
                'result' => false,
                'errors' => $validator->errors(),
            ];
        } else {
            if (Role::storeOrUpdate($data, $id)) {
                $text = isset($id) ? trans('admin.roles.successful_update') : trans('admin.roles.successful_creation');
                Session::flash('success', $text);
            } else {
                $text = isset($id) ? trans('admin.roles.not_successful_update') : trans('admin.roles.not_successful_creation');
                Session::flash('error', $text);
            }
            $response['result'] = true;
        }

        //return response()->json($response, 200);
        return redirect(action([get_class($this), 'index']));
    }

    public function rules($id = null)
    {
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['string', 'max:255', 'nullable'],
        ];

        return $rules;
    }

    public function accesses($id)
    {
        $roleAccesses = RoleAccess::all();
        $userAccesses = UserAccess::all();

        $data['role'] = Role::findOrFail($id);
        $data['routes'] = Route::getRoutes();
        $data['accesses'] = Access::all()->keyBy('name');
        $data['available_accesses'] = RoleAccess::getAccesses($id)->keyBy('access_name')->keys();
        $data['roles'] = Role::getByIds($roleAccesses->keyBy('role_id')->keys())->keyBy('id');
        $data['grouped_role_accesses'] = $roleAccesses->groupBy('access_name');
        $data['users'] = User::getByIds($userAccesses->keyBy('user_id')->keys())->keyBy('id');
        $data['grouped_user_accesses'] = $userAccesses->groupBy('access_name');

        return view('admin.roles.accesses', $data);
    }

    public function updateAccesses(Request $request, $id)
    {
        RoleAccess::updateById($id, $request->input('accesses'));

        return redirect(action([get_class($this), 'accesses'], ['id' => $id]));
    }

}
