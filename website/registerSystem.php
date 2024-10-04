<?php
    session_start();  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Define the file path for the JSON file
        $file_path = "JSON Files/Accounts.json";

        // Extract form data
        $name = $_POST["txtName"];
        $surname = $_POST["txtSurname"];
        $username = $_POST["txtUsername"];
        $email = $_POST["txtEmail"];
        $password = $_POST["txtPassword"]; 
        $dob = $_POST["txtDOB"];
        
        // Create an array with the form data
        $data = array(
            'FirstName' => $name,
            'Surname' => $surname,
            'username' => $username,
            'email' => $email,
            'password' => $password, 
            'dob' => $dob,
            'favouriteAlbumId' => "0"
        );

        $array_data = file_exists($file_path) ? json_decode(file_get_contents($file_path), true) : array();

        // Check if the email or username already exists
        $emailExists = false;
        $usernameExists = false;
        foreach ($array_data as $item) {
            if ($item['email'] === $email) {
                $emailExists = true;
            }
            if ($item['username'] === $username) {
                $usernameExists = true;
            }
        }

        if ($emailExists) {
            $_SESSION['error'] = 'emailExists';
            header('Location: register.php');
            exit;
        } else if ($usernameExists) {
            $_SESSION['error'] = 'usernameExists';
            header('Location: register.php');
            exit;
        }

        // Append the new data to the array
        $array_data[] = $data;


        if (file_put_contents($file_path, json_encode($array_data, JSON_PRETTY_PRINT))) {

            echo "<script>
                    localStorage.setItem('userEmail', " . json_encode($email) . ");
                    window.location.href = 'index.php'; // Redirect to index without parameters
                </script>";
            exit;
        } else {
            echo 'Error saving data. Please try again.';
        }
    } else {
        header('Location: register.php'); 
        exit;
    }
?>
