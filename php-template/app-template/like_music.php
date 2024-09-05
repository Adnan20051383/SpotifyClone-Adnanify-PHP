<?php

session_start();
include './dataBase/db.php';
if (!isset($_SESSION['logged_in_user'])) {
    header("Location:./signin.php?err-msg=First, Sign In!");
    exit();
}
if (isset($_GET['song_id'])) {
    $song = $mainConnection->query("SELECT * FROM musics WHERE id = $_GET[song_id]")->fetch();
    $stmt = $mainConnection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $_SESSION['logged_in_user']]);
    $user = $stmt->fetch();
    $statement = $mainConnection->prepare("SELECT * FROM music_likes WHERE user_id = :user_id AND music_id = :song_id");
    $statement->execute(['user_id' => $user['id'], 'song_id' => $_GET['song_id']]);
    if ($statement->rowCount() == 1) {
        $statement2 = $mainConnection->prepare("DELETE FROM music_likes WHERE user_id = :user_id AND music_id = :song_id");
        $statement2->execute(['user_id' => $user['id'], 'song_id' => $_GET['song_id']]);
    }
    else {
        $statement2 = $mainConnection->prepare("INSERT INTO music_likes (user_id, music_id) VALUES (:user_id, :song_id)");
        $statement2->execute(['user_id' => $user['id'], 'song_id' => $_GET['song_id']]);
    }
    $likes = $mainConnection->query("SELECT * FROM music_likes WHERE music_id = $_GET[song_id]")->rowCount();
    $statement3 = $mainConnection->prepare("UPDATE musics SET likes_num = :likes_num WHERE id =  :id");
    $statement3->execute(['likes_num' => $likes, 'id' => $song['id']]);
    header("Location:./$_GET[page]");
    exit();
}


?>