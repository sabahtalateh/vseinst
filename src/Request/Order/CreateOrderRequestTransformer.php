<?php

namespace App\Request\Order;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateOrderRequestTransformer
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return Product[]
     */
    public function transform(array $data): array
    {
        $productIds = $data['product_ids'] ?? [];
        if ([] === $productIds) {
            throw new BadRequestHttpException('No product_ids provided.');
        }

        $products = $this->productRepository->findBy(['id' => $productIds]);
        if (empty($products)) {
            throw new BadRequestHttpException('No products found for provided ids.');
        }

        return $products;
    }
}
