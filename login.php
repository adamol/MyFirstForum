<?php

if (isset($_POST['login'])) {
	// Function for validating data input into form
	function validateFormData($formData) {
		$formData = trim(stripslashes(htmlspecialchars($formData)));
		return $formData;
	}

	// Variables for the validated data
	$formUser = validateFormData($_POST['username']);
	$formPass = validateFormData($_POST['password']);

	// Connect to the database
	include('connection.php');

	// Query database for users with correct name
	$query = "SELECT username, password FROM users WHERE username='$formUser'";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) > 0) {
		// Store found user data into variables
		while ($row = mysqli_fetch_assoc($result)) {
			$user       = $row['username'];
			$hashedPass = $row['password'];
		}

		$testhash = password_hash($formPass, PASSWORD_DEFAULT);
		//if (password_verify($formPass, $hashedPass)) { // && $user == $formUser)) {
		if (password_verify($formPass, $testhash)) { 
			// Correct login details. Start sessions.
			session_start();

			// Store data in session varaibles
			$_SESSION['loggedInUser'] = $user;

			header("Location: index.php");
		}
		else { // Hashed password did not verify
			$loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
		}
	}
	else { // There are no results in database
		$loginError ="<div class='alert alert-danger'>No such user in databse. Try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
	}

	// Close the mysql connection
	mysqli_close($conn);

}

?>


<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

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
		<?php
    		include('navbar.php');
		?>

		<h1>Login</h1>
		<p class="lead">Use this form to log in to your account</p>

		<?php echo $loginError; ?>

		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

					<div class="form-group">
						<label for="login-username" class="sr-only">Username</label>
						<input type="text" class="form-control" id="login-username" placeholder="Username" name="username">
					</div>

					<div class="form-group">
						<label for="login-password" class="sr-only">Password</label>
						<input type="password" class="form-control" id="login-password" placeholder="Password" name="password">
					</div>

					<button type="submit" class="btn btn-danger" name="login">Login</button>
				</form>
			</div>
		</div>
	</div>


    <!-- jQuery -->
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>