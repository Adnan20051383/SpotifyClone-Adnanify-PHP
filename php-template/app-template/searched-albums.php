<?php include './layout/header.php' ?>
<?php
if (isset($_GET['keyword'])) {
    $albums = $mainConnection->prepare("SELECT * FROM albums WHERE title like :keyword");
    $keyword = $_GET['keyword'];
    $albums->execute(['keyword' => "%$keyword%"]);
}

?>



<div class="container">
    <div class="row title-header">
        <h1 class="title-header-name">
                Albums Found with [<?= $_GET['keyword'] ?>]
        </h1>
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




<?php include './layout/current_music.php' ?>

<?php include './layout/footer.php' ?>