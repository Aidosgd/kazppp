<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable  = [
        'alias',
        'owner',
        'display_name',
        'data'
    ];

    public function getDataAttribute($value)
    {
        $data = json_decode($value, true);
        return (is_array($data)) ? $data : [];
    }
}
