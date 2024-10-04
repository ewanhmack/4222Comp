<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css Files/dropdown.css">
    <link rel="stylesheet" href="css Files/index.css"> 
    <link rel="stylesheet" href="css Files/Main.css"> 
    <link rel="stylesheet" href="css Files/Nav.css"> 
    <link rel="stylesheet" href="css Files/tables.css">
    <link rel="stylesheet" href="css Files/chatroom.css">
    <link rel="stylesheet" href="css Files/login.css">
    <link rel="stylesheet" href="css Files/dynamicsize.css">
    <link rel="icon" type="image/png" href="Images/SongShackIcon.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="userProfileLoader.js"></script>
    <script src="hideData.js"></script>
    <script src="burgerMenu.js"></script>
    <title>Home Page</title>
    <style>
        .container {
          display: grid;
          flex-direction: column;
          gap: 5px; 
        }
    </style>
      
</head>
<body>
    <header>
        <a href="index.php">
            <img src="Images/SongShack.png" alt="Logo" id="logo">
        </a>  
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
        </br></br></br></br></br></br></br></br>

    <div class="container">
        </br>
        <section id="about">
            <h2>About SongShack</h2>
            <p>SongShack: Your go-to destination to rate, discuss, and discover albums, connecting musicians and listeners worldwide!</p>
        </section>
        </br>
        <h2>Featured Albums</h2>
        <?php
        // Load the albums JSON file
        $albumsJson = file_get_contents('JSON Files/Albums.JSON'); 
        // Decode the JSON into an associative array
        $albums = json_decode($albumsJson, true);

        // Check if albums are loaded
        if (!empty($albums)) {
            echo "<div class='albumsContainer'>"; 
            foreach ($albums as $album) {
                
                echo "<section class='albumDetails' id='album{$album['id']}'>
                        <img src='{$album['Cover Photo']}' alt='Album Cover'>
                        <div><h3>{$album['title']}</h3></div>
                        <div><p>Artist: {$album['artist']}</p></div>
                        <a href='{$album['albumLocation']}'>View Details</a>
                    </section>";
            }
            
            echo "</div>"; 
        } else {
            echo "<p>No albums found.</p>";
        }
        ?>
    </div>
    </br>
    </br></br></br></br></br></br></br></br></br>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchUserData(localStorage.getItem('userEmail'));
        });

        async function fetchUserData(email) {
            const response = await fetch('getUserData.php?email=' + email);
            const data = await response.json();
            if (data && data.favouriteAlbumId) {
                localStorage.setItem('favouriteAlbumId', data.favouriteAlbumId);
                addFavoriteStar(data.favouriteAlbumId);
            }
        }

        function addFavoriteStar(albumId) {
            const favAlbumElement = document.getElementById('album' + albumId);
            if (favAlbumElement) {
                const starElement = document.createElement('span');
                starElement.classList.add('favorite-star');
                starElement.innerHTML = '★';
                favAlbumElement.prepend(starElement); 
            }
        }

    </script>


</main>
            
<footer>
    <p>&copy; Ewan MacKerracher : 2024 SongShack</p>
</footer>    
</body>
</html>
