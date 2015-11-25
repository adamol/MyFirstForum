<?php

include('connection.php');

if (isset($_POST['submit'])) {
	// Validate form data
	function validateFormData($formData) {
		$formdata = trim(stripslashes(htmlspecialchars($formData)));
		return $formData;
	}

	// Set all variables empty by default
	$username = $password = "";

	if (!$_POST['username']) {
		$nameError = "Please enter a username <br>";
	}
	else {
		$username = validateFormData($_POST['username']);
	}

	if (!$_POST['password']) {
		$passwordError = "Please enter a password <br>";
	}
	else {
		$password   = validateFormData($_POST['password']);
		$hashedPass = password_hash($password, PASSWORD_DEFAULT);
	}

	if ($username && $hashedPass) {
		$query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPass')";
		//$query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

		if (mysqli_query($conn, $query)) {
			echo"<div class='alert alert-success'>New record in database!</div>";
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

	<title>Register</title>

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
		                <li class="active"><a href="register.php">Register</a></li>
		            <?php } ?>
		        </ul>
		    </nav>
		    <h3 class="text-muted"><a href="/">My Forum</a></h3>
		</div>
		

		<h1>Register</h1>
		<p class="lead">Use this form to register for an account.</p>
		<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

			<div class="form-group">
				<label for="username" class="sr-only">Username</label>
				<small class="text-danger"><?php echo $nameError; ?></small>
				<input type="text" class="form-control" id="username" placeholder="Username" name="username">
			</div>

			<div class="form-group">
				<label for="password" class="sr-only">Password</label>
				<small class="text-danger"><?php echo $passwordError; ?></small>
				<input type="password" class="form-control" id="password" placeholder="Password" name="password">
			</div>

			<button type="submit" class="btn btn-default" name="submit">Register</button>
		</form>


	</div>

	<!-- jQuery -->
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>