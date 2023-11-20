<?php
require __DIR__ . '/header_script.php';
session_start();
require_once('connect.php');
verifySession();

if (isset($_POST['submitEdit'])) {
    $txID = isset($_POST["txId"]) ? $_POST["txId"] : null;
    $amount = isset($_POST["amount"]) ? abs($_POST["amount"]) : null;
    $method = isset($_POST["method"]) ? $_POST["method"] : null;
    $category = isset($_POST["category"]) ? $_POST["category"] : null;
    $methodID = isset($_POST["methodID"]) ? $_POST["methodID"] : null;
    $categoryID = isset($_POST["categoryID"]) ? $_POST["categoryID"] : null;


    $q = "  SELECT  amount, pm.method_name,  c.category_name, transaction_time, goal_name
            FROM transactions 
            JOIN payment_method pm USING (method_id)
            JOIN categories c USING (category_id)
            LEFT JOIN savings_goal sg USING (goal_id)
            WHERE transactions.uid = " . $_SESSION["uid"] . " ";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
</head>

<body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            handleSelection();
        });


        const disableGoal = () => {
            console.log('disable goal')
            var goal_select = document.getElementById('goal')
            var goal_label = document.getElementById('goalLabel')
            goal_select.disabled = true
            goal_select.value = -1
            goal_label.classList.add('line-through')
        }

        const enableGoal = () => {
            console.log('enable goal')
            var goal_select = document.getElementById('goal')
            var goal_label = document.getElementById('goalLabel')
            goal_select.disabled = false
            goal_label.classList.remove('line-through')
        }

        const setExpense = () => {
            var txType = document.getElementById('type')
            txType.value = "Expense"
        }

        const setIncome = () => {
            var txType = document.getElementById('type')
            txType.value = "Income"
        }

        const setSaveGoal = () => {
            var txType = document.getElementById('type')
            txType.value = "SaveGoal"
        }

        const handleSelection = () => {
            console.log('handled change')
            var selectedOption = document.getElementById("categories");
            var isExpense = selectedOption.options[selectedOption.selectedIndex].classList.contains("text-red-400");
            var isSaveGoal = selectedOption.options[selectedOption.selectedIndex].classList.contains("text-yellow-400");

            if (isExpense) {


                setExpense();
                selectedOption.classList.remove('text-gray-400')
                selectedOption.classList.remove('text-green-400')
                selectedOption.classList.remove('text-yellow-400')
                selectedOption.classList.add('text-red-400')
                disableGoal();

            } else if (isSaveGoal) {

                setSaveGoal();
                selectedOption.classList.remove('text-gray-400')
                selectedOption.classList.remove('text-green-400')
                selectedOption.classList.remove('text-red-400')
                selectedOption.classList.add('text-yellow-400')
                enableGoal();

            } else {

                setIncome();
                selectedOption.classList.remove('text-gray-400')
                selectedOption.classList.remove('text-red-400')
                selectedOption.classList.remove('text-yellow-400')
                selectedOption.classList.add('text-green-400')
                disableGoal();
            }
        }
    </script>

    <div class="ui">
        <!-- Title -->
        <div class="title-txt">
            <h1 class="mb-4 text-2xl"> Edit Transaction </h1>
        </div>

        <form action="./edit_tx_db.php" method="post">
            <div class="add-controls">
                <div class="px-2">
                    <label class="block">Amount (no minus sign)</label>
                    <input value="<?php echo $amount ?>" name="amount" type="number" min="1" step="any" class="search-box rounded text-gray-400 gray-bkg" placeholder="e.g. ฿500">
                </div>

                <div class="px-2">
                    <label class="block">Categories</label>
                    <select onchange="handleSelection()" name="category" id="categories" class="category-box rounded text-gray-400 gray-bkg">
                        <?php
                        echo '<option value=' . $categoryID . ' selected hidden>' . $category . '</option>';

                        $q = 'SELECT category_id, category_name, is_expense from categories ORDER BY is_expense ASC;';
                        if ($result = $mysqli->query($q)) {
                            while ($row = $result->fetch_assoc()) {
                                if ($row['is_expense'] == true) {

                                    if ($row['category_name'] == 'Transfer to savings goal') {
                                        echo '<option class="text-yellow-400" value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                                    } else {
                                        echo '<option class="text-red-400" value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option class="text-green-400" value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                                }
                            }
                        } else {
                            echo 'Query error: ' . $mysqli->error;
                        }
                        ?>
                    </select>
                </div>

                <div class="px-2">
                    <label class="block">Payment Method</label>
                    <select value="<?php echo $method ?>" name="method" id="method" class="category-box rounded text-gray-400 gray-bkg">
                        <?php
                        echo '<option value=' . $methodID . ' selected hidden>' . $method . '</option>';

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
                    <label id='goalLabel' class="block">Put into goal </label>
                    <select name="goal" id="goal" class="category-box rounded text-gray-400 gray-bkg">
                        <?php
                        $q = 'SELECT goal_id, goal_name from savings_goal WHERE uid = ' . $_SESSION["uid"] . ';';
                        if ($result = $mysqli->query($q)) {
                            echo '<option value="-1"> - </option>';
                            while ($row = $result->fetch_array()) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                            }
                        } else {
                            echo 'Query error: ' . $mysqli->error;
                        }
                        ?>
                    </select>
                </div>

                <div class="px-2 py-2">
                    <input type="hidden" name="type" id="type" value="Income">
                    <input type="hidden" name="txID" value="<?php echo $txID ?>">
                    <button type="submit" name="edit_tx_submit" class="btn bg-purple-600 px-2"> EDIT </button>
                    <button type="submit" name="delete_tx_submit" class="btn bg-purple-600 px-2"> DELETE </button>
                </div>
            </div>
        </form>
</body>