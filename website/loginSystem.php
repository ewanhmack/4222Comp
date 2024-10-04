<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email and password from POST request
    $email = $_POST['txtEmail'];
    $password = $_POST['txtPassword']; 

    $rememberMe = isset($_POST['remember']) && $_POST['remember'] == 'on';

    
    $filePath = 'JSON Files/Accounts.json';

    // Check if Accounts.json exists and is readable
    if (file_exists($filePath) && is_readable($filePath)) {
        // Read the file and decode the JSON data to an array
        $accounts = json_decode(file_get_contents($filePath), true);

        
        $loginSuccess = false;

        // Loop through accounts to find a match
        foreach ($accounts as $account) {
            // Verify if the email matches and the password is correct
            
            if ($account['email'] === $email && $account['password'] === $password) {
                $loginSuccess = true;
                break; 
            }
        }

        // Redirect or display a message depending on login success
        if ($loginSuccess) {
            if ($rememberMe) {
                        setcookie('user', base64_encode($email), time() + (86400 * 30), "/"); // 30 days expiration
                    }
            echo "<script>
                    localStorage.setItem('userEmail', " . json_encode($email) . ");
                    window.location.href = 'index.php'; 
                  </script>";
            exit();
        } else {
             // Login failed
            header('Location: login.php?error=incorrectDetails');
            
        }
    } else {
        // Error message if Accounts.json doesn't exist or isn't readable
        echo 'Error: Unable to read the accounts data.';
    }
} else {
    // If the form wasn't submitted, redirect to the login page
    header('Location: login.php');
}
?>
