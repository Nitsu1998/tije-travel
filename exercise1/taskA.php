<?php
require_once 'Product.php';

$product = new Product();
$product->setAverageRating(2.54);
$product->setImages([
    "https://hare-media-cdn.tripadvisor.com/media/attractions-splice-spp-640x480/0a/a0/8f/aa.jpg",
    "https://hare-media-cdn.tripadvisor.com/media/attractions-splice-spp-640x480/0a/a0/8f/bb.jpg"
]);
$product->setMeetingPoint("Outside the hotel");

$jsonData = $product->toJSON();
echo $jsonData;
?>
