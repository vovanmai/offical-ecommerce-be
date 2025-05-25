<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Category extends AbstractModel
{
    use Sluggable;

    const MAX_GRADE = 3;

    const TYPE_PRODUCT = 1;
    const TYPE_POST = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

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
        'status',
        'type',
        'order',
        'is_display_main_menu',
        'is_display_footer',
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
                'source' => 'name',
                'onUpdate' => true
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

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
