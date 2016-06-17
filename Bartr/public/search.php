<?php

    // configuration
    require("../includes/config.php"); 
    
    if (empty($_POST["search"]))
    {
        redirect("/");
    }
    
    // gets all currrent offers from the school of the current user that are LIKE the search term
    $rows = CS50::query("SELECT * FROM offers WHERE school_id=? AND offer LIKE ?", getschoolid($_SESSION["id"]), "%" . $_POST["search"] . "%");
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
    
    $offers = array_reverse($offers);
    
    // will render the Current Offers page with offers related to the search term
    render("view_offers.php", ["title" => "Current Offers", "offers" => $offers]);

?>