<?php
/** @var mysqli $db */
session_start();

require_once "../includes/database.php";

if (!isset($_SESSION['loggedInUser'])) {
    header("Location: ../HTML/home.html");
    exit;
}

$query = "SELECT reservations.*, TABLES.size, TABLES.number 
            FROM `reservations` 
            LEFT JOIN reservations_tables ON reservations.id = reservations_tables.reservations_id 
            LEFT JOIN TABLES ON reservations_tables.table_id = TABLES.id
";
$result = mysqli_query($db, $query) or die ('Error');

$reservations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}

mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Overzicht</title>
</head>
<body>
<h1>Overzicht</h1>
<a href="logout.php"></a>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Naam</th>
        <th>Telefoonnummer</th>
        <th>E-Mail</th>
        <th>Hoeveelheid gasten</th>
        <th>Datum en tijd</th>
        <th>Tafel nummer</th>
        <th>Tafel grootte</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($reservations as $reservation) { ?>
        <tr>
            <td><?= $reservation['id'] ?></td>
            <td><?= $reservation['name'] ?></td>
            <td><?= $reservation['phone_number'] ?></td>
            <td><?= $reservation['email'] ?></td>
            <td><?= $reservation['amount_of_guests'] ?></td>
            <td><?= $reservation['date_and_time'] ?></td>
            <td><?= $reservation['number'] ?></td>
            <td><?= $reservation['size'] ?></td>
            <td><a href="wijzigen.php?id=<?= $reservation['id'] ?>">Wijzigen</a></td>
            <td><a href="verwijderen.php?id=<?= $reservation['id'] ?>">Verwijderen</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
