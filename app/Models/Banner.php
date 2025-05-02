<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;

class Banner extends AbstractModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banners';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'url',
    ];

    /**
     * Get image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('key', 'image')->orderBy('id', 'desc');
    }
}
