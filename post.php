<?php
session_start();
include('connection.php');

if (isset($_POST['submit'])) {
    // Validate form data
    function validateFormData($formData) {
        $formdata = trim(stripslashes(htmlspecialchars($formData)));
        return $formData;
    }

    // Set all variables empty by default
    $content = "";

    if (!$_POST['content']) {
        $contentError = "Please enter some content <br>";
    }
    else {
        $content = validateFormData($_POST['content']);
    }

    $user = $_SESSION['loggedInUser'];
    if ($user && $content) {
        $post_id = $_SESSION['postID'];
        $query = "INSERT INTO comments (post_id, comment_content, comment_user, comment_date) VALUES ('$post_id', '$content', '$user', CURRENT_TIMESTAMP)";

        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success'>New record in database!</div>";
            header("Location: post.php" . "?id=" . $_SESSION['postID']);
        }
        else {
            echo "Error: " . $query ."<br>" . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>

<html>

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Post Page</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
        <title>my forum</title>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="styles.css">
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

            <?php

                if (isset($_GET['id'])) {
                    include('connection.php');

                    $id     = $_GET['id'];
                    $query  = "SELECT * FROM posts WHERE id=$id";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<h3>" . $row['titel'] . "</h3>";
                            echo "<p>" . $row['content'] . "</p>";
                            echo "<div class='clearfix'><small class='pull-right'>Posted by " . $row['user'] . " on " . $row['post_date'] . "</small></div>";
                            echo "<hr>";
                        }
                    }
                } 
            ?>

            <?php

                if (isset($_GET['id'])) {
                    include('connection.php');

                    $id             = $_GET['id'];
                    $comments       = "SELECT comment_content, comment_user FROM comments WHERE post_id=$id";
                    $commentresults = mysqli_query($conn, $comments);
        
                    if (mysqli_num_rows($commentresults) > 0) {
                        while ($commentrow = mysqli_fetch_assoc($commentresults)) {
                            echo "<div class='row'>";
                            echo "<div class='col-sm-2'>" . $commentrow['comment_user'] . "</div>";
                            echo "<div class='col-sm-10'>" . $commentrow['comment_content'] . "</div>";
                            echo "</div>";
                            echo "<hr>";
                        }
                    }
                }

            ?>      

            <!-- if logged in there should be a form to create post -->
            <?php
                if ($_SESSION['loggedInUser']) { 
                $_SESSION['postID'] = $_GET['id'];
            ?>
                
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <legend>Reply to post</legend>
                <div class="form-group">
                    <small class="text-danger"><?php echo $contentError; ?></small>
                    <textarea class="form-control" rows="6" placeholder="Comment content" name="content"></textarea>
                </div>
                <input type="submit" class="btn btn-default" name="submit" value="Comment">
            </form>
                 
            <?php } ?>
        </div>
        
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        
        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>