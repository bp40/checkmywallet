<?php

session_start();
require_once('../connect.php');

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username)) {
        $_SESSION['error'] = 'Please add username';
        header("location: signin.php");
        die();
    } else if (empty($password)) {
        $_SESSION['error'] = 'Please add password';
        header("location: signin.php");
        die();
    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        $_SESSION['error'] = 'Password must be 5-20 characters';
        header("location: signin.php");
        die();
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM admin WHERE username=?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_row();

        $mysqli->close();

        if ($row != NULL && password_verify($password, $row[2])) {
            $_SESSION["login"] = "True";
            $_SESSION['success'] = 'Success';
            $_SESSION["admin_uid"] = $row[0];
            $_SESSION["username"] = htmlspecialchars($username);
            $_SESSION["user_type"] = "admin";
            header("Location: category.php");
            exit();
        } else {
            $_SESSION["login"] = "False";
            $_SESSION['error'] = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            header("Location: signin.php");
            exit();
        }
    }
}
