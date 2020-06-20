<?php

namespace App\Infrastructure\Symfony\Controller;

use App\Application\Product\Delete\DeleteProductDTO;
use App\Application\Product\Delete\DeleteProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductDeleteController extends AbstractController
{
    public function view(string $reference, DeleteProductService $service): JsonResponse
    {
        try {
            $dto = new DeleteProductDTO(
                $reference
            );
            $service->__invoke($dto);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse();
    }
}
