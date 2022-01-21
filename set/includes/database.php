<?php

$host = "localhost";
$database = "set";
$fuser = "root";
$password = "";

$db = mysqli_connect($host, $fuser, $password, $database)
or die("Error: " . mysqli_connect_error());;
