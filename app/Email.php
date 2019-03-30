<?php
/*
 * Classes used for MMS
 * TODO Add Logging
 */
class Email {
    function __construct(){

    }

    public function send($response) {
        //Grabing required Info
        require "../core/dbconn.php";
        $from = mysqli_real_escape_string($mysqli, $_SESSION['From']);
        $query = "select * from trial_users where phonenumber='$from'";
        $result = $mysqli->query($query);
        $result->data_seek(0);
        //Checking the last service used
        while ($row = $result->fetch_assoc()) {
            $to = $row['mms'];
            $username = $row['username'];
        }
        $data = implode(" ", $response);
        
        mailer($data, "Offnet Info", $to, $username);
        die();
    }
} 
