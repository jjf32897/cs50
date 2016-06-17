<?php

    // configuration
    require("../includes/config.php"); 

    $rows = CS50::query("SELECT shares, symbol FROM portfolios WHERE user_id = ?", $_SESSION["id"]);
    $cash = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"])[0]["cash"];

    $positions = [];
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"]
            ];
        }
    }

    // renders the portfolio 
    render("portfolio.php", ["positions" => $positions, "fat_stacks" => $cash]);

?>
