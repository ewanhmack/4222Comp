<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css Files/dropdown.css">
    <link rel="stylesheet" href="css Files/tables.css">  
    <link rel="stylesheet" href="css Files/Main.css"> 
    <link rel="stylesheet" href="css Files/Nav.css">
    <link rel="stylesheet" href="css Files/ranking.css">
    <link rel="stylesheet" href="css Files/dynamicsize.css">
    <link rel="icon" type="image/png" href="Images/SongShackIcon.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="userProfileLoader.js"></script>
    <script src="hideData.js"></script>
    <title>Rankings</title>
    <style>
        .albumCard{
            margin-top: 60px;
        }
        .songsTable{
            margin-top: 60px;
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
        </br></br></br></br></br>
        <section id="RankedAlbums">
            <?php
                $albumsJson = file_get_contents('JSON Files/Albums.json');
                $reviewsJson = file_get_contents('JSON Files/reviews.json');
                $albums = json_decode($albumsJson, true);
                $reviews = json_decode($reviewsJson, true);

                // Calculate average ratings
                $albumRatings = [];
                foreach ($reviews as $albumKey => $albumReviews) {
                    $totalRating = 0;
                    foreach ($albumReviews as $review) {
                        $totalRating += (int)$review['rating'];
                    }
                    $averageRating = count($albumReviews) > 0 ? $totalRating / count($albumReviews) : 0;
                    $albumRatings[$albumKey] = $averageRating;
                }

                // Sort albums by average rating
                uasort($albums, function ($a, $b) use ($albumRatings) {
                    $ratingA = $albumRatings[$a['id']] ?? 0;
                    $ratingB = $albumRatings[$b['id']] ?? 0;
                    return $ratingB <=> $ratingA;
                });

                // Display ranked albums with songs
                $rank = 1; // Initialize counter for ranking
                foreach ($albums as $album) {
                    echo '<div class="album-container">';
                    echo '<div class="albumCard">';
                    echo '<span class="rank">' . $rank . '. </span>'; // Display the rank
                    echo '<img src="' . htmlspecialchars($album['Cover Photo']) . '" alt="Album Cover">';
                    echo '<h3>' . htmlspecialchars($album['title']) . '</h3>';
                    echo '<p>Artist: ' . htmlspecialchars($album['artist']) . '</p>';
                    echo '<p>Average Rating: ' . sprintf('%.1f', $albumRatings[$album['id']] ?? "Not Rated") . '</p>';
                    echo '<a href="Albums.php?key=' . htmlspecialchars($album['id']) . '">View Details</a>';
                    echo '</div>';

                    // Include song table for each album
                    echo '<div class="songsTable">';
                    echo '<table>';
                    echo '<thead><tr><th>#</th><th>Title</th><th>Run Time</th></tr></thead>';
                    echo '<tbody>';
                    foreach ($album['songs'] as $song) {
                        echo '<tr><td>' . htmlspecialchars($song['track']) . '</td><td>' . htmlspecialchars($song['title']) . '</td><td>' . htmlspecialchars($song['runtime']) . '</td></tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>'; // Close songsTable

                    echo '</div>'; // Close album-container
                    $rank++; // Increment the rank
                }
            ?>
        </section>
        </br>
        </br>
    </main>

<footer>
    <p>&copy; Ewan MacKerracher : 2024 SongShack</p>
</footer>
</body>
</html>
