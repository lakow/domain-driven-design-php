<?php

namespace Core\Infrastructure\Customer\Repository;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'id',
        'name',
        'street',
        'number',
        'zipcode',
        'city',
        'active',
        'reward_points'
    ];

    protected $keyType = 'string';
    
    public $incrementing = false;

    public $timestamps = false;

    public $casts = [
        'active' => 'boolean',
        'reward_points' => 'integer',
    ];
}
