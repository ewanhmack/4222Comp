<?php
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); 
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        exit();
    }


    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType !== "application/json") {
        http_response_code(415); 
        echo json_encode(['success' => false, 'error' => 'Content type not supported']);
        exit();
    }


    $content = trim(file_get_contents("php://input"));
    $data = json_decode($content, true);


    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400); 
        echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
        exit();
    }

    // Validate required fields
    if (!isset($data['email'], $data['FirstName'], $data['Surname'], $data['username'], $data['password'])) {
        http_response_code(400); 
        echo json_encode(['success' => false, 'error' => 'Missing required user information']);
        exit();
    }


    $accountsFilePath = 'JSON Files/Accounts.json';
    if (!file_exists($accountsFilePath)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Accounts file not found']);
        exit();
    }

    $accountsData = json_decode(file_get_contents($accountsFilePath), true);


    $updated = false;
    foreach ($accountsData as &$account) {
        if ($account['email'] === $data['email']) {
            // Update user details
            $account['FirstName'] = $data['FirstName'];
            $account['Surname'] = $data['Surname'];
            $account['username'] = $data['username'];
            $account['password'] = $data['password'];
            // Update the favouriteAlbumId 
            if (isset($data['favouriteAlbumId'])) {
                $account['favouriteAlbumId'] = $data['favouriteAlbumId'];
            }
            $updated = true;
            break;
        }
    }

    if (!$updated) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Account not found']);
        exit();
    }

    if (file_put_contents($accountsFilePath, json_encode($accountsData, JSON_PRETTY_PRINT)) === false) {
        http_response_code(500); 
        echo json_encode(['success' => false, 'error' => 'Failed to update the account']);
        exit();
    }

    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
?>
