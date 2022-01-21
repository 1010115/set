<?php
session_start();
/** @var mysqli $db */

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../HTML/home.html");
    exit;
}

if(isset($_POST['submit'])) {
    require_once "../includes/database.php";

    $username = mysqli_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    $errors = [];
    if($username == '') {
        $errors['username'] = 'Voer alstublieft een gebruikersnaam in';
    }
    if($password == '') {
        $errors['password'] = 'Voer alstubllieft een wachtwoord in';
    }

    if(empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        $result = mysqli_query($db, $query)
        or die('Error: '.mysqli_error($db).' with query: '.$query);

        if ($result) {
            header('Location: login.php');
            exit;
        }
    }
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
<h1>Account aanmaken</h1>
<form method="post" action="">
    <div>
    <label for="username">Gebruikersnaam</label>
    <input type="text" name="username" id="username">
    </div>

    <div>
    <label for="password">Wachtwoord</label>
    <input type="password" name="password" id="password">
    </div>

    <div>
        <input type="submit" name="submit" value="Aanmaken">
    </div>
</form>

</body>
</html>
