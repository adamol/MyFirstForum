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
    $titel = $content = "";

    if (!$_POST['titel']) {
        $titelError = "Please enter a titel <br>";
    }
    else {
        $titel = validateFormData($_POST['titel']);
    }

    if (!$_POST['content']) {
        $contentError = "Please enter some content <br>";
    }
    else {
        $content = validateFormData($_POST['content']);
    }

    if ($titel && $content) {
        $user = $_SESSION['loggedInUser'];
        $post_id = $_SESSION['postID'];
        $query = "INSERT INTO comments (post_id, comment_titel, comment_content, comment_user, comment_date) VALUES ('$post_id', '$titel', '$content', '$user', CURRENT_TIMESTAMP)";

        if (mysqli_query($conn, $query)) {
            echo"<div class='alert alert-success'>New record in database!</div>";
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
        <link rel="stylesheet" href="styles.css"
    </head>
    
    <body>
        <div class="container">
            <?php include('navbar.php'); ?>
            <h1>Post Page</h1>
            <p class="lead">This is post with id <?php echo $_GET['id']; ?>.</p> 


            <?php

                if (isset($_GET['id'])) {
                    include('connection.php');

                    $id     = $_GET['id'];
                    $query  = "SELECT titel, content FROM posts WHERE id=$id";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<h3>" . $row['titel'] . "</h3>";
                            echo "<p>" . $row['content'] . "</p>";
                        }
                    }
                } 
            ?>

            <?php

                if (isset($_GET['id'])) {
                    include('connection.php');

                    $id             = $_GET['id'];
                    $comments       = "SELECT comment_titel, comment_content FROM comments WHERE post_id=$id";
                    $commentresults = mysqli_query($conn, $comments);
        
                    if (mysqli_num_rows($commentresults) > 0) {
                        echo "hi";
                        while ($commentrow = mysqli_fetch_assoc($commentresults)) {
                            echo "<h3>" . $commentrow['comment_titel'] . "</h3>";
                            echo "<p>" . $commentrow['comment_content'] . "</p>";
                            echo "derp";
                        }
                    }
                }

            ?>      

            <!-- if logged in there should be a form to create post -->
            <?php
                if ($_SESSION['loggedInUser']) { 
                $_SESSION['postID'] = $_GET['id'];
            ?>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <legend>Reply to post</legend>
                            <div class="form-group">
                                <label for="post-titel" class="sr-only">Post titel</label>
                                <small class="text-danger">* <?php echo $titelError; ?></small>
                                <input type="text" class="form-control" id="post-titel" placeholder="Post titel" name="titel">
                            </div>

                            <div class="form-group">
                                <small class="text-danger">* <?php echo $contentError; ?></small>
                                <textarea class="form-control" rows="6" placeholder="Post content" name="content"></textarea>
                            </div>
                            <input type="submit" name="submit" value="Post">
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
        
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        
        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>