<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Translatable\HasTranslations;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasTranslations;
    use NodeTrait, Sluggable {
        Sluggable::replicate as replicateSluggable;
        NodeTrait::replicate insteadof Sluggable;
    }

    public $translatable = ['name', 'url'];

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'parent_id',
        'owner',
        'url',
        'target',
        'handler'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'category_id', 'id')
            ->where('owner', 'menus')->orderBy('position', 'asc');
    }
}
