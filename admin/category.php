<?php

session_start();
require_once('../connect.php');

$title = "Category";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Table -->
    <div class="container">
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Is Expense</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q = 'select * from categories;';
                    if ($result = $mysqli->query($q)) {
                        while ($row = $result->fetch_array()) {
                ?>
                    <tr>
                        <th><?php echo $row[0] ?></th>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td>
                            <form action="category_db.php" method="POST">
                                <button type="button" class="btn btn-warning btn-sm" onclick="window.location.href='category_form.php?id=<?php echo $row[0] ?>'">
                                    Edit
                                </button>
                                <button type="submit" class="btn btn-danger btn-sm" name="delete_category">
                                    Delete
                                </button>
                                <input type="hidden" name="id" value="<?php echo $row[0] ?>" />
                            </form>
                        </td>
                    </tr>
                <?php
                        }
                    } else {
                        echo 'Query error: ' . $mysqli->error;
                    }
                ?>
            </tbody>
        </table>

        <div align="end">
            <button type="button" class="btn btn-primary" onclick="window.location.href='category_form.php'">
                + Add
            </button>
        </div>
    </div>

</body>

</html>