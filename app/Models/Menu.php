<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use HasTranslations;

    public $translatable = ['title'];

    protected $table = 'menus';

    protected $fillable = [
        'title',
        'category_id',
        'url',
        'site_display',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
