<?php

namespace Core\Infrastructure\Chechout\Repository;

use Illuminate\Database\Eloquent\Model;
use Infrastructure\Product\Repository\ProductModel;

class OrderItemModel extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'id',
        'product_id',
        'order_id',
        'quantity',
        'name',
        'price'
    ];

    protected $keyType = 'string';
    
    public $incrementing = false;

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }
}
