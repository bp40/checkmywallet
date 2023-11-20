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
      echo '<h1 class="mb-4 text-2xl"> Check My Wallet Plz : Viewing Goals of ' . $_SESSION["username"] . '</h1>'
      ?>
    </div>

    <div>
      <button class="btn btn-primary rounded bg-purple-600 px-2"> <a href="wallet.php">Back to Wallet</a> </button>
      <button class="btn btn-primary rounded bg-purple-600 px-2"><a href="add_goals.php">Add new Goal</a> </button>
    </div>

    <div class="flex flex-col w-2/3 justify-evenly">
      <?php
      $q = "SELECT * FROM savings_goal WHERE uid = " . $_SESSION["uid"] . ";";
      if ($result = $mysqli->query($q)) {

        if (mysqli_num_rows($result) == 0) {
          echo "<div>You currently have no savings goals!</div>";
        }

        while ($row = $result->fetch_assoc()) {

          echo '
                    <div class="w-100 bg-gray-800 rounded overflow-hidden shadow-lg m-4">
                    <div class="flex justify-between items-center px-6 py-3">
                      <div class="font-bold text-lg">' . htmlspecialchars($row['goal_name']) . '</div>
                      <form action="./edit_goal.php" method="post">
                        <input type="hidden" name="goal_id" value="' . $row['goal_id'] . '"/>
                        <input type="hidden" name="goal_name" value="' . htmlspecialchars($row['goal_name']) . '"/>
                         <input type="hidden" name="goal_amount" value="' . $row['goal_amount'] . '"/>
                         <input type="hidden" name="goal_date" value="' . $row['goal_date'] . '"/>
                        <button type="submit" name="edit_goal_submit" class="text-blue-500 hover:text-blue-700 focus:outline-none">Edit</button>
                      </form>
                    </div>
                    <div class="px-6 py-2">
                      <p class="text-gray-400 text-base">
                        Saving for <span class="text-green-500 font-bold">' . $row["goal_amount"] . '</span> by <span class="text-blue-500 font-bold">' . $row["goal_date"] . '</span>.
                      </p>
                    </div>
                    <div class="px-6 py-2">
                      <div class="flex items-center">
                        <div class="text-sm">
                          <p class="text-gray-400">Current Amount</p>
                          <p class="text-gray-500 font-bold">' . $row["current_amount"] . '</p>
                        </div>
                        <div class="ml-auto text-sm">
                          <p class="text-gray-400">Remaining</p>
                          <p class="text-gray-500 font-bold">' . $row["goal_amount"] - $row["current_amount"] . '</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  ';
        }
      }
      ?>
    </div>
  </div>
</body>

</html>