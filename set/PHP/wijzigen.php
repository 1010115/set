<?php
/** @var mysqli $db */
session_start();

require_once "../includes/database.php";

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../HTML/home.html");
    exit;
}

$query = " SELECT tables.* FROM tables";
$result = mysqli_query($db, $query) or die('error');

$tables = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tables[] = $row;
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $amount_of_guests = $_POST['amount_of_guests'];
    $date_and_time = $_POST['date_and_time'];
    $tableIds = $_POST['tables'];



    $id = $_POST['id'];

    require_once "../includes/form_validation.php";
    if (empty($errors)) {

        $query = "UPDATE reservations 
                    SET name = '$name', phone_number = '$phone_number', email = '$email', date_and_time = '$date_and_time', amount_of_guests = '$amount_of_guests' 
                    WHERE id = '$id'";
        $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db) . ' with query ' . $query);


        foreach ($tableIds as $tableId) {
            $query = "UPDATE `reservations_tables` SET table_id = '$tableId' 
                        WHERE reservations_id = '$id'";
            $result = mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db) . ' with query ' . $query);
        }

        if ($result) {
            header('Location: overzicht.php');
            exit;
        }
        mysqli_close($db);
    }

} elseif (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = "SELECT reservations.*, TABLES.size, TABLES.number, tables.id AS tableId
            FROM `reservations` 
            LEFT JOIN reservations_tables ON reservations.id = reservations_tables.reservations_id 
            LEFT JOIN TABLES ON reservations_tables.table_id = TABLES.id";
    $result = mysqli_query($db, $query)
    or die('error');


    $reservering = mysqli_fetch_assoc($result);

    $name = $reservering['name'];
    $phone_number = $reservering['phone_number'];
    $email = $reservering['email'];
    $amount_of_guests = $reservering['amount_of_guests'];
    $date_and_time = date('Y-m-d\TH:i', strtotime($reservering['date_and_time']));

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wijzigen</title>
</head>
<body>
<h1>Wijzigen</h1>
<form action="" method="post">
    <div>
        <label for="name">Naam</label>
        <input id="name" type="text" name="name" value="<?php if (isset($name)) {
            echo htmlentities($name);
        } else {
            echo '';
        } ?>">
        <span> <?php if (empty($errors['name']) === false) {
                echo $errors['name'];
            } else {
                echo '';
            } ?></span>
    </div>

    <div>
        <label for="phone_number">Telefoonnummer</label>
        <input id="phone_number" type="text" name="phone_number" value="<?php if (isset($phone_number)) {
            echo htmlentities($phone_number);
        } else {
            echo '';
        } ?>">
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
        } ?>">
        <span> <?php if (empty($errors['email']) === false) {
                echo $errors['email'];
            } else {
                echo '';
            } ?></span>
    </div>

    <div>
        <label for="amount_of_guests">Hoeveelheid gasten</label>
        <input id="amount_of_guests" type="text" name="amount_of_guests" value="<?php if (isset($amount_of_guests)) {
            echo htmlentities($amount_of_guests);
        } else {
            echo '';
        } ?>">
        <span> <?php if (empty($errors['amount_of_guests']) === false) {
                echo $errors['amount_of_guests'];
            } else {
                echo '';
            } ?></span>
    </div>

    <div>
        <label for="date_and_time">Datum en tijd</label>
        <input id="date_and_time" type="datetime-local" name="date_and_time" value="
<?php
        if (isset($date_and_time)) {
            echo htmlentities($date_and_time);
        } else {
            echo '';
        } ?>
">
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

        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="submit" name="submit" value="Opslaan">

</form>

</body>
</html>
