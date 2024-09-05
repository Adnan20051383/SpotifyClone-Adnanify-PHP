<?php 
if (isset($_SESSION['musics'])) {
    if (isset($_SESSION['genre_id'])) {
        $songs_session = $mainConnection->query("SELECT * FROM musics WHERE genre_id = $_SESSION[genre_id]")->fetchAll();
    }
    else {
        $songs_session = $mainConnection->query("SELECT * FROM musics")->fetchAll();
    }
}

if (isset($_SESSION['album'])) {
    $songs_session = $mainConnection->query("SELECT * FROM musics WHERE album_id = $_SESSION[album]")->fetchAll();
}

if (isset($_SESSION['artist'])) {
    $songs_session = $mainConnection->query("SELECT * FROM musics WHERE artist_id = $_SESSION[artist]")->fetchAll();
}
if (isset($_SESSION['liked_musics'])) {
    $liked_songs = $mainConnection->query("SELECT * FROM music_likes WHERE user_id = $_SESSION[liked_musics]")->fetchAll();
    $songs_session = [];
    foreach($liked_songs as $liked_song) {
        $song = $mainConnection->query("SELECT * FROM musics WHERE id = $liked_song[music_id]")->fetch();
        array_push($songs_session, $song);
    }
}
?>