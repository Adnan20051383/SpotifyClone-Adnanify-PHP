<?php include './layout/header.php'; ?>
<?php include './layout/session_song_unset.php' ?>
<?php
    $songs = $mainConnection->query("SELECT * FROM musics ORDER BY `date` DESC");
    $_SESSION['musics'] = 'yes';
    if (isset($_SESSION['logged_in_user'])) {
        $stmt = $mainConnection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $_SESSION['logged_in_user']]);
        $user = $stmt->fetch();
    }
?>


<!-- Music Library -->
<div class="container mt-4">
    <?php include './layout/genre.php' ?>
    <div class="row title-header">
        <h1 class="title-header-name">
            Musics
        </h1>
    </div>
    <div class="row">
        <?php foreach($songs as $song) : ?>
            <?php if(!isset($_GET['genre_id']) || $song['genre_id'] == $_GET['genre_id']):  ?>   
                <?php $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $song[artist_id]")->fetch()  ?>
                <?php
                if (isset($_GET['genre_id']))
                $_SESSION['genre_id'] = $_GET['genre_id'];
            ?>
            <?php if (isset($_SESSION['logged_in_user'])) {$like_status = $mainConnection->query("SELECT * FROM music_likes WHERE music_id = $song[id] AND user_id = $user[id]")->rowCount();}  ?>    

        <div  class="col-md-3 mb-4">
            <div class="card music-card">
                <img src="./assets/img/<?= $song['cover'] ?>" class="card-img-top" alt="Music Image">
                <div class="music-card-body">
                    <h5 class="card-title"><?= $song['title'] ?></h5>
                    <a href="./about-artist.php?artist_id=<?= $artist['id'] ?>" class=" artist-name card-text"><?= $artist['name'] ?></a>
                    <button onclick="playMusic(<?= $song['id'] ?>)" class="btn"><i class="bi bi-play-circle"><p style="visibility: hidden;">1</p></i></button>
                    <button onclick="likeMusic(<?= $song['id'] ?>)" class="btn"><i class="bi <?= $like_status == 1 ? 'bi-heart-fill' : 'bi-heart' ?>"></i><p><?= $song['likes_num'] ?></p></button>
                </div>
            </div>
        </div>
        <?php endif ?>
        <?php endforeach ?>
    </div> 
</div>
<?php include './layout/current_music.php' ?>

<?php include './layout/footer.php' ?>