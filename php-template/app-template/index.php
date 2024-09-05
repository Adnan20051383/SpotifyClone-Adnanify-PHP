<?php include './layout/header.php' ?>
<?php

$new_songs = $mainConnection->query("SELECT * FROM musics ORDER BY `date` DESC LIMIT 4");
$popular_songs = $mainConnection->query("SELECT * FROM musics ORDER BY likes_num DESC LIMIT 4");
if (isset($_SESSION['logged_in_user'])) {
    $stmt = $mainConnection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $_SESSION['logged_in_user']]);
    $user = $stmt->fetch();
}


?>

<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Welcome to Adnanify</h1>
        <p>Stream and download your favorite music</p>
    </div>
</div>

<!-- Music Library -->
<div class="container mt-4">
    <div class="row title-header">
        <h1>
            New Songs
        </h1>
        <a href="./musics.php">
            <h3>
                see more
            </h3>
        </a>
    </div>
    <div class="row">
        <?php foreach($new_songs as $new_song): ?>
            <?php $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $new_song[artist_id]")->fetch(); ?>
            <?php if (isset($_SESSION['logged_in_user'])) {$like_status = $mainConnection->query("SELECT * FROM music_likes WHERE music_id = $new_song[id] AND user_id = $user[id]")->rowCount();}  ?>
        <div class="col-md-3 mb-4">
            <div class="card music-card">
                <img src="./assets/img/<?= $new_song['cover'] ?>" class="card-img-top" alt="Music Image">
                <div class="music-card-body">
                    <h5 class="card-title"><?= $new_song['title'] ?></h5>
                    <a href="./about-artist.php?artist_id=<?= $artist['id'] ?>" class="card-text artist-name"><?= $artist['name'] ?></a>
                    <button onclick="playMusic(<?= $new_song['id'] ?>)" class="btn"><i class="bi bi-play-circle"></i><p style="visibility: hidden">1</p></button>
                    <button onclick="likeMusic(<?= $new_song['id'] ?>)" class="btn"><i class="bi <?= $like_status == 1 ? 'bi-heart-fill' : 'bi-heart' ?>"></i><p><?= $new_song['likes_num'] ?></p></button>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div> 
</div>


<div class="container mt-4">
        <div class="row title-header">
            <h1>
                Popular Songs
            </h1>
            <a href="./musics.php">
                <h3>
                    see more
                </h3>
            </a>
        </div>
        <div class="row">
        <?php foreach($popular_songs as $popular_song): ?>
            <?php $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $popular_song[artist_id]")->fetch(); ?>
            <?php if (isset($_SESSION['logged_in_user'])) {$like_status = $mainConnection->query("SELECT * FROM music_likes WHERE music_id = $popular_song[id] AND user_id = $user[id]")->rowCount();}  ?>
        <div class="col-md-3 mb-4">
            <div class="card music-card">
                <img src="./assets/img/<?= $popular_song['cover'] ?>" class="card-img-top" alt="Music Image">
                <div class="music-card-body">
                    <h5 class="card-title"><?= $popular_song['title'] ?></h5>
                    <a href="./about-artist.php?artist_id=<?= $artist['id'] ?>" class="card-text artist-name"><?= $artist['name'] ?></a>
                    <button onclick="playMusic(<?= $popular_song['id'] ?>)" class="btn"><i class="bi bi-play-circle"></i><p style="visibility: hidden">1</p></button>
                    <button onclick="likeMusic(<?= $popular_song['id'] ?>)" class="btn"><i class="bi <?= $like_status == 1 ? 'bi-heart-fill' : 'bi-heart' ?>"></i><p><?= $popular_song['likes_num'] ?></p></button>
                </div>
            </div>
        </div>
        <?php endforeach ?>
        </div> 
</div>
<?php include './layout/current_music.php' ?>
<?php include './layout/footer.php' ?>