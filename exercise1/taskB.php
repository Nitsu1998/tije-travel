<?php
require 'Product.php';

$jsonData = file_get_contents('products.json');
$productData = json_decode($jsonData, true);

function parseProduct($product) {
    $newProduct = new Product();
    $newProduct->calculateAverageRating($product['reviews']['totalReviews'] ? $product['reviews']['reviewCountTotals'] : []);
    $newProduct->findLargestImages($product['images']);
    $newProduct->extractMeetingPoint($product['description']);
    return $newProduct;
}

if (isset($productData['products']) && is_array($productData['products'])) {

    $activeProducts = array_filter($productData['products'], function ($productData) {
        return $productData['status'] === 'ACTIVE';
    });

    $products = array_map('parseProduct', $activeProducts);

    foreach ($products as $product) {
        echo $product->toJSON() . "\n";
    }
}

?>