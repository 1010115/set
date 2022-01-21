<?php
/** @var mysqli $db */
require_once "../includes/database.php";
$query = " SELECT tables.* FROM tables";
$result = mysqli_query($db, $query) or die('error');

$tables = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tables[] = $row;
}


if (isset($_POST['submit'])) {

    require_once "../includes/database.php";
    $name = mysqli_escape_string($db, $_POST['name']);
    $phone_number = mysqli_escape_string($db, $_POST['phone_number']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $amount_of_guests = mysqli_escape_string($db, $_POST['amount_of_guests']);
    $date_and_time = mysqli_escape_string($db, $_POST['date_and_time']);
    $tableIds = $_POST['tables'];



    require_once "../includes/form_validation.php";

    if (empty($errors)) {
        $query = "INSERT INTO reservations (name, phone_number, email, amount_of_guests, date_and_time)
              VALUES ('$name', '$phone_number','$email', '$amount_of_guests', '$date_and_time')";

        $result = mysqli_query($db, $query) or die('Error');

        $query = "SELECT reservations.* 
         FROM `reservations`
         WHERE name = '$name'
         AND phone_number = '$phone_number' 
         AND email = '$email'
         AND amount_of_guests = '$amount_of_guests'
         AND date_and_time = '$date_and_time'
         ";

        $result = mysqli_query($db, $query) or die('Error');
        $reservation = mysqli_fetch_assoc($result);
        $reservationId = $reservation['id'];



        foreach ($tableIds as $tableId) {
            $query = "INSERT INTO `reservations_tables` (`reservations_id`, `table_id`) 
VALUES ('$reservationId', '$tableId')
";

            $result = mysqli_query($db, $query) or die ('Somethings wrong');
        }


        if ($result) {
            header('Location: ../HTML/home.html');
            exit;
        }

        mysqli_close($db);
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
    <title>SET reserveren</title>
</head>
<body>
<h1>Reserverings formulier</h1>

<form action="" method="post">
    <div>
        <label for="name">Naam</label>
        <input id="name" type="text" name="name" value="<?php if (isset($name)) {
            echo htmlentities($name);
        } else {
            echo '';
        } ?>"/>
        <span> <?php if (empty($errors['name']) === false) {
                echo $errors['name'];
            } else {
                echo '';
            } ?></span>
    </div>
    <div>
        <label for="phone_number">Telefoonnummer</label>
        <input id="phone_number" type="tel" name="phone_number" value="<?php if (isset($phone_number)) {
            echo htmlentities($phone_number);
        } else {
            echo '';
        } ?>"/>
        <span> <?php if (empty($errors['phone_number']) === false) {
                echo $errors['phone_number'];
            } else {
                echo '';
            } ?></span>
    </div>
    <div>
        <label for="email">E-mail</label>
        <input id="email" type="text" name="email" value="<?php if (isset($email)) {
            echo htmlentities($email);
        } else {
            echo '';
        } ?>"/>
        <span> <?php if (empty($errors['email']) === false) {
                echo $errors['email'];
            } else {
                echo '';
            } ?></span>
    </div>
    <div>
        <label for="amount_of_guests">Aantal gasten</label>
        <input id="amount_of_guests" type="number" name="amount_of_guests" value="<?php if (isset($amount_of_guests)) {
            echo htmlentities($amount_of_guests);
        } else {
            echo '';
        } ?>"/>
        <span> <?php if (empty($errors['amount_of_guests']) === false) {
                echo $errors['amount_of_guests'];
            } else {
                echo '';
            } ?></span>
    </div>
    <div>
        <label for="date_and_time">Tijd en datum</label>
        <input id="date_and_time" type="datetime-local" name="date_and_time" value="<?php if (isset($date_and_time)) {
            echo htmlentities($date_and_time);
        } else {
            echo '';
        } ?>"/>
        <span> <?php if (empty($errors['date_and_time']) === false) {
                echo $errors['date_and_time'];
            } else {
                echo '';
            } ?></span>
    </div>

    <div>
        <label for="tables">Tafels</label>
        <select id="tables" , multiple name="tables[]" size="8">
            <?php foreach ($tables as $table) { ?>
                <option value="<?= $table['id'] ?>"><?= "Tafel " . $table['number'] . " ( " . $table['size'] . " personen )" ?></option>
            <?php } ?>
            <option value="0" selected>Geen Voorkeur</option>
        </select>
        <span> <?php if (empty($errors['tables']) === false) {
                echo $errors['tables'];
            } else {
                echo '';
            } ?></span>
        <div>
            <input type="submit" name="submit" value="Versturen">
        </div>
</form>
</body>
</html>