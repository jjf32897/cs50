<?php

    // configuration
    require("../includes/config.php"); 
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("search_stock.php");
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // checks if a symbol was entered
        if (empty($_POST["symbol"]))
        {
            apologize("Please enter a stock symbol.");
        }
        
        // looks up the stock
        $stock = lookup($_POST["symbol"]);
        
        // checks if the stock doesn't exist
        if (!$stock)
        {
            apologize("Invalid stock symbol.");
        }
        
        // if it does, pass the information to display_stock
        else
        {
            render("display_stock.php", ["name" => $stock["name"], "symbol" => $stock["symbol"], "price" => $stock["price"]]);
        }
    }
?>