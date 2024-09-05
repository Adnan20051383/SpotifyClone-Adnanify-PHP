<?php if (isset($_SESSION['current_song_id'])): ?>
<?php $current_song = $mainConnection->query("SELECT * FROM musics WHERE id = $_SESSION[current_song_id]")->fetch();
      $current_song_artist = $mainConnection->query("SELECT * FROM artists WHERE id = $current_song[artist_id]")->fetch();
?>
<div class="currently-playing" onclick="goToCurrentSong()">
    <div class="current-song-cover">
        <img src="./assets/img/<?= $current_song['cover'] ?>" alt="Song Cover">
    </div>
    <div class="song-info">
        <h3 class="song-title"><?= $current_song['title'] ?></h3>
        <p class="artist-name"><?= $current_song_artist['name'] ?></p>
    </div>
</div>
<?php endif; ?>