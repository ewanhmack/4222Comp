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
    <title>Login</title>
</head>

<body>
    <form name="Register" method="post" action="loginSystem.php">
        </br>
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

        <div popover class="wrapper">
            <div class="form-box login">
                <h2>Login</h2>
                <form action="#">
                    
                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="mail"></ion-icon>
                        </span>
                        <input type="email" id="txtEmail" name="txtEmail" required>
                        <label for="txtEmail">Email</label>
                    </div>

                    <div class="input-box">
                        <span class="icon">
                            <ion-icon name="lock-closed"></ion-icon>
                        </span>
                        <input type="password" id="txtPassword" name="txtPassword" required>
                        <label for="txtPassword">Password</label>
                    </div>

                    <div class="remember-forget">
                        <label><input type="checkbox" name="remember">Remember Me</label>
                        <a href="#">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn">Login</button>

                    <div class="login-register">
                        <p>Don't have an account? <a href="register.php" class="register-link">Register</a></p>
                    </div>
                </form>
                <div id="errorMessage" style="color:red; display:none;"></div>
            </div>     
            
        </div>
    </form>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            if (error === 'incorrectDetails') {
                const errorMessageDiv = document.getElementById('errorMessage');
                errorMessageDiv.textContent = 'Email or password is incorrect';
                errorMessageDiv.style.display = 'block';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.forms['Register'];
            const txtEmail = document.getElementById('txtEmail');
            const rememberMeCheckbox = loginForm.querySelector('input[type="checkbox"]');

            // Load saved email if it's in the localStorage
            if (localStorage.getItem('rememberMe') === 'true') {
                txtEmail.value = localStorage.getItem('email');
                rememberMeCheckbox.checked = true;
            }

            loginForm.addEventListener('submit', function(event) {
                if (rememberMeCheckbox.checked) {
                    localStorage.setItem('email', txtEmail.value);
                    localStorage.setItem('rememberMe', 'true');
                } else {
                    localStorage.removeItem('email');
                    localStorage.removeItem('rememberMe');
                }
            });
        });
    </script>

    <footer>
        <p>&copy;Ewan MacKerracher : 2024 SongShack</p>
    </footer>
</body>

</html>
