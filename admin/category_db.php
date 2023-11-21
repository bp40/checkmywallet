<?php

session_start();
require_once('../connect.php');

$id = $_POST['id'];
$name = $_POST['name'];
$is_expense = $_POST['is_expense'];

if (isset($_POST["add_category"])) {
    $q = "INSERT INTO categories(category_name, is_expense) VALUES ('$name', '$is_expense');";

    echo $q;

    if (!$mysqli->query($q)) {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: category_form.php");
    } else {
        header("location: category.php");
    }
}

if (isset($_POST["update_category"])) {
    $q = "UPDATE categories SET category_name = '$name', is_expense = '$is_expense' WHERE category_id = '".$id."';";

    echo $q;

    if (!$mysqli->query($q)) {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: category_form.php");
    } else {
        header("location: category.php");
    }
}

if (isset($_POST["delete_category"])) {
    $q = "DELETE FROM categories WHERE category_id = '".$id."';";

    echo $q;

    if (!$mysqli->query($q)) {
        $_SESSION['error'] = "มีบางอย่างผิดพลาด";
        header("location: category.php");
    } else {
        header("location: category.php");
    }
}
