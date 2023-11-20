<?php
require __DIR__ . '/header_script.php';
session_start();
require_once('connect.php');
verifySession();

if (isset($_POST['add_goal_submit'])) {

    $goal_name = htmlspecialchars($_POST['goal_name'], ENT_QUOTES, 'UTF-8');
    $goal_amount = htmlspecialchars($_POST['goal_amount'], ENT_QUOTES, 'UTF-8');
    $goal_date = htmlspecialchars($_POST['goal_date'], ENT_QUOTES, 'UTF-8');

    $stmt = $mysqli->prepare("INSERT INTO savings_goal (goal_name, goal_amount, goal_date, uid) VALUES (?,?,?,?)");
    $stmt->bind_param("sisi", $goal_name, $goal_amount, $goal_date, $_SESSION["uid"]);
    $stmt->execute();

    echo "Inserted sucessfully";

    header("location: wallet.php");
}
