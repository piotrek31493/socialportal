<?php
class Post {
    private $user_obj;
    private $con;

    public function __construct($con, $user) {
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    } // user_obj to nowy obiekt klasy User

    public function submitPost($body, $user_to) { // funkcja publikująca post
        $body = strip_tags($body); // strip_tags usuwa znaki htmla z ciągu
        $body = mysqli_real_escape_string($this->con, $body); // wydobywa znaki specjalne tak żeby mozna było użyc w instrukcji SQL
        $check_empty = preg_replace('/\s+/', '', $body); // wyszukuje $subject(temat) pasującego do $patern(wzoru) i zastępuje je zmienną $replacement.

        if($check_empty != "") {
            // aktualne data i czas
            $date_added = date("Y-m-d H:i:s");
            $added_by = $this->user_obj->getUsername();

            if($user_to == $added_by) {
                $user_to = "none";
            }

            $query = mysqli_query($this->con, "INSERT INTO posts VALUES('',
                                                                        '$body',
                                                                        '$added_by',
                                                                        '$user_to',
                                                                        '$date_added',
                                                                        'no',
                                                                        'no',
                                                                        '0')"); // dodajemy post do bazy
           //Funkcja mysqli_insert_id () zwraca identyfikator (wygenerowany przy pomocy AUTO_INCREMENT) użyty w ostatnim zapytaniu.
           $returned_id = mysqli_insert_id($this->con);

           $num_posts = $this->user_obj->getNumPosts();
           $num_posts++;
           $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
           // zwiekszanie liczy postów
       }
    }

    public function loadPostFriends() {
        $str = "";
        $data = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC"); // DESC sortowanie w porządku malejącym

        while($row = mysqli_fetch_array($data)) {
            $id = $row['id'];
            $body = $row['body'];
            $added_by = $row['added_by'];
            $date_time = $row['date_added'];

            if($row['user_to'] == "none") {
                $user_to = "";
            } else {
                $user_to_obj = new User($con, $row['user_to']);
                $user_to_name = $user_to_obj->getFirstAndLastName();
                $user_to = "to <a href='" . $row['user_to'] ."'>" . $user_to_name . "</a>";
            }

            $added_by_obj = new User($this->con, $added_by);
            if($added_by_obj->isClosed()) {
                continue;
            }

            $userLoggedIn = $this->user_obj->getUsername();
            $user_logged_obj = New User($this->con, $userLoggedIn);
            if($user_logged_obj->isFriend($added_by)) {

                $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                $user_row = mysqli_fetch_array($user_details_query);
                $first_name = $user_row['first_name'];
                $last_name = $user_row['last_name'];
                $profile_pic = $user_row['profile_pic'];

                $date_time_now = date("Y-m-d H:i:s");
                $start_date = new DateTime($date_time); // czas Posta
                $end_date = new DateTime($date_time_now); // obecny czas
                $interval = $start_date->diff($end_date); // rożnica pomiędzy datami
                if($interval->y >= 1) {
                    if($interval == 1) {
                        $time_message = $interval->y . " rok temu";
                    } else if ($interval == 2 || $interval == 3 || $interval == 4) {
                        $time_message = $interval->y . " lata temu";
                    } else {
                        $time_message = $interval->y . " lat temu"; }
                } else if($interval->m >= 1) {
                    if($interval->d == 0) {
                        $days = " temu";
                    } else if ($interval->d == 1) {
                        $days = $interval->d . " dzień temu";
                    } else {
                        $days = $interval->d . " dni temu";
                    }
                    if($interval->m == 1) {
                        $time_message = $interval->m . " miesiąc". $days;
                    } else if($interval->m == 2 || $interval->m == 3 || $interval->m == 4) {
                        $time_message = $interval->m . " miesiące". $days;
                    } else {
                        $time_message = $interval->m . " miesięcy". $days;
                    }

                } else if ($interval->d >= 1) {
                    if ($interval->d == 1) {
                       $time_message = "wczoraj";
                   } else {
                       $time_message = $interval->d . " dni temu";
                   }
                }
                else if($interval->h >= 1) {
                    if($interval->h == 1) {
                        $time_message = $interval->h . " godzinę temu";
                    } else if($interval->h == 2 || $interval->h == 3 || $interval->h == 4) {
                        $time_message = $interval->h . " godziny temu";
                    } else {
                        $time_message = $interval->h . " godzin temu";
                    }
                }
                else if($interval->i >= 1) {
                    if($interval->i == 1) {
                        $time_message = $interval->i . " minutę temu";
                    } else if($interval->i == 2 || $interval->i == 3 || $interval->i == 4) {
                        $time_message = $interval->i . " minuty temu";
                    } else {
                        $time_message = $interval->i . " minut temu";
                    }
                }
                else {
                    if($interval->s == 1) {
                        $time_message = $interval->s . " sekundę temu";
                    } else if($interval->s == 2 || $interval->s == 3 || $interval->s == 4) {
                        $time_message = $interval->s . " sekundy temu";
                    } else {
                        $time_message = $interval->s . " sekund temu";
                    }
                }


                $str .= "<div class='status_post'>
    								<div class='post_profile_pic'>
    									<img src='$profile_pic' width='50'>
    								</div>

    								<div class='posted_by' style='color:#acacac;'>
    									<a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
    								</div>
    								<div id='post_body'>
    									$body
    									<br>
    								</div>

    							</div>
    							<hr>";
            }
        }
        echo $str;
    }
}
?>
