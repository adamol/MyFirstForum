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
        $query = "INSERT INTO posts (id, titel, content, user, post_date) VALUES (NULL, '$titel', '$content', '$user', CURRENT_TIMESTAMP)";

        if (mysqli_query($conn, $query)) {
            echo"<div class='alert alert-success'>New record in database!</div>";

            // For some reason redirecting afterward results form it seems
            // So if I refresh page I don't get a second post
            header("Location: index.php");
        }
        else {
            echo "Error: " . $query ."<br>" . mysqli_error($conn);
        }
    }

}

mysqli_close($conn);
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Small, simple and lightweight forum system write in PHP" />
        <meta name="author" content="">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
        <title>my forum</title>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>

    <div class="container">
    
<?php
    include('navbar.php');
?>

        <div class="header">
            <div class="jumbotron">
                <h1>This is my forum</h1>
                <p class="lead">It is light weight and easy to use.</p>
            </div>
        </div>

        <!-- List of recent forum posts -->
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Topic</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            include('connection.php');
                            $query = "SELECT * FROM posts";
                            $result = mysqli_query( $conn, $query );

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['user'] . "</td>";
                                    echo "<td>" . $row['titel'] . "</td>";
                                    echo "<td><form action='post.php' method='get'><a href='post.php'><button class='btn btn-default pull-right' value='" . $row['id'] . "' name='id'>Read post &raquo;</button></a></form></td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- if $_SESSION['email'] there should be a form to create post -->
        <?php if ($_SESSION['loggedInUser']) { ?>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <legend>Create new topic</legend>
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


        <!-- some kind of error handling -->

        <footer class="footer">
            <?php
                if ($_SESSION['loggedInUser']) {
                    echo "You are currently logged in.";
                }
                else {
                    echo "You are currently not logged in.";
                }
            ?>
        </footer>

    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    </body>

</html>