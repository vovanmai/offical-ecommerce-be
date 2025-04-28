<?php
namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends AbstractModel
{
    use Sluggable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id',
        'status',
        'description',
        'price',
        'inventory_quantity',
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
                'onUpdate' => true,
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get previewImage.
     */
    public function previewImage(): MorphOne
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('key', 'preview_image');
    }

    /**
     * Get previewImage.
     */
    public function detailFiles(): MorphMany
    {
        return $this->morphMany(Upload::class, 'uploadable')->where('key', 'detail_file');
    }
}
