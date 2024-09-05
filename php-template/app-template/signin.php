<?php include './layout/header.php' ?>
<?php

$emailNeeded = '';
$passNeeded = '';
if (isset($_POST['sign-in'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $formIsGood = true;
    if (empty(($email))) {
        $emailNeeded = 'Please fill the Email Field';
        $formIsGood = false;
    }
    if (empty(($pass))) {
        $passNeeded = 'Please fill the Password Field';
        $formIsGood = false;
    }
    if ($formIsGood) {
        $statement = $mainConnection->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $statement->execute(['email' => $email, 'password' => $pass]);
        if ($statement->rowCount() == 1) {
            $_SESSION['logged_in_user'] = $email;
            header("Location:./index.php");
            exit();
        }
        else {
            header("Location:./signin.php?err-msg=User Not Found!");
            exit();
        }
    }
}

?>
    <div class="signin-container">
        <div class="text-danger">
            <?php if (isset($_GET['err-msg'])): ?>
                <?= $_GET['err-msg'] ?>
            <?php endif ?>    
        </div>
        <div class="signin-box">
            <h2>Sign In</h2>
            <form action="#" method="post">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                    <div class="text-danger"><?= $emailNeeded ?></div>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <div class="text-danger"><?= $passNeeded ?></div>
                </div>
                <div class="input-group">
                    <button name="sign-in" type="submit" class="btn-signin">Sign In</button>
                </div>
            </form>
            <div class="additional-links">
                <a href="#">Forgot your password?</a>
                <span> | </span>
                <a href="./signup.php">Sign up for Spotify</a>
            </div>
        </div>
    </div>
<?php include './layout/footer.php' ?>