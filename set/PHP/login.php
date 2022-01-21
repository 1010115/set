<?php
session_start();
/** @var mysqli $db */
require_once "../includes/database.php";

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

if (isset($_POST['submit'])) {
    $username = mysqli_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    $errors = [];
    if($username == '') {
        $errors['username'] = 'Voer uw gebruikersnaam in';
    }
    if($password == '') {
        $errors['password'] = 'Voer uw wachtwoord in';
    }

    if(empty($errors))
    {
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($db, $query);
        var_dump($result);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'username' => $user['username'],
                    'id' => $user['id']
                ];
            } else {
                $errors['loginFailed'] = 'Uw wachtwoord of E-mail is verkeerd';
            }
        } else {
            $errors['loginFailed'] = 'Uw wachtwoord of E-mail is verkeerd';
        }
    }
}

if ($login){
    header('Location: overzicht.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<form method="post" action="">
    <div>
        <label for="username">Gebruikersnaam</label>
        <input type="text" name="username" id="username">
        <span><?= $errors['username'] ?? '' ?></span>

    </div>

    <div>
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password">
        <span><?= $errors['password'] ?? '' ?></span>
    </div>

    <div>
        <input type="submit" name="submit" value="Login">
        <span><?=$errors['loginFailed'] ?? ''?></span>
    </div>

</form>
</body>
</html>
