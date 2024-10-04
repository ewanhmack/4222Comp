<?php
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {

            $content = trim(file_get_contents("php://input"));

            $decoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400); 
                echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
                exit();
            }

            $email = $decoded['email'] ?? null;
            $favouriteAlbumId = $decoded['favouriteAlbumId'] ?? null;


            if (!$email || !$favouriteAlbumId) {
                http_response_code(400); 
                echo json_encode(['success' => false, 'error' => 'Missing email or favorite album ID']);
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
                if ($account['email'] === $email) {
                    $account['favouriteAlbumId'] = $favouriteAlbumId;
                    $updated = true;
                    break;
                }
            }

            if ($updated) {
                if (file_put_contents($accountsFilePath, json_encode($accountsData, JSON_PRETTY_PRINT)) === false) {
                    http_response_code(500); 
                    echo json_encode(['success' => false, 'error' => 'Failed to update the account']);
                    exit();
                }

                echo json_encode(['success' => true]);
            } else {
                http_response_code(404); 
                echo json_encode(['success' => false, 'error' => 'Account not found']);
            }
        } else {
            http_response_code(415); 
            echo json_encode(['success' => false, 'error' => 'Content type not supported']);
        }
    } else {
        http_response_code(405); 
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
?>
