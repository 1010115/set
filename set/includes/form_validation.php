<?php

$errors = [];

if (!isset($_POST['name']) ||$name === "") {
    $errors['name'] = 'Vul alstublieft uw voor en achternaam';
}
if (!is_numeric($phone_number) || strlen($phone_number) < 9 ){
    $errors['phone_number'] = 'Vul alstublieft een telefoonnummer van 9 cijfers of meer.';
}
if (!is_numeric($phone_number) || strlen($phone_number) > 16){
    $errors['phone_number'] = 'Vul alstublieft een telefoonnummer die kleiner dan 16 cijfers is.';
}
if (!isset($_POST['phone_number']) || $phone_number === ""){
    $errors['phone_number'] = 'Vul alstublieft uw telefoonnummer in';
}
if (!isset($_POST['email']) || $email === ""){
    $errors['email'] = 'Vul alstublieft uw E-Mail adres in';
}
if (!isset($_POST['amount_of_guests']) ||$amount_of_guests === ""){
    $errors['amount_of_guests'] = 'Vul alstublieft de hoeveelheid gasten ';
}
if (!isset($_POST['date_and_time']) ||$date_and_time === ""){
    $errors['date_and_time'] = 'Vul alstublieft uw gewenste datum in';
}
if(!isset($_POST['tables']) || empty($tableIds) === true){
    $errors['tables'] = 'Selecteer alstublieft een tafel';
}