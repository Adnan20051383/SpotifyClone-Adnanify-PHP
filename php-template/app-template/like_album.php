<?php

session_start();
include './dataBase/db.php';
if (!isset($_SESSION['logged_in_user'])) {
    header("Location:./signin.php?err-msg=First, Sign In!");
    exit();
}
if (isset($_GET['album_id'])) {
    $album = $mainConnection->query("SELECT * FROM albums WHERE id = $_GET[album_id]")->fetch();
    $stmt = $mainConnection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $_SESSION['logged_in_user']]);
    $user = $stmt->fetch();
    $statement = $mainConnection->prepare("SELECT * FROM album_likes WHERE user_id = :user_id AND album_id = :album_id");
    $statement->execute(['user_id' => $user['id'], 'album_id' => $_GET['album_id']]);
    if ($statement->rowCount() == 1) {
        $statement2 = $mainConnection->prepare("DELETE FROM album_likes WHERE user_id = :user_id AND album_id = :album_id");
        $statement2->execute(['user_id' => $user['id'], 'album_id' => $_GET['album_id']]);
    }
    else {
        $statement2 = $mainConnection->prepare("INSERT INTO album_likes (user_id, album_id) VALUES (:user_id, :album_id)");
        $statement2->execute(['user_id' => $user['id'], 'album_id' => $_GET['album_id']]);
    }
    $likes = $mainConnection->query("SELECT * FROM album_likes WHERE album_id = $_GET[album_id]")->rowCount();
    $statement3 = $mainConnection->prepare("UPDATE albums SET likes_num = :likes_num WHERE id = $album[id]");
    $statement3->execute(['likes_num' => $likes]);
    $album_id = $_GET['album_id'];
    header("Location:./album-detail.php?album_id=$album_id");
    exit();
}


?>