<?php


namespace App\Infrastructure\Symfony\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductCreateController extends AbstractController
{
    public function view(string $locale, Request $request): JsonResponse
    {
        //TODO:...
    }
}