<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends BaseController
{
    public function all(Request $request): JsonResponse
    {
        /** @var ProductService $productService */
        $productService = $this->container->get(ProductService::class);

        return $this->jsonResponse($productService->getAll());
    }
}
