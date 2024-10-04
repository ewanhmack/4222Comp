<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css Files/dropdown.css">
    <link rel="stylesheet" href="css Files/index.css"> 
    <link rel="stylesheet" href="css Files/Main.css"> 
    <link rel="stylesheet" href="css Files/Nav.css"> 
    <link rel="stylesheet" href="css Files/reviews.css">
    <link rel="stylesheet" href="css Files/dynamicsize.css">
    <link rel="icon" type="image/png" href="Images/SongShackIcon.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="userProfileLoader.js"></script>
    <script src="hideData.js"></script>
        <title>Error</title>
    <style>
    th {
        padding: 10px; 
    }
    
    table {
        border-collapse: separate;
        border-spacing: 10px; 
    }
</style>
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
        <section id='individualDetails'>
            <div class='individualDetails'>
                <h1>Oops, that didn't go too well...</h1>
            </div>
        </section>
    </main>
    
    <footer>
        <p>&copy;Ewan MacKerracher : 2024 SongShack</p>
    </footer>
</body>
</html>
