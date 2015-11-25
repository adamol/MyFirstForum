<?php

if (isset($_COOKIE[session_name()])) {
    // Empty the cookie
    setcookie(session_name(), '', time()-86400, '/');

    // Clear all session variables
    session_unset();

    // Destroy the sessions
    session_destroy();
}

?>


<!DOCTYPE html>

<html>

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Profile Page</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
        <title>my forum</title>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="styles.css"
    </head>
    
    <body>
        <div class="container col-sm-6 col-sm-offset-3">
            <div class="navbar">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <li><a href="index.php">Home</a></li>
                        <?php if($_SESSION['loggedInUser']) { ?>
                            <li><a href="logout.php">Logout</a></li>
                        <?php } else { ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <h3 class="text-muted"><a href="/">My Forum</a></h3>
            </div>
            
            <h1>Logged out</h1>
            <p class="lead">You've been logged out. See you next time.</p>
        </div>
        
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        
        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>