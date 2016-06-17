<?php

    // configuration
    require("../includes/config.php");
    
    // selects all transactions for the user
    $transactions = CS50::query("SELECT * FROM transactions WHERE offerer_id = ? OR confirmed_id = ?", $_SESSION["id"], $_SESSION["id"]);
    
    // checks to see if the selection was successful
    if ($transactions === false)
    {
        apologize("Oops! Something went wrong on our end. Please try again later.");
    }
    
    // renders the transactions page
    render("transactions.php", ["title" => "Transactions", "transactions" => $transactions]);  
    
?>