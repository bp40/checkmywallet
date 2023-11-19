<?php

session_start();
require_once('../connect.php');

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้';
        header("location: signin.php");
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: signin.php");
    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
        header("location: signin.php");
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM admin WHERE username=?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_row();

        var_dump($row);

        $mysqli->close();

        if ($row != NULL && password_verify($password, $row[2])) {
            $_SESSION["login"] = "True";
            $_SESSION['success'] = 'Success';
            $_SESSION["uid"] = $row[0];
            $_SESSION["username"] = $username;
            $_SESSION["user_type"] = "admin";
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
