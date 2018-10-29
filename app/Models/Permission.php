<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'group_id',
        'alias',
        'name',
        'desc',
    ];

    public $timestamps = false;

    public function filter()
    {
        $q = $this->orderBy('created_at', 'desc')->get();

        return $q->paginate(2);
    }

    public function group()
    {

        return $this->belongsTo(\App\Models\PermissionGroup::class, 'group_id');
    }


}
