<?php

namespace Core\Infrastructure\Db;

use Core\Infrastructure\Db\SchemaInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class OrderItemSchema implements SchemaInterface
{
    public static function run(): void
    {
        Capsule::schema()->create('order_items', function ($table) {
            $table->string('id')->primaryKey();
            $table->string('product_id');
            $table->string('order_id');
            $table->integer('quantity');
            $table->string('name');
            $table->float('price');

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }
}