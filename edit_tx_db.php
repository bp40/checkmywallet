<?php

require __DIR__ . '/header_script.php';
session_start();
require_once('connect.php');
verifySession();

if (isset($_POST['edit_tx_submit'])) {

    $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
    $cat_id = isset($_POST['category']) ? $_POST['category'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $method = isset($_POST['method']) ? $_POST['method'] : null;
    $goal = isset($_POST['goal']) ? $_POST['goal'] : null;
    $txId = isset($_POST['txID']) ? $_POST['txID'] : null;


    if (!ctype_digit($goal)) {
        $goal = NULL;
    } else {
        $goal = (int) $goal;
    }

    //cat id=5 is transfer to goal
    if ($type == "Expense" || $cat_id == 5) {
        $amount = abs($amount) * -1;
    } else {
        $amount = abs($amount);
    }

    $stmt = $mysqli->prepare("SELECT * FROM transactions WHERE transaction_id=?;");
    $stmt->bind_param("i", $txId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['category_id'] != $cat_id) {

        //delete old transaction of different type
        $stmt = $mysqli->prepare("DELETE FROM transactions WHERE transaction_id=?;");
        $stmt->bind_param("i", $txId);
        $stmt->execute();

        //make new transaction instead to avoid error when switching b/w type
        $stmt = $mysqli->prepare("INSERT INTO transactions (amount, category_id, goal_id, method_id, uid) VALUES (?,?,?,?,?)");
        $stmt->bind_param("diiii", $amount, $cat_id, $goal, $method, $_SESSION["uid"]);
        $stmt->execute();

        header("location: wallet.php");
        die();
    } else {
        $stmt = $mysqli->prepare("UPDATE transactions SET amount=?, category_id=?, goal_id=?, method_id=?, transaction_time=transaction_time WHERE transaction_id=?;");
        $stmt->bind_param("diiii", $amount, $cat_id, $goal, $method, $txId);
        $stmt->execute();

        header("location: wallet.php");
        die();
    }
}

if (isset($_POST['delete_tx_submit'])) {

    $txId = isset($_POST['txID']) ? $_POST['txID'] : null;

    $stmt = $mysqli->prepare("DELETE FROM transactions WHERE transaction_id=?;");
    $stmt->bind_param("i", $txId);
    $stmt->execute();

    header("location: wallet.php");
    die();
}
