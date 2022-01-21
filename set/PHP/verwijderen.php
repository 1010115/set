<?php
/** @var mysqli $db */
session_start();

require_once "../includes/database.php";


if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../HTML/home.html");
    exit;
}

if (isset($_POST['submit'])) {
    $reservationId = mysqli_escape_string($db, $_POST['id']);
    $query = "SELECT * FROM reservations WHERE id = '$reservationId'";
    $result = mysqli_query($db, $query) or die('error');

    $reservation = mysqli_fetch_assoc($result);

    $query = "DELETE FROM reservations WHERE id = '$reservationId'";
    mysqli_query($db, $query);

    mysqli_close($db);

    header("Location: Overzicht.php");
    exit;
} elseif (isset($_GET['id']) || $_GET['id'] != '') {
    $reservationId = mysqli_escape_string($db, $_GET['id']);

    $query = "SELECT * FROM reservations WHERE id = $reservationId ";
    $result = mysqli_query($db, $query) or die ('Error');

    if (mysqli_num_rows($result) == 1) {
        $reservation = mysqli_fetch_assoc($result);
    } else {
        header('Location: overzicht.php');
        exit;
    }
} else {
    header('Location: overzicht.php');
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verwijderen</title>
</head>
<body>
<h1>Reservatie <?= $reservation['id'] ?> verwijderen</h1>
<form action="" method="post">
    <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
    <input type="submit" name="submit" value="Verwijderen">
</form>

</body>
</html>
