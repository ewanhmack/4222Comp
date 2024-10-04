<?php
    $albumKey = $_GET['albumKey'] ?? '';
    $filePath = 'JSON Files/reviews.json';

    function dateToTimestamp($dateStr) {
        // Converts date from 'd-m-Y' format to a timestamp
        return DateTime::createFromFormat('d-m-Y', $dateStr)->getTimestamp();
    }

    if (file_exists($filePath)) {
        $reviewsData = json_decode(file_get_contents($filePath), true);
        $albumReviews = $reviewsData[$albumKey] ?? [];

        // Sort the reviews array by most recent date
        usort($albumReviews, function ($a, $b) {
            return dateToTimestamp($b['date']) - dateToTimestamp($a['date']);
        });

        echo json_encode($albumReviews);
    } else {
        echo json_encode([]);
    }

?>
