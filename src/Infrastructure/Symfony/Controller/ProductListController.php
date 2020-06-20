<?php


namespace App\Infrastructure\Symfony\Controller;


use App\Application\Product\ProductListService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductListController
{
    public function view(ProductListService $service): JsonResponse
    {
        return new JsonResponse($service->__invoke());
    }
}