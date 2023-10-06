<?php

namespace Core\Infrastructure\Db;

use Core\Infrastructure\Db\SchemaInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class CustomerSchema implements SchemaInterface
{
    public static function run(): void
    {
        Capsule::schema()->create('customers', function ($table) {
            $table->string('id')->primaryKey();
            $table->string('name');
            $table->string('street');
            $table->string('number');
            $table->string('zipcode');
            $table->string('city');
            $table->boolean('active');
            $table->integer('reward_points');
        });
    }
}
