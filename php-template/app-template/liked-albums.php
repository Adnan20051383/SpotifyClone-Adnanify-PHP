<?php include './layout/header.php' ?>
<?php

    if (isset($_GET['user_id'])) {
        if ($user['id'] != $_GET['user_id']) {
            header("Location:./index.php");
            exit();
        }
        $albums = $mainConnection->query("SELECT * FROM album_likes WHERE user_id = $_GET[user_id]");
    }

?>



<div class="container">
    <div class="row title-header">
        <h1 class="title-header-name">
                Liked Albums
        </h1>
    </div>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php foreach($albums as $album): ?>
            <?php $album1 = $mainConnection->query("SELECT *FROM albums WHERE id = $album[album_id]")->fetch(); ?>
            <?php $artist =  $mainConnection->query("SELECT * FROM artists WHERE id = $album1[artist_id]")->fetch(); ?>
            <div class="col mb-4">
                <div class="album-card">
                    <a href="./album-detail.php?album_id=<?= $album1['id'] ?>" class="album-link text-decoration-none">
                        <div class="album-image-container">
                            <img src="./assets/img/<?= $album1['cover'] ?>" alt="Album Cover" class="album-image">
                        </div>
                        <div class="album-info mt-3">
                            <div class="album-title"><?= $album1['title'] ?></div>
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