<?php
class User {
    private $user;
    private $con;

    public function __construct($con, $user) {
        $this->con = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    } // konsruktor

    public function getUsername() {
        return $this->user['username'];
    } // funkcja zwracająca nazwę użytkownika

    public function getNumPosts() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['num_posts'];
    } // funkcja zwracająca liczbę postów

    public function getFirstAndLastName() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['first_name'] . " " . $row['last_name'];
    }// funckja zwracająca imię i nazwisko usera

    public function isClosed() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        if($row['user_closed'] == 'yes')
            return true;
        else
            return false;
    } // funkcja zwracająca true lub false w zależności czy user jest aktywny czy nie

    public function isFriend($username_to_check) {
        $usernameComma = "," . $username_to_check . ",";
        // Wyszukuje jednen lub wiele znaków w ciągu, po czym usuwa to co było, przed znalezionym rekordem, a wyświetla pozostałość, łącznie z szukanym znakiem.
        if((strstr($this->user['friend_array'], $usernameComma) || $username_to_check == $this->user['username'])) {
            return true;
        } else {
            return false;
        }

    }
}
?>
