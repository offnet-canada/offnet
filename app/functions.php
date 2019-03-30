<?php
//Base Functions

/*
 * API Call Verifier
 *
 * @param int $uuid The UUID that is handed in the API call
 */
function verify($uuid) {
    //Check to make sure api call is vaild
    $p = new Phone();
    return $p->verify($uuid);
}

/*
 * Send Message
 *
 * @param int $to SMS number to send to
 * @param string $mess Message to respond with
 * @param string $ser  Service used
 */
function send($to, $mess, $ser = "Test") {
    //Send an SMS
    $p = new Phone();
    $p->send($to, $mess, $ser);
}


?>
