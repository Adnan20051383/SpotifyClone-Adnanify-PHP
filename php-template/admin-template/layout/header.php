<?php session_start(); ?>
<?php include './assets/dataBase/db.php' ?>
<?php

if (!isset($_SESSION['logged_in_user'])) {
    header("Location:../app-template/signin.php?err-msg=First, Sign In As Admin!");
    exit();
}
else {
    $stmt = $mainConnection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $_SESSION['logged_in_user']]);
    $user = $stmt->fetch();
    if ($user['role_id'] == 2) {
        header("Location:../app-template/signin.php?err-msg=First, Sign In As Admin!");
        exit();
    }
}

?>

<?php

$musics = $mainConnection->query("SELECT * FROM musics ORDER BY id DESC");
$artists = $mainConnection->query("SELECT * FROM artists ORDER BY id DESC");
$albums = $mainConnection->query("SELECT * FROM albums ORDER BY id DESC");

?>
<?php

    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'delete') {
            if ($_GET['elem'] === 'music') {
                $mainConnection->query("DELETE FROM musics WHERE id = $_GET[id]");
            }
            if ($_GET['elem'] === 'artist') {
                $mainConnection->query("DELETE FROM artists WHERE id = $_GET[id]");
            }
            if ($_GET['elem'] === 'album') {
                $mainConnection->query("DELETE FROM albums WHERE id = $_GET[id]");
            }
        }
        if (str_contains($_SERVER['REQUEST_URI'], 'index')) {
            header("Location:./index.php");
            exit();
        }
        if (str_contains($_SERVER['REQUEST_URI'], 'musics')) {
            header("Location:./musics.php");
            exit();
        }
        if (str_contains($_SERVER['REQUEST_URI'], 'albums')) {
            header("Location:./albums.php");
            exit();
        }
        if (str_contains($_SERVER['REQUEST_URI'], 'artists')) {
            header("Location:./artists.php");
            exit();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adnanify Admin Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo"><a href="./index.php">Adnanify</a></div>
            <nav class="nav-links">
                <a href="./musics.php">Musics</a>
                <a href="./artists.php">Artists</a>
                <a href="./albums.php">Albums</a>
                <a href="../app-template/signout.php">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Admin Dashboard</h1>
            </header>