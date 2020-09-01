<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $guarded = [];
    protected $perPage = 30;

    public static function storeOrUpdate($data, $id)
    {
        $storeOrUpdateData = [
            'name' => $data['name'],
            'description' => $data['description'],
        ];

        if (isset($id)) {
            self::where('id', $id)->update($storeOrUpdateData);
        } else {
            self::create($storeOrUpdateData);
        }

        return true;
    }

    public static function deleteById($data, $id)
    {
        $role = self::find($data['new_role_id']);

        if (isset($role) && $role->id != $id && !in_array($id, [1, 2])) {

            User::where('role_id', $id)->update(['role_id' => $role->id]);
            RoleAccess::where('role_id', $id)->delete();
            Role::where('id', $id)->delete();
            return true;

        } else {
            return false;
        }
    }

    public static function getWithAccesses()
    {
        return self::with(['accesses' => function ($query) {
            $query->with('access');
        }])->paginate();
    }

    public static function getByIds($ids)
    {
        return self::whereIn('id', $ids)->get();
    }

    public function accesses()
    {
        return $this->hasMany('App\RoleAccess', 'role_id', 'id');
    }

}
