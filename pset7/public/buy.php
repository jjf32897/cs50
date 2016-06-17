<?php

    // configuration
    require("../includes/config.php"); 
    
    // if reached via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("buy_form.php");
    }
    
    // if reached via POST (form submission)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // checks for empty fields, valid stock symbol/share number, if it's affordable
        if (empty($_POST["symbol"]))
        {
            apologize("You must enter a stock symbol.");
        }
        else if (empty($_POST["shares"]))
        {
            apologize("You must enter a desired number of shares.");
        }
        
        $stock = lookup($_POST["symbol"]);
        
        if (!$stock)
        {
            apologize("Invalid stock symbol.");
        }
        else if (!preg_match("/^\d+$/", $_POST["shares"]))
        {
            apologize("Invalid number of shares.");
        }
        
        // calculates the stock and compares it to the current account balance
        $cost = $stock["price"] * $_POST["shares"];
        $balance = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"])[0]["cash"];
        
        if ($cost >= $balance)
        {
            apologize("You cannot afford that :(");
        }
        
        // reduces cash by appropriate amount, inserts (or updates) the new shares into the user's portfolio, and inserts the transaction into "history"
        else
        {
            CS50::query("UPDATE users SET cash = cash - ? WHERE id = ?", $cost, $_SESSION["id"]);
            CS50::query("INSERT INTO portfolios (user_id, symbol, shares) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $stock["symbol"], $_POST["shares"]);
            CS50::query("INSERT INTO history (user_id, trans, symbol, shares, price) VALUES(?, ?, ?, ?, ?)", $_SESSION["id"], "BUY", $stock["symbol"], $_POST["shares"], $stock["price"]);
            redirect("/");
        }
    }
?>