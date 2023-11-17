<?php

$servername = "localhost";
$username = "root"; //default please change
$password = "root"; //default please change
$dbname = "css326project";
$port = 3307;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli($servername, $username, $password, $dbname, $port);

if ($mysqli->connect_errno) {
    echo $mysqli->connect_errno . ": " . $mysqli->connect_error;
}
