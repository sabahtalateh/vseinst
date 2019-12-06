<?php

namespace App\Repository;

use App\Entity\Product;

class ProductRepository extends AbstractRepository
{
    protected function entityClass(): string
    {
        return Product::class;
    }
}
