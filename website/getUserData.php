<?php
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(null);
        exit;
    }

    $data = json_decode(file_get_contents('JSON Files/Accounts.json'), true);

    foreach ($data as $user) {
        if ($user['email'] === $email) {
            echo json_encode($user);
            exit;
        }
    }
    echo json_encode(null); 
    ?>
