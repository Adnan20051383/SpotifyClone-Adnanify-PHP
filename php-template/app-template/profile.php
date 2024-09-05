<?php include './layout/header.php' ?>
<?php


$nameNeeded = '';
if (isset($_GET['user_id'])) {
    $user = $mainConnection->query("SELECT * FROM users WHERE id = " . intval($_GET['user_id']))->fetch();
    if ($user['email'] !== $_SESSION['logged_in_user']) {
        header("Location: ./index.php");
        exit();
    }
    $profile = $mainConnection->query("SELECT * FROM profiles WHERE user_id = " . intval($_GET['user_id']))->fetch();
    if (isset($_POST['save-changes'])) {
        $name = trim($_POST['profile-name']);
        $image = $_FILES['profile-img'];
        $formIsGood = true;
        if (empty($name)) {
            $nameNeeded = 'Fill the name field!';
            $formIsGood = false;
        }
        if (!empty($image['tmp_name'])) {
                $targetDir = './assets/img/';
                $targetFile = $targetDir . basename($image['name']);
                if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                    $stmt1 = $mainConnection->prepare("UPDATE profiles SET image = :image WHERE id = :profile_id");
                    $stmt1->execute([
                        'image' => $image['name'],
                        'profile_id' => $profile['id']
                    ]);
                } else {
                    echo "Failed to move uploaded file.";
                    $formIsGood = false;
                }
        }
        if ($formIsGood) {
            $stmt2 = $mainConnection->prepare("UPDATE users SET name = :name WHERE id = :user_id");
            $stmt2->execute([
                'name' => $name,
                'user_id' => $user['id']
            ]);
            header("Location: ./profile.php?user_id=" . $user['id']);
            exit();
        }
    }
}



?>

<main class="profile-container">
        <form enctype="multipart/form-data" method="post" class="profile-header">
            <div class="profile-image-wrapper">
            <img src="./assets/img/<?= $profile['image'] ?>" onerror="this.onerror=null; this.src='./assets/img/download.png';" id="profile_img" class="profile-image">
                <input name="profile-img" id="profile-img-chooser" type="file" accept="image/*" class="d-none">
                <span onclick="chooseProPic()" class="edit-icon">&#9998;</span>
            </div>
            <div class="profile-info">
                <input name="profile-name" type="text" class="profile-name-input" value="<?= $user['name'] ?>" placeholder="Enter your name">
                <div class="text-danger"><?= $nameNeeded ?></div>
                <button name="save-changes" class="save-button">Save</button>
            </div>
        </form>

        <div class="links-section">
            <a href="./liked-musics.php?user_id=<?= $profile['user_id'] ?>" class="profile-link">Liked Musics</a>
            <a href="./liked-albums.php?user_id=<?= $profile['user_id'] ?>" class="profile-link">Liked Albums</a>
        </div>
        <div style="justify-content:center" class="links-section">
            <a href="./signout.php" class="profile-link">Logout</a>
        </div>
    </main>
<script>

document.getElementById('profile-img-chooser').addEventListener('change', event => {
    const file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = e => {
            document.getElementById('profile_img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?php include './layout/current_music.php' ?>
<?php include './layout/footer.php' ?>