<?php include './layout/header.php' ?>
<?php include './layout/session_musics.php' ?>

<?php
    if (isset($_GET['song_id'])) {
        $song = $mainConnection->query("SELECT * FROM musics WHERE id = $_GET[song_id]")->fetch();
        $artist = $mainConnection->query("SELECT * FROM artists WHERE id = $song[artist_id]")->fetch();
    }
    $index = indexOfCurrentMusic($songs_session, $song);

?>




<div style="background: url('./assets/img/<?= $song['cover'] ?>') no-repeat center; background-size: cover;" class="song-container">
 
        <!-- Song Title and Artist Name -->
        <h2 class="song-title"><?= $song['title'] ?></h2>
        <a href="./about-artist.php?artist_id=<?= $artist['id'] ?>" class="artist-name"><?= $artist['name'] ?></a>

        <!-- Controls -->
        <div class="controls">
            <a onclick="goToSong(<?= $index === 0 ?  $songs_session[$index]['id'] : $songs_session[$index - 1]['id'] ?>)" href="./music-detail.php?song_id=<?= $index === 0 ?  $songs_session[$index]['id'] : $songs_session[$index - 1]['id'] ?>" style="text-decoration:none;"><i class="bi bi-arrow-left-short"></i></a>
            <i onclick="playMusic(<?= $song['id'] ?>)" class="bi bi-play"></i>
            <a onclick="goToSong(<?= $index === sizeof($songs_session) - 1 ?  $songs_session[$index]['id'] : $songs_session[$index + 1]['id'] ?>)" href="./music-detail.php?song_id=<?= $index === sizeof($songs_session) - 1 ?  $songs_session[$index]['id'] : $songs_session[$index + 1]['id'] ?>" style="text-decoration:none; color:white;"><i class="bi bi-arrow-right-short"></i></a> 
        </div>

    </div>

    <?php include './layout/music-control.php' ?>
    <?php include './layout/footer.php' ?>
