<?php include './layout/header.php' ?>
<?php

if (isset($_POST['add-music'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $genre = $_POST['genre'];
    $cover = $_FILES['cover'];
    $song = $_FILES['song'];
    $dateTime = $_POST['release_date'];
    $date1 = new DateTime($dateTime);
    $date = $date1->format("Y-m-d");
    move_uploaded_file($cover['tmp_name'], "../app-template/assets/img/" . $cover['name']);
    move_uploaded_file($song['tmp_name'], "../songs/" . $song['name']);
    if ($album != 0) {
        $statement = $mainConnection->prepare("INSERT INTO musics (title, url, artist_id, album_id, cover, genre_id, date) VALUES (:title, :url, :artist_id, :album_id, :cover, :genre_id, :date)");
        $statement->execute(['title' => $title, 'url' => $song['name'], 'artist_id' => $artist, 'album_id' => $album, 'cover' => $cover['name'], 
                                'genre_id' => $genre, 'date' => $date]);
    }
    else {
        $statement = $mainConnection->prepare("INSERT INTO musics (title, url, artist_id, cover, genre_id, date) VALUES (:title, :url, :artist_id, :cover, :genre_id, :date)");
        $statement->execute(['title' => $title, 'url' => $song['name'], 'artist_id' => $artist, 'cover' => $cover['name'], 'genre_id' => $genre, 'date' => $date]);
    }
    header("Location:./add-music.php");
    exit();
}

?>

<div class="form-container">
        <h1>Add New Music</h1>
        <form class="music-form" method="post" enctype="multipart/form-data">
            <label for="title">Music Title</label>
            <input type="text" id="title" name="title" placeholder="Enter music title" required>

            <label for="artist">Artist</label>
            <select id="artist" name="artist" required>
                <?php foreach($artists as $artist): ?>
                <option value="<?= $artist['id'] ?>"><?= $artist['name'] ?></option>
                <?php endforeach ?>
            </select>

            <!-- Album -->
            <label for="album">Album</label>
            <select name="album" id="select-album" placeholder="Pick a album...">
                <option value="<?= 0 ?>">Select Album</option>
                <?php foreach($albums as $album): ?>
                <option value="<?= $album['id'] ?>"><?= $album['title'] ?></option>
                <?php endforeach ?>
            </select>

            <!-- Genre -->
            <label for="genre">Genre</label>
            <select id="genre" name="genre" required>
            <option value="1">HipHop</option>
                <option value="2">Pop</option>
                <option value="3">Rock</option>
                <option value="4">Jazz</option>
            </select>

            <label for="cover">Cover Image</label>
            <input type="file" id="cover" name="cover" accept="image/*" required>

            <label for="song">Song File</label>
            <input type="file" id="song" name="song" accept="audio/*" required>

            <label for="release_date">Release Date</label>
            <input type="date" id="release_date" name="release_date" required>

            <button name="add-music" type="submit" class="add-btn">Add Music</button>
        </form>
    </div>


<?php include './layout/footer.php' ?>