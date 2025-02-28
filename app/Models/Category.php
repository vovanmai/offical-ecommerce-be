<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Category extends AbstractModel
{
    use Sluggable;

    const MAX_GRADE = 3;

    const TYPE_PRODUCT = 1;
    const TYPE_POST = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'active',
        'type',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the user that owns the phone.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
