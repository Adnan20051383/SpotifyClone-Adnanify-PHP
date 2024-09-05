<?php include './layout/header.php' ?>
<?php

if (isset($_POST['add-artist'])) {
    $name = trim($_POST['name']);
    $bio = trim($_POST['bio']);
    $image = $_FILES['image'];
    move_uploaded_file($image['tmp_name'], '../app-template/assets/img/' . $image['name']);
    $statement = $mainConnection->prepare("INSERT INTO artists (name, about, image) VALUES (:name, :bio, :image)");
    $statement->execute(['name' => $name, 'bio' => $bio, 'image' => $image['name']]);
    header("Location:./add-artist.php");
    exit();
}

?>

<div class="form-container">
        <h1>Add New Music</h1>
        <form class="music-form" method="post" enctype="multipart/form-data">
            <label for="name">Artist Name</label>
            <input type="text" id="title" name="name" placeholder="Enter artist name" required>

            <label for="bio">About Artist</label>
            <textarea name="bio" id="bio" placeholder="Write About Artist..." required></textarea>

            <label for="cover">Artist Image</label>
            <input type="file" id="cover" name="image" accept="image/*" required>
            <button name="add-artist" type="submit" class="add-btn">Add Artist</button>
        </form>
    </div>


<?php include './layout/footer.php' ?>