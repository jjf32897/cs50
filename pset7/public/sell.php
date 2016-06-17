<?php

    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // passes only currently owned stocks to sell_form
        $stocks = CS50::query("SELECT symbol, shares FROM portfolios WHERE user_id = ?", $_SESSION["id"]);
        render("sell_form.php", ["stocks" => $stocks]);
    }

    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if a stock was selected, finds the current price of the stock and the
        // number of shares owned, deletes the stock from the portfolio, updates
        // the user's balance accordingly, and inserts the transaction into "history"
        if (!empty($_POST["stock"]))
        {
            $price = lookup($_POST["stock"])["price"];
            $shares = CS50::query("SELECT shares FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["stock"])[0]["shares"];
            CS50::query("DELETE FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["stock"]);
            CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $price * $shares, $_SESSION["id"]);
            CS50::query("INSERT INTO history (user_id, trans, symbol, shares, price) VALUES(?, ?, ?, ?, ?)", $_SESSION["id"], "SELL", $_POST["stock"], $shares, $price);
            redirect("/");
        }
        else
        {
            apologize("Select a stock to sell.");
        }
    }

?>