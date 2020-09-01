<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public static function getAccesses($roleId)
    {
        return self::where('role_id', $roleId)->get();
    }

    public static function updateById($id, $accesses)
    {
        self::where('role_id', $id)->delete();
        if (isset($accesses)) {
            foreach ($accesses as $accessName) {
                self::create([
                    'responsible_user_id' => auth()->user()->id,
                    'role_id' => $id,
                    'access_name' => $accessName
                ]);
            }
        }
        return true;
    }

    public static function getWithAccessByIds($roleIds)
    {
        return self::with('access')->whereIn('role_id', $roleIds)->get();
    }

    public function access()
    {
        return $this->hasOne('App\Access', 'name', 'access_name');
    }

}
