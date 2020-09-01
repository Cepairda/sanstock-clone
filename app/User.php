<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
}
