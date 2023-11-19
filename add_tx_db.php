<?php

session_start();
require_once('connect.php');

if (isset($_POST['add_tx_submit'])) {

    $amount = $_POST['amount'];
    $cat_id = $_POST['category'];
    $type = $_POST['type'];
    $method = $_POST['method'];
    $goal = $_POST['goal'];

    if ($type == 'Expense') {
        $type = true;
    } else if ($type == 'Income') {
        $type = false;
    }

    //check if all characters are numeric (also dont allow - (minus) sign)
    if (!ctype_digit($goal)) {
        $goal = NULL;
    } else {
        $goal = (int) $goal;
    }

    $stmt = $mysqli->prepare("INSERT INTO transactions (amount, category_id, goal_id, method_id, uid) VALUES (?,?,?,?,?)");

    if ($type == "Expense" || $type == "SaveGoal") {
        $amount = $amount * -1;
    }

    $stmt->bind_param("diiii", $amount, $cat_id, $goal, $method, $_SESSION["uid"]);
    $stmt->execute();

    echo "Inserted sucessfully";

    header("location: wallet.php");
}
