<?php include './layout/header.php'; ?>
<?php

if (isset($_GET['keyword'])) {
    $searched_songs = $mainConnection->prepare("SELECT * FROM musics WHERE title LIKE :keyword LIMIT 4");
    $searched_songs->execute(['keyword' => "%$_GET[keyword]%"]);
    $albums = $mainConnection->prepare("SELECT * FROM albums WHERE title LIKE :keyword LIMIT 4");
    $albums->execute(['keyword' => "%$_GET[keyword]%"]);
    $artists = $mainConnection->prepare("SELECT * FROM artists WHERE name LIKE :keyword LIMIT 6");
    $artists->execute(['keyword' => "%$_GET[keyword]%"]);
}

?>

<div class="container mt-4">
    <div class="row title-header">
        <h1>
            Songs Found with [<?= $_GET['keyword'] ?>]
        </h1>
        <a href="./searched-musics.php?keyword=<?= $_GET['keyword'] ?>">
            <h3>
                see more
            </h3>
        </a>
    </div>
    <div class="row">
        <?php foreach($searched_songs as $new_song): ?>
            <?php $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $new_song[artist_id]")->fetch(); ?>
            <?php if (isset($_SESSION['logged_in_user'])) {$like_status = $mainConnection->query("SELECT * FROM music_likes WHERE music_id = $new_song[id] AND user_id = $user[id]")->rowCount();}  ?>
        <div class="col-md-3 mb-4">
            <div class="card music-card">
                <img src="./assets/img/<?= $new_song['cover'] ?>" class="card-img-top" alt="Music Image">
                <div class="music-card-body">
                    <h5 class="card-title"><?= $new_song['title'] ?></h5>
                    <p class="card-text"><?= $artist['name'] ?></p>
                    <button onclick="playMusic(<?= $new_song['id'] ?>)" class="btn"><i class="bi bi-play-circle"></i><p style="visibility: hidden">1</p></button>
                    <button onclick="likeMusic(<?= $new_song['id'] ?>)" class="btn"><i class="bi <?= $like_status == 1 ? 'bi-heart-fill' : 'bi-heart' ?>"></i><p><?= $new_song['likes_num'] ?></p></button>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div> 
</div>

<div class="container mt4">
<div class="row title-header">
        <h1 class="title-header-name">
                Albums Found with [<?= $_GET['keyword'] ?>]
        </h1>
        <a href="./searched-albums.php?keyword=<?= $_GET['keyword'] ?>">
            <h3>
                see more
            </h3>
        </a>
    </div>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php foreach($albums as $album): ?>
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


<div class="container mt-4">
    <div class="row title-header">
        <h1 class="title-header-name">
                Artists Found wit [<?= $_GET['keyword'] ?>]
        </h1>
        <a href="./searched-artists.php?keyword=<?= $_GET['keyword'] ?>">
            <h3>
                see more
            </h3>
        </a>

    </div>
    <div class="row">
        <?php foreach($artists as $artist) :  ?>
        <!------ ARTIST CARD  ----->
        <div class="col-md-2 mb-4">
            <a href="./about-artist.php?artist_id=<?= $artist['id'] ?>" class="artist-card text-decoration-none">
                    <div class="artist-image-container">
                    <img src="./assets/img/<?= $artist['image'] ?>" alt="Artist Image" class="artist-image">
                    </div>
                    <div class="artist-name mt-3"><?= $artist['name'] ?></div>
            </a>
        </div>
        <!------ ARTIST CARD  ----->
        <?php endforeach ?>
    </div>
</div>

<?php include './layout/current_music.php' ?>
<?php include './layout/footer.php'; ?>