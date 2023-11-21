<?php

session_start();
require_once('connect.php');

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้';
        header("location: signin.php");
        die();
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: signin.php");
        die();
    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
        header("location: signin.php");
        die();
    } else {
        $q = "SELECT * FROM users WHERE username = '$username';";

        $row = mysqli_fetch_row($mysqli->query($q));

        var_dump($row);

        $mysqli->close();

        if ($row != NULL && password_verify($password, $row[2])) {
            $_SESSION["login"] = "True";
            $_SESSION['success'] = 'Success';
            $_SESSION["uid"] = $row[0];
            $_SESSION["username"] = htmlspecialchars($username);
            header("Location: signin.php");
            exit();
        } else {
            $_SESSION["login"] = "False";
            $_SESSION['error'] = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            header("Location: signin.php");
            exit();
        }
    }
}
