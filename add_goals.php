<?php
require __DIR__ . '/header_script.php';
session_start();
require_once('connect.php');
verifySession();
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
</head>

<body>
    <div class="ui">
        <div class="title-txt mx-4 ">
            <?php
            echo '<h1 class="mb-4 text-2xl"> Check My Wallet Plz : Adding new Goal </h1>'
            ?>
        </div>
    </div>
</body>

</html>