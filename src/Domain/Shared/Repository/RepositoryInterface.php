<?php

namespace Domain\Shared\Repository;

interface RepositoryInterface
{
    public function create(object $entity): void;
    public function update(object $entity): void;
    public function find(string $id);
    public function findAll(): array;
}
