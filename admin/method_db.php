<?php

session_start();
require_once('../connect.php');

$id = $_POST['id'];
$name = $_POST['name'];

if (isset($_POST["add_method"])) {
    $q = "INSERT INTO payment_method(method_name) VALUES ('$name');";

    echo $q;

    if (!$mysqli->query($q)) {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: method_form.php");
    } else {
        header("location: method.php");
    }
}

if (isset($_POST["update_method"])) {
    $q = "UPDATE payment_method SET method_name = '$name' WHERE method_id = '".$id."';";

    echo $q;

    if (!$mysqli->query($q)) {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: method_form.php");
    } else {
        header("location: method.php");
    }
}

if (isset($_POST["delete_method"])) {
    $q = "DELETE FROM payment_method WHERE method_id = '".$id."';";

    echo $q;

    if (!$mysqli->query($q)) {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: method.php");
    } else {
        header("location: method.php");
    }
}