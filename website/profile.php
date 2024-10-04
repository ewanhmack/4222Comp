<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css Files/dropdown.css"> 
    <link rel="stylesheet" href="css Files/Main.css"> 
    <link rel="stylesheet" href="css Files/Nav.css">
    <link rel="stylesheet" href="css Files/profile.css">          
    <link rel="stylesheet" href="css Files/dynamicsize.css">
    <link rel="icon" type="image/png" href="Images/SongShackIcon.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="userProfileLoader.js"></script>  
    <script src="hideData.js"></script>
    <script src="logout.js"></script>
    <script src="favAlbum.js"></script>
    <title>Profile Page</title>

</head>
<body>
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

    <main>
        <br>
        <section id="about">
            <h2>User Details</h2>
            <p>Your account details:</p>
            <div id="userDetails" class="userData">
                <!-- User details will be toggled here -->
            </div>
            <button id="editDetails" type="button">Edit Details</button>
            <div id="editDetailsForm" style="display: none;">
                <form id="userDetailsForm">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Enter new first name">
                    
                    <label for="surname">Surname:</label>
                    <input type="text" id="surname" name="surname" placeholder="Enter new surname">
                    
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter new username">

                    <label for="password">Password:</label>
                    <input type="text" id="password" name="password" placeholder="Enter new password">
                    <button id="submitNewDetails" type="button">Submit</button>
                </form>
            </div>

            <h3>Favourite Album:</h3>
            <select id="albumSelect"></select>
            <button id="favouriteAlbumButton" type="button">Set as Favourite Album</button>

        </section>
        <button id="logout" type="button" class="btn" onclick="logout()">Log Out</button>
        <br><br><br>
    </main>

    <footer>
        <p>&copy; Ewan MacKerracher : 2024 SongShack</p>
    </footer>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('JSON Files/Albums.json')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('albumSelect');
                data.forEach(album => {
                    const option = document.createElement('option');
                    option.value = album.id;
                    option.text = `${album.title} by ${album.artist}`;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading the albums:', error));
    });
    document.getElementById('editDetails').addEventListener('click', function() {
        const userEmail = localStorage.getItem('userEmail');
        fetch(`getUserData.php?email=${encodeURIComponent(userEmail)}`)
        .then(response => response.json())
        .then(userData => {
            document.getElementById('editDetailsForm').style.display = 'block';
            if(userData) {
                document.getElementById('firstName').value = userData.FirstName;
                document.getElementById('surname').value = userData.Surname;
                document.getElementById('username').value = userData.username;
                document.getElementById('password').value = userData.password;
            }
        })
        .catch(error => console.error('Error fetching user data:', error));
    });

    document.getElementById('submitNewDetails').addEventListener('click', function(event) {
        event.preventDefault();
        const userEmail = localStorage.getItem('userEmail');
        const newUserData = {
            email: userEmail,
            FirstName: document.getElementById('firstName').value,
            Surname: document.getElementById('surname').value,
            username: document.getElementById('username').value,
            password: document.getElementById('password').value,
        };

        fetch('updateUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(newUserData),
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                console.log('Success:', data);
                window.location.reload(); // Refresh the page to reflect changes
            } else {
                console.error('Error updating user data:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
</html>
