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
            echo '<h1 class="mb-4 text-2xl"> Check My Wallet Plz (Hello, ' . $_SESSION["username"] . '!)</h1>'
            ?>
        </div>

        <!-- Goals -->
        <div>
            <button class="btn btn-primary rounded bg-purple-600 px-2"> <a href="goals.php">View/Set Goals</a> </button>
        </div>

        <!-- Search and Category -->
        <div class="flex flex-row justify-evenly items-center w-2/3">
            <div>
                <form class="flex items-center" action="wallet.php" method="get">
                    <div class="px-2">
                        <label class="block">Payment Method</label>
                        <select name="method" id="method" class="category-box rounded text-gray-400 gray-bkg">
                            <option value="all"> All </option>
                            <?php
                            $q = 'select method_id, method_name from payment_method;';
                            if ($result = $mysqli->query($q)) {
                                while ($row = $result->fetch_array()) {
                                    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                }
                            } else {
                                echo 'Query error: ' . $mysqli->error;
                            }
                            ?>
                        </select>
                    </div>

                    <div class="px-2">
                        <label class="block">Categories</label>
                        <select name="category" id="categories" class="category-box rounded text-gray-400 gray-bkg">
                            <option value="all"> All </option>
                            <?php
                            $q = 'select category_id, category_name from categories;';
                            if ($result = $mysqli->query($q)) {
                                while ($row = $result->fetch_array()) {
                                    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                }
                            } else {
                                echo 'Query error: ' . $mysqli->error;
                            }
                            ?>
                        </select>
                    </div>
                    <div class="px-2">
                        <button type="submit" class="rounded bg-purple-600 px-2"> Filter </button>
                    </div>

                </form>
            </div>


            <div class="px-2 py-2">
                <form action="add_tx.php" method="post">
                    <button type="submit" class="add-btn bg-purple-600 px-2"> + </button>
                </form>
            </div>

        </div>

        <!-- Balance -->
        <?php
        echo '<div class="flex">';
        $q = 'SELECT SUM(amount) FROM transactions WHERE uid = ' . $_SESSION["uid"] . ' AND goal_id IS NULL';

        if ($result = $mysqli->query($q)) {
            while ($row = $result->fetch_array()) {

                if ($row[0] >= 0) {
                    $amountColor = 'blue';
                } else {
                    $amountColor = 'red';
                }

                echo '
                <div class="bg-gray-800 p-4 m-4 rounded-lg shadow-md text-white">
                    <h2 class="text-m font-bold mb-4">Total Balance</h2>
                    <p class="text-lg font-bold text-' . $amountColor . '-400"> ' . $row[0]  . '</p>
                </div>
              ';
            }
        }

        echo '<br>';

        $q = 'SELECT SUM(amount) FROM transactions WHERE uid = ' . $_SESSION["uid"] . '';

        if ($result = $mysqli->query($q)) {
            while ($row = $result->fetch_array()) {

                if ($row[0] >= 0) {
                    $amountColor = 'blue';
                } else {
                    $amountColor = 'red';
                }

                echo '
                <div class="bg-gray-800 p-4 m-4 rounded-lg shadow-md text-white">
                    <h2 class="text-m font-bold mb-4">Available Balance</h2>
                    <p class="text-lg font-bold text-' . $amountColor . '-400"> ' . $row[0]  . '</p>
                </div>
              ';
            }
        }
        echo '</div>';
        ?>

        <!-- Results -->
        <div class="flex flex-col w-2/3 justify-evenly">
            <?php

            //prevent XSS
            $method = isset($_GET['method']) ? htmlspecialchars($_GET['method'], ENT_QUOTES, 'UTF-8') : '';
            $category = isset($_GET['category']) ? htmlspecialchars($_GET['category'], ENT_QUOTES, 'UTF-8') : '';
            $page = isset($_GET['page']) ? htmlspecialchars($_GET['page'], ENT_QUOTES, 'UTF-8') : 1;

            if ($page <= 0) {
                $page = 1;
            }

            $LIMIT_BEGIN = (intval($page) - 1) * 5;
            $LIMIT_END = ((intval($page) - 1) * 5) + 5;


            $allquery = "  SELECT  amount, pm.method_name,  c.category_name, transaction_time, goal_name, transaction_id, method_id, category_id
                        FROM transactions 
                        JOIN payment_method pm USING (method_id)
                        JOIN categories c USING (category_id)
                        LEFT JOIN savings_goal sg USING (goal_id)
                        WHERE transactions.uid = " . $_SESSION["uid"] . " ";


            if (!$method == '' && $method != 'all') {
                $filterMethod = "AND pm.method_id = " . $method . " ";
                $allquery .= $filterMethod;
            }

            if (!$category == '' && $category != 'all') {
                $filterCategory = "AND c.category_id = " . $category . " ";
                $allquery .= $filterCategory;
            }
            $allquery .= "ORDER BY transaction_time DESC ";
            $allquery .= "LIMIT " . $LIMIT_BEGIN . "," . $LIMIT_END . "";

            if ($result = $mysqli->query($allquery)) {
                while ($row = $result->fetch_assoc()) {


                    $color = 'green';
                    $type = 'Income';
                    if ($row['amount'] < 0) {
                        $type = 'Expense';
                        $color = 'red';
                    }

                    if (isset($row['goal_name'])) {
                        $type = 'Transfer to Goal';
                        $color = 'orange';
                    }

                    echo '<div class="bg-gray-800 p-4 m-4 rounded-lg shadow-md flex items-center justify-between text-white w-full  ">';
                    echo '    <div>';
                    echo '        <span class="text-lg font-semibold text-' . $color . '-500">' . $type . '</span>';
                    echo '        <p class="text-yellow-400">Category: ' . $row['category_name'] . '</p>';
                    echo '    <p class="text-gray-400">' . $row['method_name'] . '</p>';
                    echo '    <p class="text-gray-400">' . $row['transaction_time'] . '</p>';
                    if ($row['goal_name'] != null) {
                        echo '    <p class="text-yellow-200"> For Goal : ' . $row['goal_name'] . '</p>';
                    }
                    echo '    </div>';
                    if ($type == 'Income') {
                        echo '    <div class="text-2xl font-bold text-green-600">';
                        echo $row['amount'];
                        echo '    </div>';
                    } else if ($type == 'Expense') {
                        echo '    <div class="text-2xl font-bold text-red-600">';
                        echo $row['amount'];
                        echo '    </div>';
                    } else {
                        echo '    <div class="text-2xl font-bold text-yellow-600">';
                        echo $row['amount'];
                        echo '    </div>';
                    }
                    echo '<form action="edit_tx.php" method="post">
                         <input type="hidden" name="txId" value="' . $row['transaction_id'] . '"/>
                         <input type="hidden" name="amount" value="' . $row['amount'] . '"/>
                         <input type="hidden" name="method" value="' . $row['method_name'] . '"/>
                         <input type="hidden" name="category" value="' . $row['category_name'] . '"/>
                         <input type="hidden" name="methodID" value="' . $row['method_id'] . '"/>
                         <input type="hidden" name="categoryID" value="' . $row['category_id'] . '"/>
                         <button type="submit" name="submitEdit" class="bg-purple-600 text-white px-4 py-2 rounded-full">Edit</button>
                     </form>
                     </div>';
                }
            } else {
                echo 'Query error: ' . $mysqli->error;
            }

            $paramsBackward = array(
                'method' => $method,
                'category' => $category,
                'page' => $page - 1
            );

            $paramsForward = array(
                'method' => $method,
                'category' => $category,
                'page' => $page + 1
            );

            echo '<div class="flex justify-center mt-4 mb-8">
                    <a href="wallet.php?' . http_build_query($paramsBackward) . '" class="p-2 m-1 bg-gray-600 rounded-md">&lt;</a>
                    <a href="#" class="p-2 m-1 bg-gray-500 rounded-md"> ' . $page . '</a>
                    <a href="wallet.php?' . http_build_query($paramsForward) . '" class="p-2 m-1 bg-gray-600 rounded-md">&gt;</a>
                  </div>
                ';

            ?>
        </div>

        <div class="flex justify-center mt-4 mb-8">
            <button class="btn btn-primary rounded bg-red-600 px-2"> <a href="logout.php"> Logout </a> </button>
        </div>

</body>

</html>