<?php include './layout/header.php' ?>
<?php include './layout/session_song_unset.php' ?>
<?php
    if ($user['id'] != $_GET['user_id']) {
        header("Location:./index.php");
        exit();
    }
    if (isset($_GET['user_id'])) {
        $liked_songs = $mainConnection->query("SELECT * FROM music_likes WHERE user_id = $user[id] ORDER BY id DESC")->fetchAll();
        $_SESSION['liked_musics'] = $user['id'];
    }

?>

<div class="track-list">
            <h3 class="text-center mt-5 mb-4">Liked Tracks</h3>
            <?php foreach($liked_songs as $liked_song): ?>
                <?php $song = $mainConnection->query("SELECT * FROM musics WHERE id = $liked_song[music_id]")->fetch(); ?>
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
        </div>
        <?php include './layout/current_music.php' ?>
<?php include './layout/footer.php' ?>