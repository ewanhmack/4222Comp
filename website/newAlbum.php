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
    <link rel="stylesheet" href="css Files/newAlbum.css">
    <link rel="icon" type="image/png" href="Images/SongShackIcon.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="userProfileLoader.js"></script>
    <script src="hideData.js"></script>
    <script src="reviewSystem.js"></script>
    <title>Add new Album</title>
</head>

<body>
    <header>
        <a href="index.php">
            <img src="Images/SongShack.png" alt="Logo" id="logo">
        </a>  
        <span id="usernameDisplay"></span>
        <div class="dropdown">
            <button class="dropbtn"><ion-icon name="reorder-two-outline" id="menuIcon"></ion-icon></button>
            <div class="dropdown-content">
                <a href="index.php">Home Page</a>
                <a href="ranking.php">Ranking Page</a>
                <a href="login.php" id="loginLink">Login</a>
                <a href="profile.php" id="profileLink">Profile Page</a>
            </div>
        </div>
    </header>

    <div class="wrapper">
        <?php
            $albumAdded = false;
            $message = ''; // Initialize message as empty

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $allChecksPassed = true;
            
                // Ensure there is at least one song
                if (empty($_POST['songs']) || count($_POST['songs']) == 0) {
                    $allChecksPassed = false;
                    $message = "<p class='error-message'>Please add at least one song to the album.</p>";
                }
            }
            
            // Always show the message if set
            echo $message;
            
            // Only show the form if the album wasn't successfully added
            if (!$albumAdded) {
        ?>

                <h1>Add New Album</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="cover_photo">Cover Photo:</label>
                    <input type="file" id="cover_photo" name="cover_photo" required><br><br>

                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required><br><br>

                    <label for="artist">Artist:</label>
                    <input type="text" id="artist" name="artist" required><br><br>

                    <label for="genre">Genre:</label>
                    <input type="text" id="genre" name="genre" required><br><br>

                    <label for="release_year">Release Year:</label>
                    <input type="number" id="release_year" name="release_year" required><br><br>

                    <label for="producer">Producer:</label>
                    <input type="text" id="producer" name="producer" required><br><br>

                    <label for="totalTime">Total Time:</label>
                    <input type="text" id="totalTime" name="totalTime" required><br><br>

                    <label for="recommendation_score">Recommendation Score:</label>
                    <input type="number" id="recommendation_score" name="recommendation_score" step="0.1" required><br><br>

                    <label for="recommendation_description">Recommendation Description:</label><br>
                    <textarea id="recommendation_description" name="recommendation_description" rows="4" cols="50" required></textarea><br><br>


                    <h3>Songs</h3>
                    <div id="songs_container">
                        <!-- Song inputs will be added dynamically here -->
                    </div>
                    <button type="button" onclick="addSong()">Add Song</button>
                    <button type="button" onclick="removeSong()" id="remove_song">Remove Song</button><br><br>

                    <input type="submit" value="Submit">
                </form>
                <?php
        }
        ?>

    </div>
        <?php
            $albumAdded = false;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $albumsFile = "JSON Files/albums.json";
                $message = '';
                // Read existing albums data
                $albumsData = json_decode(file_exists($albumsFile) ? file_get_contents($albumsFile) : '[]', true);

                // Handle the uploaded cover photo
                $coverPhoto = $_FILES["cover_photo"];
                $coverPhotoPath = "";
                if ($coverPhoto && $coverPhoto["error"] == 0) {
                    $targetDirectory = "Images/";
                    $targetFile = $targetDirectory . basename($coverPhoto["name"]);
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    // Check if file is an actual image or fake image
                    $check = getimagesize($coverPhoto["tmp_name"]);
                    if ($check !== false) {
                        // Check if file already exists
                        if (!file_exists($targetFile)) {
                            // Check file size
                            if ($coverPhoto["size"] <= 5000000) { // 5000KB, can be adjusted
                                // Allow certain file formats
                                if (in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                                    if (move_uploaded_file($coverPhoto["tmp_name"], $targetFile)) {
                                        $coverPhotoPath = $targetFile;
                                    } else {
                                        $message = "Sorry, there was an error uploading your file.";
                                    }
                                } else {
                                    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                }
                            } else {
                                $message = "Sorry, your file is too large.";
                            }
                        } else {
                            $message = "Sorry, file already exists.";
                        }
                    } else {
                        $message = "File is not an image.";
                    }
                }

                // Create new album object with the uploaded cover photo path
                $newAlbum = [
                    "id" => count($albumsData) + 1,
                    "Cover Photo" => $coverPhotoPath, // Use the uploaded cover photo path
                    "title" => $_POST["title"],
                    "artist" => $_POST["artist"],
                    "genre" => $_POST["genre"],
                    "songs" => [],
                    "totalTime" => $_POST["totalTime"],
                    "releaseYear" => $_POST["release_year"],
                    "producer" => $_POST["producer"],
                    "recommendationScore" => floatval($_POST["recommendation_score"]),
                    "recommendationDescription" => $_POST["recommendation_description"],
                    "albumLocation" => "Albums.php?key=" . (count($albumsData) + 1)
                ];

                // Add songs to the album
                foreach ($_POST['songs'] as $track => $songData) {
                    $newAlbum["songs"][] = [
                        "track" => $track,
                        "title" => $songData['title'],
                        "runtime" => $songData['runtime']
                    ];
                }

                // Add new album to albums data
                $albumsData[] = $newAlbum;

                // Save updated albums data to JSON file
                file_put_contents($albumsFile, json_encode($albumsData, JSON_PRETTY_PRINT));

                if ($allChecksPassed) { // Replace this with your actual condition for successful addition
                    $albumAdded = true;
                    $message = "<p class='success-message'>New album added successfully!</p>";
                } else {
                    $message = "<p class='error-message'>There was an error adding the album.</p>";
                }
            }
        ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let songCount = 0;

            window.addSong = function() {
                const container = document.getElementById("songs_container");
                const div = document.createElement("div");
                div.setAttribute('id', 'song_' + songCount);
                div.innerHTML = `
                    <h4>Song ${songCount+1}</h4>
                    <label for="songs_${songCount}_track">Track Number:</label>
                    <input type="number" id="songs_${songCount}_track" name="songs[${songCount}][track]" value="${songCount+1}" required><br><br>

                    <label for="songs_${songCount}_title">Title:</label>
                    <input type="text" id="songs_${songCount}_title" name="songs[${songCount}][title]" required><br><br>

                    <label for="songs_${songCount}_runtime">Runtime:</label>
                    <input type="text" id="songs_${songCount}_runtime" name="songs[${songCount}][runtime]" required><br><br>
                `;
                container.appendChild(div);
                songCount++;
            };

            window.removeSong = function() {
                if (songCount > 1) {
                    songCount--;
                    const songDiv = document.getElementById('song_' + songCount);
                    songDiv.parentNode.removeChild(songDiv);
                }
            };

            // Initialize with one song input
            addSong();
        });

        function removeSong() {
            if (songCount > 1) {
                songCount--;
                const songDiv = document.getElementById('song_' + songCount);
                songDiv.parentNode.removeChild(songDiv);
            }
        }
    </script>
</body>
</html>
