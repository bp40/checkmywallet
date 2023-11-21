<?php
require __DIR__ . '/header_script.php';
session_start();
require_once('connect.php');
verifySession();

if (isset($_POST['add_goal_submit'])) {

    $goal_name = $_POST['goal_name'] ?? null;
    $goal_amount = $_POST['goal_amount'] ?? null;
    $goal_date = $_POST['goal_date'] ?? null;

    $stmt = $mysqli->prepare("INSERT INTO savings_goal (goal_name, goal_amount, goal_date, uid) VALUES (?,?,?,?)");
    $stmt->bind_param("sisi", $goal_name, $goal_amount, $goal_date, $_SESSION["uid"]);
    $stmt->execute();

    echo "Inserted sucessfully";

    header("location: wallet.php");
    die();
}
