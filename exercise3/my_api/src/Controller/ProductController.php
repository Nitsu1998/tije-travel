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
        // Access the supplierId query parameter from the request
        $supplierId = $request->query->get('supplierId');

        // Use the custom repository method to retrieve products
        $products = $productRepository->findProductsBySupplierId($supplierId);

        // Transform products to the desired JSON format
        $data = [];
        foreach ($products as $product) {

            $media = [];
            $product_urls = $product->getProductMedia();
            foreach ($product_urls as $url) {
                array_push($media, $url->getUrl());
            }

            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'media' => $media,
                'description' => $product->getShortDescription(),
                'status' => $product->getStatus(),
                'createdAt' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $product->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($data);
    }
}
