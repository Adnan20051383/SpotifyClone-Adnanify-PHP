<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['song_id'])) {
        $_SESSION['current_song_id'] = $_POST['song_id'];
    }
}
?>