<?php
require 'Product.php';

$jsonData = file_get_contents('products.json');
$productData = json_decode($jsonData, true);

// Function to process a product
function parseProduct($product) {
    $newProduct = new Product();
    $newProduct->calculateAverageRating($product['reviews']['totalReviews'] ? $product['reviews']['reviewCountTotals'] : []);
    $newProduct->findLargestImages($product['images']);
    $newProduct->extractMeetingPoint($product['description']);
    return $newProduct;
}

// Process all products
if (isset($productData['products']) && is_array($productData['products'])) {

    // Filter the array of products and keep only those whose status is active
    $activeProducts = array_filter($productData['products'], function ($productData) {
        return $productData['status'] === 'ACTIVE';
    });

    $products = array_map('parseProduct', $activeProducts);

    // Print the processed products in JSON format
    foreach ($products as $product) {
        echo $product->toJSON() . "\n";
    }
}

?>