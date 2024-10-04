<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css Files/login.css"> 
    <link rel="stylesheet" href="css Files/dropdown.css"> 
    <link rel="stylesheet" href="css Files/Main.css"> 
    <link rel="stylesheet" href="css Files/Nav.css">
    <link rel="stylesheet" href="css Files/dynamicsize.css">
    <link rel="icon" type="image/png" href="Images/SongShackIcon.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="hideData.js"></script>
    <title>Register</title>
    <style>
        .wrapper2{
            margin-top: 120px;
            position: relative; 
        }
        #errorMessage {
            color: red;
            display: none; 
            text-align: center; 
            margin-top: 20px; 
            width: 100%;
        }
    </style>
</head>
<body>
    </br></br></br></br></br></br></br>
    <header>
        <a href="index.php">
            <img src="Images/SongShack.png" alt="Logo" id="logo">
        </a>  
        <a href="whistle.html">.</a>
        <span id="usernameDisplay"></span>

        <div class="dropdown">
        <button class="dropbtn"><ion-icon name="reorder-two-outline" id="menuIcon"></ion-icon></ion-icon></button>

            <div class="dropdown-content">
                <a href="index.php">Home Page</a>
                <a href="ranking.php">Ranking Page</a>
                <a href="newAlbum.php" id="addAlbums">Add a new Album</a>
                <a href="login.php" id="loginLink">Login</a>
                <a href="profile.php" id="profileLink">Profile Page</a>
            </div>
        </div>
    </header>

    <div popover class="wrapper2">
        
        <form id="registrationForm" method="post" action="registerSystem.php">
            <div class="form-box register">
                <h2>Register</h2>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <input type="text" name="txtName" required>
                    <label for="txtName">First Name</label>
                </div>

                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <input type="text" name="txtSurname" required>
                    <label for="txtSurname">Surname</label>
                </div>

                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" name="txtUsername" required>
                    <label for="txtUsername">Username</label>
                </div>

                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="txtEmail" required>
                    <label for="txtEmail">Email</label>
                </div>

                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" id="txtPassword" name="txtPassword" required>
                    <label for="txtPassword">Password</label>
                    
                </div>
                

                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="calendar-outline"></ion-icon>
                    </span>
                    <input type="date" name="txtDOB" required>
                </div>

                <div class="remember-forget">
                    <input type="checkbox" name="terms" required>
                    <label for="terms"><a href="termsAndConditions.html">Agree to terms & conditions</a></label>
                </div>

                <button type="submit" class="btn">Register</button>

                <div class="login-register">
                    <p>Already have an account? <a href="login.php" class="login-link">Login</a></p>
                </div>
            </div>
        </form>
        <div id="errorMessage" style="color:red; display:none;"></div>
        </br>
    </div>
    
    <script>
        //Email and username avaliablility checker
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            if (error === 'emailExists') {
                const errorMessageDiv = document.getElementById('errorMessage');
                errorMessageDiv.textContent = 'An account with this email already exists.';
                errorMessageDiv.style.display = 'block';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            if (error === 'usernameExists') {
                const errorMessageDiv = document.getElementById('errorMessage');
                errorMessageDiv.textContent = 'An account with this username already exists.';
                errorMessageDiv.style.display = 'block';
            }
        });

        
        document.addEventListener('DOMContentLoaded', function() {
            var today = new Date();

            var oneHundredYearsAgo = new Date();
            oneHundredYearsAgo.setFullYear(today.getFullYear() - 100);

            var eighteenYearsAgo = new Date();
            eighteenYearsAgo.setFullYear(today.getFullYear() - 18);

            
            var formattedOneHundredYearsAgo = oneHundredYearsAgo.toISOString().split('T')[0];
            var formattedEighteenYearsAgo = eighteenYearsAgo.toISOString().split('T')[0];

            var dobInput = document.querySelector('input[name="txtDOB"]');
            // Set the maximum date allowed (18 years ago from today)
            dobInput.setAttribute('max', formattedEighteenYearsAgo);
            // Set the minimum date allowed (100 years ago from today)
            dobInput.setAttribute('min', formattedOneHundredYearsAgo);
        });


        document.addEventListener('DOMContentLoaded', function() {
            var passwordInput = document.getElementById('txtPassword');

            passwordInput.addEventListener('input', function() {
                var password = passwordInput.value;
                var errorMessage = document.getElementById('passwordError');

                if(password.length >= 8 && /\d/.test(password)) {

                    if(errorMessage) {
                        errorMessage.textContent = ''; 
                    }
                    
                    
                } else {

                    if(!errorMessage) {
                        errorMessage = document.createElement('div');
                        errorMessage.id = 'passwordError';
                        errorMessage.style.color = 'red';
                        passwordInput.parentNode.insertBefore(errorMessage, passwordInput.nextSibling);
                    }
                    errorMessage.textContent = 'Password must be at least 8 characters long and include a number.';
                    document.getElementById('submitBtn').disabled = true;
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const registered = urlParams.get('registered');
            const email = urlParams.get('email');
            
            if (registered && email) {
                localStorage.setItem('userEmail', decodeURIComponent(email)); 
                alert("Registration successful! Your details have been saved.");
                window.location.href = 'profile.php'; 
            }

            const error = urlParams.get('error');
            if (error === 'emailExists') {
                const errorMessageDiv = document.getElementById('errorMessage');
                errorMessageDiv.textContent = 'An account with this email already exists.';
                errorMessageDiv.style.display = 'block';
            } else if (error === 'usernameExists') {
                const errorMessageDiv = document.getElementById('errorMessage');
                errorMessageDiv.textContent = 'An account with this username already exists.';
                errorMessageDiv.style.display = 'block';
            }
        });
        </script>
        
        <footer>
            <p>&copy;Ewan MacKerracher : 2024 SongShack</p>
        </footer>
</body>

</html>
