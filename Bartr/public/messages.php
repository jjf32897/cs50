<?php

    require("../includes/config.php"); 
    
    // CS50::query("SELECT id FROM messages WHERE "); 
    
    // finds all messages sent to the user and checks to see if the selection was successful
    $convos = CS50::query("SELECT DISTINCT sender_id, offer_id FROM messages WHERE recipient_id = ?", $_SESSION["id"]);
    if ($convos === false)
    {
        apologize("Oops! Something went wrong on our end. Please try again later.");
    }
    
    // lines 18 - 49 add on any first messages about an offer that have been sent by the user
    // this is so the user will also be able to see which offers they have responded to even if they haven't received a response
    
    // fills an array with all offer IDs from the original queries
    $ids = [];
    foreach ($convos as $convo)
    {
        $ids[] = $convo["offer_id"];
    }
    
    // retrieves all messages sent by the current user
    $sentbyme = CS50::query("SELECT DISTINCT sender_id, offer_id FROM messages WHERE sender_id = ?", $_SESSION["id"]);
    
    if ($sentbyme === false)
    {
        apologize("Oops! Something went wrong on our end. Please try again later.");
    }
    
    // for each message sent by the user, checks whether they have received a response about the respective offer.
    // If not, the message is added to the list of messages as well
    foreach ($sentbyme as $convo)
    {
        $i = 1;
        foreach ($ids as $id)
        {
            if ($convo["offer_id"] == $id)
            {
                $i = 0;
                break;
            }
        }
        if ($i == 1)
        {
            $convos[] = $convo;
        }
    }
    
    // renders the messages page
    render("view_messages.php", ["title" => "Messages", "messages" => $convos]);
    
?>