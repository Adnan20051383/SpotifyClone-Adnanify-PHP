<?php include './layout/header.php' ?>
<?php
function isStrongPassword($password) {
    if (strlen($password) < 8) {
        return false;
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }
    return true;
}
$nameNeeded = '';
$emailNeeded = '';
$passNeeded = '';
$passConNeeded = '';

    if (isset($_POST['create-user'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $pass = trim($_POST['password']);
        $pass2 = trim($_POST['password2']);
        $formIsGood = true;
        if (empty(($name))) {
            $nameNeeded = 'Please fill the Name Field';
            $formIsGood = false;
        }
        if (empty(($email))) {
            $emailNeeded = 'Please fill the Email Field';
            $formIsGood = false;
        }
        else {
            $emailExists = $mainConnection->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $emailExists->execute(['email' => $email]);
            $num = $emailExists->fetchColumn();
            if ($num > 0) {
                $emailNeeded = 'The email has been used before!';
                $formIsGood = false;
            }
        }
        if (empty(($pass))) {
            $passNeeded = 'Please fill the Password Field';
            $formIsGood = false;
        }
        else {
            $passIsStrong = isStrongPassword($pass);
            if (!$passIsStrong) {
                $passNeeded = 'The pass should have at least 8 chars and Uppercase and lowercase and number!';
                $formIsGood = false;
            }
        }
        if (empty(($pass2))) {
            $passConNeeded = 'Please fill the Confirm Password Field';
            $formIsGood = false;
        }
        else {
            if ($pass !== $pass2) {
                $passConNeeded = 'Passwords does not match';
                $formIsGood = false;
            }
        }
        if ($formIsGood) {
            $statement = $mainConnection->prepare("INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)");
            $statement->execute(['name' => $name, 'email' => $email, 'password' => $pass, 'role_id' => 2]);
            $stmt = $mainConnection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $new_user = $stmt->fetch();
            $statement2 = $mainConnection->prepare("INSERT INTO profiles (user_id) VALUES (:user_id)");
            $statement2->execute(['user_id' => $new_user['id']]);
            $_SESSION['logged_in_user'] = $email;
            header("Location:./index.php");
            exit();
        }

    }

?>
    <div class="signin-container">
        <div class="signin-box">
            <h2>Sign In</h2>
            <form action="#" method="post">
                <div class="input-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name">
                    <div class="text-danger"><?= $nameNeeded ?></div>
                </div>
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
                    <label for="password2">Confirm Password</label>
                    <input type="password" id="password2" name="password2">
                    <div class="text-danger"><?= $passConNeeded ?></div>
                </div>
                <div class="input-group">
                    <button name="create-user" type="submit" class="btn-signin">Sign In</button>
                </div>
            </form>
            <div class="additional-links">
                <a href="#">Already have an account?</a>
            </div>
        </div>
    </div>
    <?php include './layout/footer.php' ?>