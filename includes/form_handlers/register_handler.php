<?php

$fname = "";
$lname = "";
$em = "";
$em2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = array();
// isset sprawdza czy zmienna jest ustawiona i ma wartość inną niż null
// $_POST jest to tablica do której trafiają dane z formularza
if(isset($_POST['register_button'])) {
	$fname = strip_tags($_POST['reg_fname']); // usuwa tagi htmla i php (np </p>).
	$fname = str_replace(' ','',$fname); // zamienia ciąg znaków na inny - czyli spacja zostanie zastąpiona brakiem znaku bez spacji w zmiennej $fname
	$fname = ucfirst(strtolower($fname)); // strtolower - konwertuje cały string na małe litery, ucfisrt - zamienia 1-szy znak ciągu na dużą literę
	$_SESSION['reg_fname'] = $fname;

	$lname = strip_tags($_POST['reg_lname']);
	$lname = str_replace(' ','',$lname);
	$lname = ucfirst(strtolower($lname));
	$_SESSION['reg_lname'] = $lname;

	$em = strip_tags($_POST['reg_email']);
	$em = str_replace(' ','',$em);
	$_SESSION['reg_email'] = $em;

	$em2 = strip_tags($_POST['reg_email2']);
	$em2 = str_replace(' ','',$em2);
	$_SESSION['reg_email2'] = $em2;

	$password = strip_tags($_POST['reg_password']);
	$password2 = strip_tags($_POST['reg_password2']);

	$date = date("Y-m-d"); // obecna data

	// sprawdzenie poprawności e-maili
	if($em == $em2) {
		// sprawdza poprawność składni adresu e-mail
		// Funkcja filter_var () filtruje zmienną o określonym filtrze.
		// Filtr FILTER_VALIDATE_EMAIL sprawdza poprawność adresu e-mail.
		if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
			$em	= filter_var($em, FILTER_VALIDATE_EMAIL);
			$e_check = mysqli_query($con, "SELECT email from users WHERE email='$em'"); // sprawdzanie maila z tabeli users
			$num_rows = mysqli_num_rows($e_check); // Funkcja mysqli_num_rows() zwraca liczbę wierszy w zestawie wyników.
			// Zestawem wyników jest zmienna $e_check wyciągająca adres maila z bazy
			// Funkcja mysqli_query() wykonuje zapytanie do bazy danych.
			if($num_rows > 0) {
				array_push($error_array, "Taki adres email już istnieje.<br>");
			}

		} else {
			array_push($error_array, "Nieprawidłowa składnia adresu e-mail.<br>");
		}
	} else {
		array_push($error_array, "Adresy e-mail nie są identyczne.<br>");
	}
	if(strlen($fname) > 30 || strlen($fname) < 2) {
		array_push($error_array, "Imię musi posiadać od 2 do 30 znaków.<br>");
	}
	if(strlen($lname) > 30 || strlen($lname) < 2) {
		array_push($error_array, "Nazwisko musi posiadać od 2 do 30 znaków.<br>");
	}
	if($password != $password2) {
		array_push($error_array, "Hasła muszą się zgadzać.<br>");
	} else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Hasło może zawierać jedynie duże i małe litery (bez polskich znaków) oraz cyfry.<br>");
		}
	}
	if (strlen($password > 30 || strlen($password) < 5)) {
		array_push($error_array, "Hasło musi posiadać od 5 do 30 znaków.<br>");
		echo md5($_POST['reg_password']);
	}
	// empty sprawdza czy zmienna jest pusta
	// md5 szyfruje stringa na ciąg binarnych znaków
	if (empty($error_array)) {
		$password = md5($password);
		// generowanie nazwy usera przez konkatenację imienia i nazwiska
		$username = strtolower($fname . "_" . $lname); //strtolower - konwertuje cały string na małe litery
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'"); // sprawdzanie username z abeli users

		// jesli taki username istnieje dodajemy numerek do nazwy usera
		// Funkcja mysqli_num_rows() zwraca liczbę wierszy w zestawie wyników.
		// dopóki jest więcej niż 0 wierszy powiększamy i i sprawdzamy ponownie username w tabeli users w bazie
		$i = 0;
		while(mysqli_num_rows($check_username_query) !=0) {
			$i++;
			$username = $username . "_" . $i;
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
		}

		// domyślny obrazek profilowy (losujemy jeden z dwóch)
		$rand = rand(1,2);
		if($rand == 1) $profile_pic = "assets/images/profile_pictures/defaults/head_deep_blue.png";
		else if ($rand == 2) $profile_pic = "assets/images/profile_pictures/defaults/head_wisteria.png";

		//dodanie usera do bazy
		$query = mysqli_query($con, "INSERT INTO users VALUES ('',
															   '$fname',
															   '$lname',
															   '$username',
															   '$em',
															   '$password',
															   '$date',
															   '$profile_pic',
															   '0', '0', 'no', '') ");

		array_push($error_array, "<span style='color: #14C800;'>Udało ci się zarejestrować możesz teraz korzystać z portalu</span>");

		//czyszczenie zmiennych sesji
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
	}
}

?>
