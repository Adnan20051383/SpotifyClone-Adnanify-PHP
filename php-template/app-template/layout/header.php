<?php session_start(); ?>
<?php include './dataBase/db.php' ?>
<?php
require_once('./layout/getId/getid3/getid3.php'); 

function getAudioDuration($filePath) {
    $getID3 = new getID3;
    $fileInfo = $getID3->analyze($filePath);

    if (isset($fileInfo['playtime_seconds'])) {
        return $fileInfo['playtime_seconds'];
    } else {
        return false; 
    }
}
function formatDuration($seconds) {
    $minutes = floor($seconds / 60); 
    $remainingSeconds = $seconds % 60; 
    return sprintf("%02d:%02d", $minutes, $remainingSeconds);
}
function indexOfCurrentMusic($songs_session, $song) {
    $i = 0;
    $currentIndex = -1;
    foreach($songs_session as $song_session) {
        if ($song_session['id'] === $song['id']) {
            $currentIndex = $i;
            break;
        }
        $i++;
    }
    return $currentIndex < 0 ? 0 : $currentIndex;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adnanify</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<div class="profile-view-container">
    <?php if (isset($_SESSION['logged_in_user'])): ?>
    <?php
    $stmt = $mainConnection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $_SESSION['logged_in_user']]);
    $user = $stmt->fetch();
    $profile = $mainConnection->query("SELECT * FROM profiles WHERE user_id = $user[id]")->fetch();
    ?>    
    <img onerror="this.onerror=null; this.src='./assets/img/download.png';" style="cursor: pointer;" onclick="goToProfile(<?= $user['id'] ?>)" src="./assets/img/<?= $profile['image'] ?>" alt="profile icon">
    <p style="cursor: pointer;" onclick="goToProfile(<?= $user['id'] ?>)"><?= $user['name'] ?></p>
    <?php else: ?>
        <a href="./signin.php" class="btn btn-outline-success">Sign In</a>
    <?php endif ?>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="./index.php">Adnanify</a>
        <form class="form-inline mx-auto">
            <input id="search_bar" class="form-control" type="search" placeholder="Search for songs, artists, albums..." aria-label="Search">
        </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="<?= str_contains($_SERVER['REQUEST_URI'], 'index') ? 'nav-link-active' : 'nav-link' ?>" href="./index.php"><i class="bi bi-house-door"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="<?= str_contains($_SERVER['REQUEST_URI'], 'music') ? 'nav-link-active' : 'nav-link' ?>" href="./musics.php"><i class="bi bi-music-note"></i>Music</a>
                </li>
                <li class="nav-item">
                    <a class="<?= str_contains($_SERVER['REQUEST_URI'], 'artists') ? 'nav-link-active' : 'nav-link' ?>" href="./artists.php"><i class="bi bi-person"></i>Artists</a>
                </li>
                <li class="nav-item">
                    <a class="<?= str_contains($_SERVER['REQUEST_URI'], 'album') ? 'nav-link-active' : 'nav-link' ?>" href="./albums.php"><i class="bi bi-file-earmark-music"></i>Albums</a>
                </li>
            </ul>
        </div>
    </div>
</nav>