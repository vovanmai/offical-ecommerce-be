<?php
namespace App\Models;


class Order extends AbstractModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    const PAYMENT_METHOD_COD = 1; // Cash on delivery

    const STATUS_PENDING = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_SHIPPING = 3;
    const STATUS_DELIVERED = 4;
    const STATUS_CANCELLED = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'shipping_address',
        'note',
        'status',
        'user_id',
        'total',
        'shipping_fee',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
