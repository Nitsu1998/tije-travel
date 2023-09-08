<?php

/**
 * Class Product represents a tourism product.
 */
class Product {
    private float $averageRating;
    private array $images;
    private string $meetingPoint;

    public function __construct() {
        $this->averageRating = 0.0;
        $this->images = [];
        $this->meetingPoint = "";
    }

    public function setAverageRating(float $rating): void {
        $this->averageRating = $rating;
    }

    public function setImages(array $imageUrls): void {
        $this->images = $imageUrls;
    }

    public function setMeetingPoint(string $point): void {
        $this->meetingPoint = $point;
    }

    public function toJSON(): string {
        $jsonArray = [
            "averageRating" => $this->averageRating,
            "images" => $this->images,
            "meetingPoint" => $this->meetingPoint
        ];

        return json_encode($jsonArray, JSON_PRETTY_PRINT);
    }

    public function calculateAverageRating(array $reviewCountTotals): void {

       if (empty($reviewCountTotals)) {
            $this->averageRating = 0.0;
            return;
        }

        $totalReviews = 0;
        $weightedSum = 0;

        foreach ($reviewCountTotals as $ratingData) {
            $rating = $ratingData['rating'];
            $count = $ratingData['count'];
        
            $totalReviews += $count;
            $weightedSum += $rating * $count;
        }

        $this->averageRating = round( $weightedSum / $totalReviews , 2);
    }

    public function findLargestImages(array $images): void {
        foreach ($images as $image) {
            $largestVariant = $image['variants'][0];
            foreach ($image['variants'] as $variant) {
                if ($variant['width'] > $largestVariant['width']) {
                    $largestVariant = $variant;
                }
            }
            $this->images[] = $largestVariant['url'];
        }
    }

    public function extractMeetingPoint(string $description): void {
        $pattern = "/Meeting point: (.+?)(\n|$)/i";
        if (preg_match($pattern, $description, $matches)) {
            $meetingPoint = ucfirst(trim($matches[1]));
            $this->meetingPoint = $meetingPoint;
        }
    }
}

?>
