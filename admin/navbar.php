<?php

if (!isset($_SESSION['admin_uid'])) {
    header("Location: signin.php");
}

?>

<!DOCTYPE html>
<html lang="en">

    <body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <h1 class="navbar-brand mx-4 mb-0">
            Admin - <?php echo $title ?>
        </h1>

        <div style="display: flex; flex-direction: row;">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menu
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="./category.php">Category</a>
                    <a class="dropdown-item" href="./method.php">Payment Method</a>
                </div>
            </div>

            <div class="mx-2">
                <form action="signout.php" method="POST">
                    <button type="submit" class="btn btn-danger">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
</html>