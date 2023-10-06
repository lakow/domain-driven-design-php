<?php

namespace Core\Infrastructure\Db;

use Core\Infrastructure\Db\SchemaInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class ProductSchema implements SchemaInterface
{
    public static function run(): void
    {
        Capsule::schema()->create('products', function ($table) {
            $table->string('id')->primaryKey();
            $table->string('name');
            $table->float('price');
        });
    }
}