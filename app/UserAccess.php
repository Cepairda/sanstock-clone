<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{

    protected $guarded = [];
    public $timestamps = false;

    public static function getAccesses($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    public static function getWithAccessByIds($userIds)
    {
        return self::with('access')->whereIn('user_id', $userIds)->get();
    }

    public function access()
    {
        return $this->hasOne('App\Access', 'name', 'access_name');
    }

    public static function updateById($id, $accesses)
    {
        self::where('user_id', $id)->delete();
        if (isset($accesses)) {
            User::where('id', $id)->update(['personal_access' => 1]);
            foreach ($accesses as $accessName) {
                self::create([
                    'responsible_user_id' => auth()->user()->id,
                    'user_id' => $id,
                    'access_name' => $accessName
                ]);
            }
        } else {
            User::where('id', $id)->update(['personal_access' => 0]);
        }
        return true;
    }

}
