<?php
require 'config/config.php'; // zaczytanie innego pliku
require 'includes/form_handlers/register_handler.php'; // zaczytanie innego pliku
require 'includes/form_handlers/login_handler.php'; // zaczytanie innego pliku
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Witaj na Social Portal</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

	<?php
		if(isset($_POST['register_button'])) {
			echo '
			<script>
				$(document).ready(function() {
					$("#first").hide();
					$("#second").show();
				});
			</script>
			';
		}
	?>

<div class="wrapper">

	<div class="login_box">

		<div class="login_header">
			<h1>Social Portal</h1>
			Zaloguj się lub zarejestruj jeśli jeszcze nie masz konta.
		</div>

		<div id="first">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="email" name="log_email" placeholder="Adres e-mail" value="<?php
				if (isset($_SESSION['log_email'])) {
					echo $_SESSION['log_email'];
				}
				?>" required>
				<br>
				<input type="password" name="log_password" placeholder="Hasło" required>
				<br>
				<input type="submit" name="login_button" value="Zaloguj">

				<br> <?php if(in_array("Adres e-mail lub hasło są nieprawidłowe.<br>", $error_array)) echo "Adres e-mail lub hasło są nieprawidłowe.<br>"; ?>
				<div class="ani"><a href="#" id="signup" class="signup">Nie masz konta? Zarejetruj się</a></div>
			</form>
		</div>
		<div id="second">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="text" name="reg_fname" placeholder="Imię" value="<?php
				if (isset($_SESSION['reg_fname'])) {
					echo $_SESSION['reg_fname'];
				}
				?>" required>
				<br> <?php if(in_array("Imię musi posiadać od 2 do 30 znaków.<br>", $error_array)) echo "Imię musi posiadać od 2 do 30 znaków.<br>"; ?>

				<input type="text" name="reg_lname" placeholder="Nazwisko" value="<?php
				if (isset($_SESSION['reg_lname'])) {
					echo $_SESSION['reg_lname'];
				}
				?>" required>
				<br> <?php if(in_array("Nazwisko musi posiadać od 2 do 30 znaków.<br>", $error_array)) echo "Nazwisko musi posiadać od 2 do 30 znaków.<br>"; ?>

				<input type="email" name="reg_email" placeholder="Adres e-mail" value="<?php
				if (isset($_SESSION['reg_email'])) {
					echo $_SESSION['reg_email'];
				}
				?>" required>
				<br> <?php if(in_array("Taki adres email już istnieje.<br>", $error_array)) echo "Taki adres email już istnieje.<br>"; ?>

				<input type="email" name="reg_email2" placeholder="Powtórz adres e-mail" value="<?php
				if (isset($_SESSION['reg_email2'])) {
					echo $_SESSION['reg_email2'];
				}
				?>" required>

				<br> <?php if(in_array("Taki adres email już istnieje.<br>", $error_array)) echo "Taki adres email już istnieje";
					 if(in_array("Nieprawidłowa składnia adresu e-mail.<br>", $error_array)) echo "Nieprawidłowa składnia adresu e-mail.<br>";
				 	 if(in_array("Adresy e-mail nie są identyczne.<br>", $error_array)) echo "Adresy e-mail nie są identyczne.<br>"; ?>

				<input type="password" name="reg_password" placeholder="Hasło" required>
				<br>
				<input type="password" name="reg_password2" placeholder="Powtórz hasło" required>
				<br> <?php if(in_array("Hasła muszą się zgadzać.<br>", $error_array)) echo "Hasła muszą się zgadzać.<br>";
					 if(in_array("Hasło może zawierać jedynie duże i małe litery (bez polskich znaków) oraz cyfry.<br>", $error_array)) echo "Hasło może zawierać jedynie duże i małe litery (bez polskich znaków) oraz cyfry.<br>";
				 	 if(in_array("Hasło musi posiadać od 5 do 30 znaków.<br>", $error_array)) echo "Hasło musi posiadać od 5 do 30 znaków.<br>"; ?>

				<input type="submit" name="register_button" value="Rejestracja">
				<br> <?php if(in_array("<span style='color: #14C800;'>Udało ci się zarejestrować możesz teraz korzystać z portalu</span>", $error_array)) echo "<span style='color: #14C800;'>Udało ci się zarejestrować możesz teraz korzystać z portalu</span>"; ?>
				<div class="ani"><a href="#" id="signin" class="signin">Masz już konto? Zaloguj się</a></div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
