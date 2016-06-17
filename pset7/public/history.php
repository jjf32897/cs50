<?php

    // configuration
    require("../includes/config.php"); 

    // selects all of this user's transactions from the "history" table
    $transactions = CS50::query("SELECT * FROM history WHERE user_id = ?", $_SESSION["id"]);
    
    // if there are no transactions, a different page will load instead of the page with a table
    if (count($transactions) == 0)
    {
        render("blank_history.php");
    }
    else
    {
        render("history_view.php", ["transactions" => $transactions]);
    }
?>