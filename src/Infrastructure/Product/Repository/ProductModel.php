<?php

namespace Core\Infrastructure\Product\Repository;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'price',
    ];

    protected $keyType = 'string';
    
    public $incrementing = false;

    public $timestamps = false;

    public $casts = [
        'price' => 'float',
    ];
}
