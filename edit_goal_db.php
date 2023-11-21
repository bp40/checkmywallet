<?php
require __DIR__ . '/header_script.php';
session_start();
require_once('connect.php');
verifySession();

if (isset($_POST["submit_goal_edit"])) {

    $goal_id = $_POST['goal_id'] ?? null;
    $goal_name = $_POST['goal_name'] ?? null;
    $goal_amount = $_POST['goal_amount'] ?? null;
    $goal_date = $_POST['goal_date'] ?? null;

    $stmt = $mysqli->prepare("UPDATE savings_goal SET goal_name=?, goal_amount=?, goal_date=? WHERE goal_id=?");
    $stmt->bind_param("sisi", $goal_name, $goal_amount, $goal_date, $goal_id);
    $stmt->execute();

    echo "Edited sucessfully";

    header("location: wallet.php");
    die();
}
