<?php

namespace Core\Infrastructure\Checkout\Repository;

use Core\Infrastructure\Chechout\Repository\OrderItemModel;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Customer\Repository\CustomerModel;

class OrderModel extends Model
{
    protected $table = 'orders';

    protected $keyType = 'string';
    
    public $incrementing = false;

    protected $fillable = [
        'id',
        'customer_id',
        'total'
    ];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItemModel::class, 'order_id');
    }
}
