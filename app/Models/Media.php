<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'main_image',
        'client_file_name',
        'original_file_name',
        'conversions',
        'order',
        'size',
        'mime',
    ];

    public function setConversionsAttribute($value)
    {
        $this->attributes['conversions'] = json_encode($value);
    }

    public function getConversionsAttribute($value)
    {
        $conversions = json_decode($value, true);

        foreach ($conversions as $k => $conversion)
        {
            $conversions[$k]['url'] = asset('storage/media/' . $conversion['name']);
        }

        return $conversions;

    }

    public function getOriginalFileNameAttribute($value)
    {
        return asset('storage/media/'.$value);
    }




}
