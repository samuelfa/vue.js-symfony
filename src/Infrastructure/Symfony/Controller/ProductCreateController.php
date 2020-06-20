<?php


namespace App\Infrastructure\Symfony\Controller;


use App\Application\Product\CreateProductDTO;
use App\Application\Product\CreateProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductCreateController extends AbstractController
{
    public function view(Request $request, CreateProductService $service): JsonResponse
    {
        try {
            $dto = new CreateProductDTO(
                $request->request->get('reference'),
                $request->request->get('name'),
                $request->request->get('money'),
                $request->request->get('currency'),
                $request->request->getInt('stock'),
            );
            $service->__invoke($dto);
        } catch (\RuntimeException $exception){
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse();
    }
}