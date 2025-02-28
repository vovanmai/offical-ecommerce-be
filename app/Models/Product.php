<?php
namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends AbstractModel
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
        'category_id',
        'active',
        'description',
        'price',
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
     * Get previewImage.
     */
    public function previewImage(): MorphOne
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('key', 'preview_image');
    }
}
