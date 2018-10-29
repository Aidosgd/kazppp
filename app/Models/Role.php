<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name'];

    public $timestamps = false;

    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    public function presentPermissions()
    {
        $tpl = '<ul class="list-group">';

        foreach ($this->permissions as $permission) {
            $tpl .= '<li class="list-group-item">' . $permission->name . '</li>';
        }
        $tpl .= '</ul>';

        return $tpl;
    }
}
