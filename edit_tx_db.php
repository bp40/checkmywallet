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

    if ($type == 'Expense') {
        $type = true;
    } else {
        $type = false;
    }

    if (!is_int($goal) || $goal <= 0) {
        $goal = NULL;
    }

    error_log(print_r($_POST, true));

    $stmt = $mysqli->prepare("UPDATE transactions SET amount=?, category_id=?, goal_id=?, method_id=?, transaction_time=transaction_time WHERE transaction_id=?;");

    if ($type == "Expense") {
        $amount = abs($amount) * -1;
    } else {
        $amount = abs($amount);
    }

    $stmt->bind_param("diiii", $amount, $cat_id, $goal, $method, $txId);
    $stmt->execute();

    echo "Edited sucessfully";

    header("location: wallet.php");
    die();
}

if (isset($_POST['delete_tx_submit'])) {

    $txId = isset($_POST['txID']) ? $_POST['txID'] : null;

    $stmt = $mysqli->prepare("DELETE FROM transactions WHERE transaction_id=?;");
    $stmt->bind_param("i", $txId);
    $stmt->execute();

    header("location: wallet.php");
    die();
}
