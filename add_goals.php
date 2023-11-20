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

        <!-- Title -->
        <div class="title-txt mx-4 ">
            <?php
            echo '<h1 class="mb-4 text-2xl"> Check My Wallet Plz : Adding new Goal </h1>'
            ?>
        </div>

        <!-- Inputs -->
        <form action="./add_goal_db.php" method="post">
            <div class="add-controls">
                <label class="block"> Goal Name </label>
                <input name="goal_name" placeholder="e.g. Trip to Japan" class="category-box rounded text-gray-400 gray-bkg" type="text">
            </div>

            <div class="add-controls">
                <label class="block"> Goal Amount </label>
                <input name="goal_amount" placeholder="e.g. 10000" class="category-box rounded text-gray-400 gray-bkg" type="number" min="1" step="any">
            </div>

            <div class="add-controls">
                <label class="block"> Goal Deadline </label>
                <input name="goal_date" class="category-box rounded text-gray-400 gray-bkg" type="date">
            </div>

            <div class="px-2 py-2">
                <button type="submit" name="add_goal_submit" class="btn bg-purple-600 px-2"> Add Goal </button>
            </div>

        </form>
    </div>
</body>

</html>