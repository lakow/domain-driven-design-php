<?php

namespace Core\Infrastructure\Db;

use Core\Infrastructure\Db\SchemaInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class OrderSchema implements SchemaInterface
{
    public static function run(): void
    {
        Capsule::schema()->create('orders', function ($table) {
            $table->string('id')->primaryKey();
            $table->string('customer_id');
            $table->float('total');

            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }
}