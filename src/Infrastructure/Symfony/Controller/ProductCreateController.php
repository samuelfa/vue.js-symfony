<?php

namespace App\Infrastructure\Symfony\Controller;

use App\Application\Product\Create\CreateProductDTO;
use App\Application\Product\Create\CreateProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductCreateController extends AbstractController
{
    public function view(Request $request, CreateProductService $service): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $dto = new CreateProductDTO(
                $data['reference'] ?? '',
                $data['name'] ?? '',
                $data['money'] ?? 0.0,
                $data['currency'] ?? '',
                $data['stock'] ?? 0
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
