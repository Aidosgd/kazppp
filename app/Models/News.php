<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use Sluggable;
    use HasTranslations;

    public $translatable = ['title', 'short_content', 'long_content', 'meta_keywords', 'meta_description'];

    protected $table = 'news';

    protected $fillable = [
        'category_id',
        'title',
        'short_content',
        'long_content',
        'is_pinned',
        'is_main',
        'site_display',
        'meta_description',
        'meta_keywords',
        'slug'
    ];

    public function setSiteDisplayAttribute($value)
    {
        $this->attributes['site_display'] = ($value) ? 1 : 0;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id');
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
