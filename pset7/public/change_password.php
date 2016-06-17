<?php

    // configuration
    require("../includes/config.php"); 
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("password_form.php");
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // gets the old password
        $hash = CS50::query("SELECT hash FROM users WHERE id = ?", $_SESSION["id"])[0]["hash"];
        
        // checks if any fields are blank, if the confirmation password matches, and if the old password was correct
        if (empty($_POST["old"]))
        {
            apologize("You must enter your old password.");
        }
        else if (empty($_POST["new"]))
        {
            apologize("You must enter a new password.");
        }
        else if (empty($_POST["new_confirm"]))
        {
            apologize("You must confirm your new password.");
        }
        else if ($_POST["new"] != $_POST["new_confirm"])
        {
            apologize("Your passwords do not match.");
        }
        else if (!password_verify($_POST["old"], $hash))
        {
            apologize("Incorrect password.");
        }
        
        // if all conditions were passed, then the hash in users is changed to the hashed new password
        else
        {
            CS50::query("UPDATE users SET hash = ? WHERE id = ?", password_hash($_POST["new"], PASSWORD_DEFAULT), $_SESSION["id"]);
            redirect("/");
        }
        
    }
?>