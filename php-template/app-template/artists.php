<?php include './layout/header.php' ?>
<?php  


    $artists = $mainConnection->query("SELECT * FROM artists");

?>
<div class="container mt-4">
    <div class="row title-header">
        <h1 class="title-header-name">
                Artists
        </h1>
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

<?php include './layout/footer.php' ?>