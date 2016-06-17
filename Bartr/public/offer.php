<?php

    // configuration
    require("../includes/config.php");
    
    // if accessed via a GET request, render the form
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("new_post.php", ["title" => "New Post"]);   
    }
    
    // if the form was submitted...
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if any of the mandatory fields were left blank, apologize
        if (empty($_POST["item"]) || empty($_POST["type"]))
        {
            apologize("Fill out all required fields!");
        }
        
        // checks to see if an offer with the same description has been posted by the user
        $existing = CS50::query("SELECT id FROM offers WHERE user_id = ? AND offer = ?", $_SESSION["id"], $_POST["item"]);
        if (count($existing) != 0)
        {
            apologize("Oops! Looks like you've already posted an offer for that.");
        }
        
        // if the offer description is too long, reject it
        if (strlen($_POST["item"]) > 80)
        {
            apologize("Oops! That post is a little long.");
        }
        
        // if there is no photo uploaded, simply add the offer to the database with an empty string as the photo parameter
        if (empty($_FILES["fileToUpload"]["tmp_name"]))
        {
            CS50::query("INSERT INTO offers (school_id, user_id, type, offer, photo) VALUES (?, ?, ?, ?, ?)", getschoolid($_SESSION["id"]), $_SESSION["id"], $_POST["type"], $_POST["item"], "");
            redirect("/my_offers.php");
        }
        else
        {
            // make a directory for the uploaded photo
            $target_dir = "uploads/";
            $target_file = $target_dir . preg_replace('/\s+/', '', basename($_FILES["fileToUpload"]["name"]));
            $uploadOk = 1;
            
            // get the file type of the uploaded file
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            
            // gets the image size
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            
            // if there is actually a file
            if($check === false)
            {
                apologize("Oops! There was an error while uploading the image.");
            }
            
            // sets a buffer for the file extension and a number for the file name appendage in the case the file name already exists
            $buffer = 0;
            $i = 0;
            
            // if the file name already exists in the directory, an extension is added to the name
            while (file_exists($target_file))
            {
                $ext_pos = strrpos($target_file, ".");
                
                // if this isn't the first iteration of the while loop, set buffer to 2
                if ($i != 0)
                {
                    $buffer = 2;
                }
                
                // if the buffer is 2, the existing extension placed by the loop ("_i") will be replaced
                $target_file = substr($target_file, 0, $ext_pos - $buffer) . "_" . $i . substr($target_file, $ext_pos);
                
                // try a new number to add on every time
                $i++;
            }
            
            // if the file is larger than 500 kb, reject it
            if ($_FILES["fileToUpload"]["size"] > 500000)
            {
                apologize("That file is too big. Please keep the size below 500 kB.");
            }
            
            // if the file is not of a certain image format, reject it
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
            {
                apologize("Please upload only JPGs, PNGs, JPEGs, or GIFs");
            }
            
            // if uploadOk is 0, then some condition was not met
            if ($uploadOk == 1)
            {
                if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
                {
                    apologize("Oops! There was an error while uploading the image.");
                }
            }
            
            // inserts the offer with the location of the photo in the directory
            CS50::query("INSERT INTO offers (school_id, user_id, type, offer, photo) VALUES (?, ?, ?, ?, ?)", getschoolid($_SESSION["id"]), $_SESSION["id"], $_POST["type"], $_POST["item"], substr($target_file, strpos($target_file, "/") + 1));
            redirect("/my_offers.php");
        }
    }
    
?>