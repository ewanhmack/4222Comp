<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("POST data received: " . print_r($_POST, true));
   
    $albumKey = $_POST['albumKey'] ?? '';
    $userEmail = $_POST['userEmail'] ?? ''; 
    $rating = $_POST['rating'] ?? '';
    $comment = $_POST['comment'] ?? '';

    
    if (empty($rating) || !in_array($rating, ['1', '2', '3', '4', '5'])) {
        
        header('Location: reviewForm.php?error=invalidrating'); 
        exit();
    }

    
    $accountsFilePath = 'JSON Files/Accounts.json';
    $reviewsFilePath = 'JSON Files/reviews.json';


    if (file_exists($accountsFilePath)) {
        $accounts = json_decode(file_get_contents($accountsFilePath), true);
        $userDetail = null;
        foreach ($accounts as $account) {
            if ($account['email'] === $userEmail) {
                $userDetail = $account['username']; 
                break;
            }
        }
    }
    if (file_exists($reviewsFilePath)) {
        $reviews = json_decode(file_get_contents($reviewsFilePath), true) ?: [];
    } else {
        $reviews = [];
    }

    $reviews[$albumKey][] = [
        'user' => $userDetail, 
        'rating' => $rating,
        'comment' => $comment,
        'date' => date('d-m-Y') 
    ];

    if (file_put_contents($reviewsFilePath, json_encode($reviews, JSON_PRETTY_PRINT))) {
        header('Location: Albums.php?key=' . urlencode($albumKey));
        exit();
    } else {
        header('Location: errorPage.php'); 
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
