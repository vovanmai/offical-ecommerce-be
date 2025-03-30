<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends AbstractModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'uploads';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'uploadable_id',
        'uploadable_type',
        'path',
        'filename',
        'file_size',
        'data',
    ];
}
