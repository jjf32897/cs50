<?php

    require(__DIR__ . "/../includes/config.php");

    // error checking
    if (!isset($_GET["geo"]) || strlen($_GET["geo"]) === 0)
    {
        http_response_code(400);
        exit;
    }

    // numerically indexed array of places
    $places = [];
    
    $terms = count($_GET["geo"]);
    
    // makes the basis for a SQL command
    $statement = "SELECT * FROM places WHERE ";
    
    // if the input is numeric, it will be searched for as a zip code
    if (is_numeric($_GET["geo"]))
    {
        // concatenates the command to search for potential postal codes
        $statement .= 'postal_code LIKE "' . $_GET["geo"] . '%"';
    }
    
    else
    {
        // concatenates the command to search for location based on city, state,
        // and/or zip code
        $statement .= 'MATCH(place_name, admin_name1, postal_code) AGAINST ("' . $_GET["geo"] . '")';
    }
    
    // gets the first 20 rows returned
    $places = array_slice(CS50::query($statement), 0, 30);
    
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($places, JSON_PRETTY_PRINT));
?>