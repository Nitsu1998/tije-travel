<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductsRepository;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products')]
    public function listProducts(Request $request, ProductsRepository $productRepository)
    {
        $supplierId = $request->query->get('supplierId');

        $products = $productRepository->findProductsBySupplierId($supplierId);

        $data = array_map(function ($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'media' => array_map(function ($media) {
                    return $media->getUrl();
                }, $product->getProductMedia()->toArray()),
                'description' => $product->getShortDescription(),
                'status' => $product->getStatus(),
                'createdAt' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $product->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $products);
    
        return new JsonResponse($data);
    }
}
