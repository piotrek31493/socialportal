<?php
require 'config/config.php'; // zaczytanie innego pliku

if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
	//Funkcja mysqli_fetch_array () pobiera wiersz wyników jako tablicę asocjacyjną, tablicę liczbową lub obie.
} else {
	header("Location: register.php"); //Przekierowanie użytkownika pod dowolny adres
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Social Portal</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

<div class="top_bar">
	<div class="logo">
		<a href="index.php">Social Portal</a>
	</div>

	<nav>
		<a class="userName" href="<?php echo $userLoggedIn; ?>">
			<?php echo $user['first_name']; ?>
		</a>
		<a href="#">
			<i class="fas fa-home"></i>
		</a>
		<a href="#">
			<i class="fas fa-envelope"></i>
		</a>
		<a href="#">
			<i class="fas fa-bell"></i>
		</a>
		<a href="#">
			<i class="fas fa-users"></i>
		</a>
		<a href="#">
			<i class="fas fa-cog"></i>
		</a>
		<a href="includes/handlers/logout.php">
			<i class="fas fa-sign-out-alt" style="margin-right: 5px"></i>
		</a>
	</nav>
</div>

<div class="wrapper">
