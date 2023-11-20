<?php
require __DIR__ . '/header_script.php';
session_start();
require_once('connect.php');
verifySession();

if (isset($_POST["submit_goal_edit"])) {

    $goal_id = htmlspecialchars($_POST['goal_id'], ENT_QUOTES, 'UTF-8');
    $goal_name = htmlspecialchars($_POST['goal_name'], ENT_QUOTES, 'UTF-8');
    $goal_amount = htmlspecialchars($_POST['goal_amount'], ENT_QUOTES, 'UTF-8');
    $goal_date = htmlspecialchars($_POST['goal_date'], ENT_QUOTES, 'UTF-8');

    $stmt = $mysqli->prepare("UPDATE savings_goal SET goal_name=?, goal_amount=?, goal_date=? WHERE goal_id=?");
    $stmt->bind_param("sisi", $goal_name, $goal_amount, $goal_date, $goal_id);
    $stmt->execute();

    echo "Edited sucessfully";

    header("location: wallet.php");
}
