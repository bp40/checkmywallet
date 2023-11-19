<?php

session_start();
require_once('../connect.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <h1 class="navbar-brand mx-4 mb-0">
            Admin - Category
        </h1>
    </nav>

    <!-- Table -->
    <div class="container">
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Is Expense</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q = 'select * from categories;';
                    if ($result = $mysqli->query($q)) {
                        while ($row = $result->fetch_array()) {
                            echo '<tr>';
                            echo '<th>'.$row[0].'</th>';
                            echo '<th>'.$row[1].'</th>';
                            echo '<th>'.$row[2].'</th>';
                            echo '<tr>';
                        }
                    } else {
                        echo 'Query error: ' . $mysqli->error;
                    }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>