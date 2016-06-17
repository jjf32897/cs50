<?php

    // configuration
    require("../includes/config.php"); 

    // gets all currrent offers from the school of the current user
    $rows = CS50::query("SELECT * FROM offers WHERE school_id=?", getschoolid($_SESSION["id"]));
    
    // checks to see if the selection was successful
    if ($rows === false)
    {
        apologize("Oops! Something went wrong on our end. Please try again later.");
    }
    
    // fills an associate array with the offer information
    $offers = [];
    foreach ($rows as $row)
    {
        $offers[] = [
            "id" => $row["id"],
            "username" => getusername($row["user_id"]),
            "type" => $row["type"],
            "offer" => $row["offer"],
            "time" => $row["time"],
            "responses" => $row["responses"],
            "photo" => $row["photo"]
        ];
    }
    
    // reverse the array so the offers will show the most recent ones first
    $offers = array_reverse($offers);
    
    // the main page will be directed to view current offers, so index.php will render view_offers.php
    render("view_offers.php", ["title" => "Current Offers", "offers" => $offers]);

?>
