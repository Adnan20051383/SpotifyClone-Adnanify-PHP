<?php include './layout/header.php' ?>
<?php include './layout/session_song_unset.php' ?>
<?php

    if (isset($_GET['artist_id'])) {
        $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $_GET[artist_id]")->fetch();
        $artist_songs = $mainConnection->query("SELECT * FROM musics WHERE artist_id = $_GET[artist_id] ORDER BY likes_num DESC LIMIT 5");
        $artist_albums = $mainConnection->query("SELECT * FROM albums WHERE artist_id = $_GET[artist_id] ORDER BY `date` DESC");
        $_SESSION['artist'] = $artist['id'];
    }

?>

    <header class="artist-header">
        <img src="./assets/img/<?= $artist['image'] ?>" alt="Artist Image" class="artist-image">
        <h1><?= $artist['name'] ?></h1>
    </header>

    <!-- Artist Bio Section -->
    <div class="container">
        <div class="artist-bio text-center mt-4">
            <h2>About the Artist</h2>
            <p>
                <?= $artist['about'] ?>
            </p>
        </div>

        <!-- Popular Tracks Section -->
        <div class="track-list">
            <h3 class="text-center mt-5 mb-4">Popular Tracks</h3>
            <?php foreach($artist_songs as $song): ?>
                <?php if (isset($_SESSION['logged_in_user'])) {$like_status = $mainConnection->query("SELECT * FROM music_likes WHERE music_id = $song[id] AND user_id = $user[id]")->rowCount();}  ?>
            <div class="track-item">
                <div style="display: flex; justify-content:center; align-items: center">
                    <img src="./assets/img/<?= $song['cover'] ?>" alt="Track">
                    <h5><?= $song['title'] ?></h5>
                </div>
                <div>
                    <span onclick="playMusic(<?= $song['id'] ?>)" class="play-button-track-item">&#9654;</span>
                    <button onclick="likeMusic(<?= $song['id'] ?>)" class="btn"><i class="bi <?= $like_status == 1 ? 'bi-heart-fill' : 'bi-heart' ?>"></i></button>

                </div>
            </div>
            <?php endforeach ?>
            <!-- Add more tracks as needed -->
        </div>
        <div class="row title-header">
        <h1 class="title-header-name">
                Albums
        </h1>
    </div>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php foreach($artist_albums as $album): ?>
            <?php $artist =  $mainConnection->query("SELECT * FROM artists WHERE id = $album[artist_id]")->fetch(); ?>
            <div class="col mb-4">
                <div class="album-card">
                    <a href="./album-detail.php?album_id=<?= $album['id'] ?>" class="album-link text-decoration-none">
                        <div class="album-image-container">
                            <img src="./assets/img/<?= $album['cover'] ?>" alt="Album Cover" class="album-image">
                        </div>
                        <div class="album-info mt-3">
                            <div class="album-title"><?= $album['title'] ?></div>
                            <div class="artist-name"><?= $artist['name'] ?></div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    </div>
    <?php include './layout/current_music.php' ?>
    <?php include './layout/footer.php' ?>