<?php
ob_start(); // włączenie buforowania wyjściowego
session_start();

$timezone = date_default_timezone_set("Europe/Warsaw");
// Funkcja date_default_timezone_set () ustawia domyślną strefę czasową używaną przez wszystkie funkcje daty / czasu w skrypcie.

$con = mysqli_connect("localhost","root","","social"); // nawiązywanie połączenia z bazą wymagane host,username,password,dbname
if(mysqli_connect_errno()) {
	echo "Nie udało się nawiązać połączenia z bazą danych: " . mysqli_connect_errno(); // zwraca kod błędu z ostatniego błędu połączenia, jeśli taki istnieje.
}

?>
