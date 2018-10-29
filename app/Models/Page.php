<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use Sluggable;
    use HasTranslations;

    public $translatable = ['title', 'content', 'meta_keywords', 'meta_description'];

    protected $table = 'pages';
    protected $fillable = [
        'title',
        'slug',
        'content',
        'site_display',
        'meta_keywords',
        'meta_description',
    ];

    public function scopeActive($query)
    {
        return $query->where('site_display', 1);
    }


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function media()
    {
        return $this->morphMany(\App\Models\Media::class, 'imageable');
    }

    public function mainImage()
    {
        return $this->morphOne(\App\Models\Media::class, 'imageable')->where('main_image', 1);
    }
}
