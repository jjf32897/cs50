<?php

    require("../includes/config.php");
    
    // get all offers made by the current user
    $offers = CS50::query("SELECT * FROM offers WHERE user_id=?", $_SESSION["id"]);
    
    // renders the My Offers page with these offers
    render("my_offers.php", ["title" => "My Offers", "my_offers" => $offers])
    
?>