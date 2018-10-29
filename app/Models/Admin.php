<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Admin extends BaseModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, Notifiable;
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'super_user',
    ];

    protected $hidden = [
        'password',
    ];

    protected $filterable = [
        'id',
        'name',
        'email',
        'active'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function roles()
    {
        return $this->belongsToMany(
            \App\Models\Role::class,
            'role_admins',
            'admin_id',
            'role_id'
        );
    }

    // presentors

    public function isActive()
    {
        return ($this->active) ? 'Да' : 'Нет';
    }

    public function isSuper()
    {
        return ($this->super_user) ? 'Да' : 'Нет';
    }

    public function canUse($perm)
    {
        $userId = Auth::guard('admins')->id();
        $user = $this->with('roles.permissions')->where('id', $userId)->first();

        if ($user->super_user) {
            return true;
        }

        $permissions = [];

        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->alias;
            }
        }
        return in_array($perm, $permissions);
    }
}