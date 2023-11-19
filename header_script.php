<?php

function verifySession()
{
    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] == 'admin') {
            session_destroy();
            header("Location: signin.php");
        }
    }

    if (!isset($_SESSION['uid'])) {
        header("Location: signin.php");
    }
}
