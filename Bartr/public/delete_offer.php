<?php

    require("../includes/config.php");
    
    // if no offer ID was sent, prompt an error message
    if (empty($_GET["offer_id"]))
    {
        http_response_code(400);
        exit;
    }
    
    // find the photo file name from the database and if there is one, delete it from the directory
    $photo = CS50::query("SELECT photo FROM offers WHERE id=?", $_GET["offer_id"])[0]["photo"];
    
    if ($photo != "")
    {
        unlink("uploads/" . $photo);
    }
    
    // delete all messages related to the offer and the offer itself
    CS50::query("DELETE FROM messages WHERE offer_id=?", $_GET["offer_id"]);
    CS50::query("DELETE FROM offers WHERE id=?", $_GET["offer_id"]);
    
    // redirect to my offers
    redirect("/my_offers.php");
    
?>