<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Role;
use App\RoleAccess;
use App\SalePoint;
use App\User;
use App\UserAccess;

class UserController extends Controller
{
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
}
