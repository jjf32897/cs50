<?php

    /**
     * helpers.php
     *
     * Computer Science 50
     * Problem Set 7
     *
     * Helper functions.
     */

    require_once("config.php");

    /**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        render("apology.php", ["message" => $message]);
    }
    
    // gets the username given the ID of the user
    function getusername($id)
    {
        $username = CS50::query("SELECT username FROM users WHERE id=?", $id);
        if (count($username) !== 1)
        {
            apologize("Oops! Something went wrong on our end. Please try again later.");
        }
        return $username[0]["username"];
    }
    
    // gets the user's ID given the username
    function getuserID($username)
    {
        $id = CS50::query("SELECT id FROM users WHERE username=?", $username);
        if (count($id) !== 1)
        {
            apologize("Oops! Something went wrong on our end. Please try again later.");
        }
        return $id[0]["id"];
    }
    
    // retrieves messages about a specific offer between the current user and a specified user
    function getmessages($user_id, $offer_id)
    {
        if ($user_id != $_SESSION["id"])
        {
            $messages = CS50::query("SELECT sender_id, recipient_id, content, time FROM messages WHERE offer_id=? AND (sender_id = ? AND recipient_id = ?) OR (sender_id = ? AND recipient_id = ?)", $offer_id, $_SESSION["id"], $user_id, $user_id, $_SESSION["id"]);
        }
        else
        {
            $messages = CS50::query("SELECT sender_id, recipient_id, content, time FROM messages WHERE offer_id = ? AND sender_id = ?", $offer_id, $user_id);
        }
        
        return $messages;
    }
    
    // gets the user ID of the person who made the offer given the offer's ID
    function getofferer($offer_id)
    {
        $offerer = CS50::query("SELECT user_id FROM offers WHERE id=?", $offer_id);
        if (count($offerer) !== 1)
        {
            apologize("Oops! Something went wrong on our end. Please try again later.");
        }
        return $offerer[0]["user_id"];
    }
    
    // gets a list of all the people who responded to an offer
    function getresponders($offer_id)
    {
        $responders = CS50::query("SELECT DISTINCT sender_id FROM messages WHERE offer_id=? AND sender_id!=?", $offer_id, $_SESSION["id"]);
        return $responders;
    }
    
    // gets the item that was offered given the offer's ID
    function getoffer($offer_id)
    {
        $item = CS50::query("SELECT offer FROM offers WHERE id=?", $offer_id);
        if (count($item) !== 1)
        {
            apologize("Oops! Something went wrong on our end. Please try again later.");
        }
        
        return $item[0]["offer"];
    }
    
    // gets the ID of the offer given what the offer is and the user
    function getofferid($offer, $user)
    {
        $id = CS50::query("SELECT id FROM offers WHERE offer = ? AND user_id = ?", $offer, $user);
        if (count($id) !== 1)
        {
            apologize("Oops! Something went wrong on our end. Please try again later.");
        }
        
        return $id[0]["id"];
    }
    
    // gets the school ID for a specific user
    function getschoolid($id)
    {
        $school = CS50::query("SELECT school_id FROM users WHERE id=?", $id);
        if (count($school) !== 1)
        {
            apologize("Oops! Something went wrong on our end. Please try again later.");
        }
        
        return $school[0]["school_id"];
    }
    
    /**
     * Facilitates debugging by dumping contents of argument(s)
     * to browser.
     */
    function dump()
    {
        $arguments = func_get_args();
        require("../views/dump.php");
        exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    /**
     * Redirects user to location, which can be a URL or
     * a relative path on the local host.
     *
     * http://stackoverflow.com/a/25643550/5156190
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($location)
    {
        if (headers_sent($file, $line))
        {
            trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
        }
        header("Location: {$location}");
        exit;
    }

    /**
     * Renders view, passing in values.
     */
    function render($view, $values = [])
    {
        // if view exists, render it
        if (file_exists("../views/{$view}"))
        {
            // extract variables into local scope
            extract($values);

            // render view (between header and footer)
            require("../views/header.php");
            require("../views/{$view}");
            require("../views/footer.php");
            exit;
        }

        // else err
        else
        {
            trigger_error("Invalid view: {$view}", E_USER_ERROR);
        }
    }

?>
