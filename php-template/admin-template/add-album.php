<?php include './layout/header.php' ?>
<?php

if (isset($_POST['add-album'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $cover = $_FILES['cover'];
    $dateTime = $_POST['release_date'];
    $date1 = new DateTime($dateTime);
    $date = $date1->format("Y-m-d");
    move_uploaded_file($cover['tmp_name'], "../app-template/assets/img/" . $cover['name']);
    $statement = $mainConnection->prepare("INSERT INTO albums (title, artist_id, cover, genre_id, date) VALUES (:title, :artist_id, :cover, :genre_id, :date)");
    $statement->execute(['title' => $title, 'artist_id' => $artist, 'cover' => $cover['name'], 'genre_id' => $genre, 'date' => $date]);
    header("Location:./add-album.php");
    exit();
}

?>

<div class="form-container">
        <h1>Add New Music</h1>
        <form class="music-form" method="post" enctype="multipart/form-data">
            <label for="title">Album Title</label>
            <input type="text" id="title" name="title" placeholder="Enter Album title" required>

            <label for="artist">Artist</label>
            <select id="artist" name="artist" required>
                <?php foreach($artists as $artist): ?>
                <option value="<?= $artist['id'] ?>"><?= $artist['name'] ?></option>
                <?php endforeach ?>
            </select>

            <label for="genre">Genre</label>
            <select id="genre" name="genre" required>
            <option value="1">HipHop</option>
                <option value="2">Pop</option>
                <option value="3">Rock</option>
                <option value="4">Jazz</option>
            </select>

            <label for="cover">Cover Image</label>
            <input type="file" id="cover" name="cover" accept="image/*" required>

            <label for="release_date">Release Date</label>
            <input type="date" id="release_date" name="release_date" required>

            <button name="add-album" type="submit" class="add-btn">Add Album</button>
        </form>
    </div>


<?php include './layout/footer.php' ?>