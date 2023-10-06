<?php

namespace Core\Infrastructure\Db;

interface SchemaInterface
{
    public static function run(): void;
}
