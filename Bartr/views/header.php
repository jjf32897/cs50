<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>

        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>bartr: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>bartr</title>
        <?php endif ?>

        <!-- https://jquery.com/ -->
        <script src="/js/jquery-1.11.3.min.js"></script>

        <!-- http://getbootstrap.com/ -->
        <script src="/js/bootstrap.min.js"></script>

        <script src="/js/scripts.js"></script>
        
        <!--underlines the menu item that the user is currently on-->
        <script>
            $(document).ready(function() {
                var path = window.location.pathname;
                
                if (path == "/index.php" || path == "/")
                {
                    $("#index").css("text-decoration","underline");
                }
                else if (path == "/my_offers.php")
                {
                    $("#mine").css("text-decoration","underline");
                }
                else if (path == "/offer.php")
                {
                    $("#post").css("text-decoration","underline");
                }
                else if (path == "/messages.php")
                {
                    $("#messages").css("text-decoration","underline");
                }
                else if (path == "/transactions.php")
                {
                    $("#transactions").css("text-decoration", "underline");
                }
            });
        </script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <div>
                    <a href="/"><img alt="bartr" src="/img/logo.png"/></a>
                </div>
                <?php if (!empty($_SESSION["id"])): ?>
                    <ul class="nav nav-pills" id="menu">
                        <li id="index"><a href="index.php">Current Offers</a></li>
                        <li id="mine"><a href="my_offers.php">My Offers</a></li>
                        <li id="post"><a href="offer.php">Post Offer</a></li>
                        <li id="messages"><a href="messages.php">Messages</a></li>
                        <li id="transactions"><a href="transactions.php">Transactions</a></li>
                        <li><a href="logout.php"><strong>Log Out</strong></a></li>
                    </ul>
                    
                    <!--A friendly greeting-->
                    <h2>Hi, <?= getusername($_SESSION["id"]) ?></h2>
                <?php endif ?>
            </div>

            <div id="middle">
