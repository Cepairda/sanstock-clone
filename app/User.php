<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['accesses'];

    public function getAvatarUrlAttribute()
    {
//        return $this->attributes['avatar_url'] ?? $this->attributes['avatar_url'] = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));

//        if (!isset($this->attributes['avatar_url'])) {
//            $this->attributes['avatar_url'] = isset($this->avatar) ? asset($this->avatar) :
//                'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
//        }
//        return $this->attributes['avatar_url'];
    }

    public function getAccessesAttribute()
    {
        if (!isset($this->attributes['accesses'])) {
            $this->attributes['accesses'] = $this->personal_access ?
                UserAccess::getAccesses($this->id)->keyBy('access_name')->keys() :
                RoleAccess::getAccesses($this->role_id)->keyBy('access_name')->keys();
        }

        return $this->attributes['accesses'];
    }

    public static function getByIds($ids)
    {
        return self::whereIn('id', $ids)->get();
    }

    public static function storeOrUpdate($data, $id)
    {
        $password = isset($data['password']) ? Hash::make($data['password']) : $data['old_password'];
        $storeOrUpdateData = [
            'email' => $data['email'],
            'password' => $password,
            'role_id' => $data['role_id'],
            'surname' => $data['surname'],
            'name' => $data['name'],
            'patronymic' => $data['patronymic'],
        ];

        if (isset($id)) {
            self::where('id', $id)->update($storeOrUpdateData);
        } else {
            self::create($storeOrUpdateData);
        }

        return true;
    }
}
