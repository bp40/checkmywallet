<?php

session_start();
require_once('../connect.php');

$title = "Category Form";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo $title ?></title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Form -->
    <div class="container">
        <?php if (isset($_GET["id"])) {
            $q = "SELECT * FROM categories WHERE category_id = '".$_GET["id"]."';";
            $row = mysqli_fetch_row($mysqli->query($q));
        ?>
            <div class="form-id mt-4">
                Category ID: <?php echo $_GET["id"] ?>
            </div>
        <?php } ?>

        <form action="category_db.php" method="POST">
            <input type="hidden" name="id" value="<?php if (isset($_GET["id"])) { echo $_GET["id"]; } ?>" />

            <div class="my-4">
                <label for="name" class="form-label">Category Name</label>
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    aria-describedby="name"
                    value="<?php if (isset($_GET["id"])) { echo $row[1]; } ?>"
                    required
                >
            </div>
            
            <div class="form-check">
                <input type="hidden" name="is_expense" value="0">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="is_expense"
                    value="1"
                    <?php if (isset($_GET["id"]) && $row[2] == 1) { echo "checked"; } ?>
                >
                <label class="form-check-label" for="flexCheckDefault">
                    Is Expense
                </label>
            </div>

            <div align="end">
                <?php if (isset($_GET["id"])) { ?>
                    <button type="submit" class="btn btn-primary" name="update_category">
                        Save
                    </button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-primary" name="add_category">
                        Save
                    </button>
                <?php } ?>
            </div>
        </form>
    </div>

</body>

</html>