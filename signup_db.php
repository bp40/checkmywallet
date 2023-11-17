<?php

session_start();
require_once('connect.php');

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้';
        header("location: index.php");
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: index.php");
    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
        header("location: index.php");
    } else if (empty($c_password)) {
        $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
        header("location: index.php");
    } else if ($password != $c_password) {
        $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
        header("location: index.php");
    } else {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $q = "INSERT INTO users(username, password) VALUES ('$username','$passwordHash');";

        echo $q;

        if (!$mysqli->query($q)) {
            // echo "UPDATE failed. Error: " . $mysqli->error;
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
            header("location: index.php");
        } else {
            $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='signin.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
            header("location: index.php");
        }

        $mysqli->close();
    }
}