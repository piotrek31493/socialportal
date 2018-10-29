<?php
if(isset($_POST['login_button'])) {
    // Funkcja filter_var () filtruje zmienną o określonym filtrze.
    //Filtr FILTER_SANITIZE_EMAIL usuwa wszystkie niedozwolone znaki z adresu e-mail.
     $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);
     $_SESSION['log_email'] = $email;
     $password = md5($_POST['log_password']);

     $check_database_query =  mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
     // SELECT * = SELECT all
     // Funkcja mysqli_num_rows() zwraca liczbę wierszy w zestawie wyników.
     $check_login_query = mysqli_num_rows($check_database_query);

     if($check_login_query == 1) {
         $row = mysqli_fetch_array($check_database_query);
         //Funkcja mysqli_fetch_array () pobiera wiersz wyników jako tablicę asocjacyjną, tablicę liczbową lub obie.
         $username = $row['username'];

         $user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
         if(mysqli_num_rows($user_closed_query) == 1) {
             $reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
             //Instrukcja UPDATE służy do modyfikowania istniejących rekordów w tabeli.
         }

         $_SESSION['username'] = $username;
         header("Location: index.php"); //Przekierowanie użytkownika pod dowolny adres
         exit();
     } else {
         array_push($error_array, "Adres e-mail lub hasło są nieprawidłowe.<br>");
     }
}
?>