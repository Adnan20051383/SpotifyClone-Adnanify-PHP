<?php include './layout/header.php' ?>
<?php include './layout/session_song_unset.php' ?>
<?php

    if ($_GET['album_id']) {
        $album = $mainConnection->query("SELECT * FROM albums WHERE id = $_GET[album_id]")->fetch();
        $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $album[artist_id]")->fetch();
        $songs = $mainConnection->query("SELECT * FROM musics WHERE album_id = $_GET[album_id]");
        $likes = $mainConnection->query("SELECT * FROM album_likes WHERE album_id = $_GET[album_id]")->rowCount();
        if (isset($_SESSION['logged_in_user'])) {
            $stmt = $mainConnection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $_SESSION['logged_in_user']]);
            $user = $stmt->fetch();
            $like_status = $mainConnection->query("SELECT * FROM album_likes WHERE album_id = $_GET[album_id] AND user_id = $user[id]")->rowCount();
        }
        $_SESSION['album'] = $album['id'];
    }
    
?>
    
    <!-- Album Container -->
    <div class="album-container">
        <!-- Album Header -->
        <div class="album-header">
            <img src="./assets/img/<?= $album['cover'] ?>" alt="Album Cover" class="album-cover">
            <div class="album-info">
                <h1 class="album-title"><?= $album['title'] ?></h1>
                <a href="./about-artist.php?artist_id=<?= $artist['id'] ?>" class="artist-name"><?= $artist['name'] ?></a>
            </div>
            <div class="like-button">
                <i onclick="likeAlbum(<?= $album['id'] ?>)" class="bi <?= $like_status == 0 ? 'bi-heart' : 'bi-heart-fill text-success' ?>"></i>
                <p><?= $likes ?></p>
            </div>
        </div>

        <!-- Tracklist -->
        <ul class="tracklist">
            <?php foreach($songs as $song): ?>
                <?php if (isset($_SESSION['logged_in_user'])) {$like_status = $mainConnection->query("SELECT * FROM music_likes WHERE music_id = $song[id] AND user_id = $user[id]")->rowCount();}  ?>
            <li class="track-item">
                <div>
                    <span onclick="playMusic(<?= $song['id'] ?>)" class="track-title"><?= $song['title'] ?></span>
                </div>
                <div>
                    <span class="track-duration"><?= formatDuration(getAudioDuration("../songs/$song[url]")) ?></span>
                    <button onclick="likeMusic(<?= $song['id'] ?>)" class="btn"><i class="bi <?= $like_status == 1 ? 'bi-heart-fill' : 'bi-heart' ?>"></i></button>
                </div>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php include './layout/current_music.php' ?>
    <?php include './layout/footer.php' ?>