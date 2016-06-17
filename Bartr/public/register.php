<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        $schools = CS50::query("SELECT * FROM schools");
        if ($schools === false)
        {
            apologize("Oops! Something went wrong on our end. Please try again later.");
        }
        render("register_form.php", ["title" => "Register", "schools" => $schools]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // retrieves the email address URL of the submitted email
        $email_ext_num = strpos($_POST["email"], "@") + 1;
        
        // selects the correct email address URL of the school
        $email_ext = CS50::query("SELECT * FROM schools WHERE id=?", $_POST["inst"])[0]["email_address"];
        
        // checks to see if an email address was successfully found from the selected school
        if (count($email_ext) !== 1)
        {
            apologize("Oops! Something went wrong on our end. Please try again later.");
        }
        
        // checks to see if all fields were filled and if the passwords match
        if (empty($_POST["username"]) || empty($_POST["inst"]) || empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["emailconf"]) || empty($_POST["password"]) || empty($_POST["passconf"]))
        {
            apologize("Please fill out all fields!");
        }
        
        // checks if the passwords matched, the emails matched, and that the password/email fit their respective constraints
        else if (strlen($_POST["username"]) > 15)
        {
            apologize("Your username is too long.");
        }
        else if (preg_match('/\s/',$_POST["username"]) != 0)
        {
            apologize("Usernames cannot contain spaces.");
        }
        else if ($_POST["email"] != $_POST["emailconf"])
        {
            apologize("Emails didn't match.");
        }
        else if ($_POST["password"] != $_POST["passconf"])
        {
            apologize("Passwords didn't match.");
        }
        else if (strlen($_POST["password"]) > 20 || strlen($_POST["password"]) < 6)
        {
            apologize("Invalid password.");
        }
        
        // checks to see that the given email has an extension matching that of the school's
        else if ($email_ext_num === false || substr($_POST["email"], $email_ext_num) !== $email_ext)
        {
            apologize("That's an invalid e-mail address.");
        }
        else
        {
            // if insertion failed, then the username was taken
            $rows = CS50::query("INSERT IGNORE INTO users (username, school_id, email, password) VALUES(?, ?, ?, ?)", $_POST["username"], $_POST["inst"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT));
            
            if (count($rows) !== 1)
            {
                apologize("That username or email is already in use.");
            }
            
            // if not, then the current session is set to the new user's id
            else
            {
                $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
                if (count($rows) !== 1)
                {
                    apologize("Oops! Something went wrong on our end. Please try again later.");
                }
                $id = $rows[0]["id"];
                $_SESSION["id"] = $id;
                
                // the user is redirected to the current offers page
                redirect("/");
            }
        }
    }

?>