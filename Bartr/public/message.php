<?php

    require("../includes/config.php"); 
    
    // if the user reached the page through a GET request, redirect them
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        redirect("/messages.php");
    }
    
    // if the user submitted the form...
    elseif ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["msg"]))
        {
            apologize("You can't send empty messages.");
        }
        
        // increments the number of responses on the offer only if a new user is messaging about the offer
        $offerer = getofferer($_POST["offer_id"]);
        
        // selects all messages that 
        $currentmsgs = CS50::query("SELECT id FROM messages WHERE offer_id = ? AND sender_id = ?", $_POST["offer_id"], $_SESSION["id"]);
        
        // if there are no messages from that user about this offer and the current
        // user (sending the message) isn't the offerer, the number of responses for that offer will increment by 1
        if (count($currentmsgs) == 0 && $offerer != $_SESSION["id"])
        {
            CS50::query("UPDATE offers SET responses = responses + 1 WHERE id=?", $_POST["offer_id"]);
        }
        
        // inserts the message into the database
        CS50::query("INSERT INTO messages (sender_id, recipient_id, content, offer_id) VALUES (?, ?, ?, ?)", $_SESSION["id"], $_POST["recipient"], $_POST["msg"], $_POST["offer_id"]);
        
        // will redirect to the Messages page
        redirect("/messages.php");
    }
?>