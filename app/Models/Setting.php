<?php
namespace App\Models;

class Setting extends AbstractModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    const TYPE_INPUT = 'input';
    const TYPE_TEXTAREA = 'textarea';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
        'type',
        'value',
    ];
}
