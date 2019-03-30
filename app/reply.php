<?php
/* ____  _____________   ______________
  / __ \/ ____/ ____/ | / / ____/_  __/
 / / / / /_  / /_  /  |/ / __/   / /   
/ /_/ / __/ / __/ / /|  / /___  / /    
\____/_/   /_/   /_/ |_/_____/ /_/  
Author: Cooper Gagnon 
 */

/* Pulling Get Headers */ 
$to = $_REQUEST["From"];
$text = $_REQUEST["Text"];
$UUID = $_REQUEST['MessageUUID'];

/* Session Starts */
session_start();
//Record Basic Incoming Info
$_SESSION["From"] = $to;
$_SESSION["Text"] = $text;
$_SESSION["UUID"] = $UUID;

//JSON Check
$json = json_decode(urldecode($text));
$_SESSION["json"] = (json_last_error() == JSON_ERROR_NONE);

//Check for MMS setting
if ($_SESSION["json"]) {
    $_SESSION["mms"] = ($json->mms);
} else {
    $_SESSION["mms"] = false;
}
//Initialize other files
require "init.php";
//1. VERIFIY
if (Core::ini('system', 'debug')) {
    error_reporting(-1);
    ini_set('display_errors', 'On');
    //Check to debuging mode
} elseif (isset($to) && isset($text) && verify($UUID)) {
    //Check to make sure UUID is valid
} else {
    session_unset();
    session_destroy();
    die;
}

//Clean input
$to = mysqli_real_escape_string($mysqli, $to);
$text = mysqli_real_escape_string($mysqli, $text); 

$accountId = \Account::getId($to);

//2. CREATE ACCOUNT IF NEW
if (!$accountId) {
    \Account::create($to);
    $accountId = \Account::getId($to);
}

//3. SPAM CHECK
//Get number of messages in past minute
$messageCount = \MessageLog::countLogs($accountId);
$limit = Core::ini('system', 'limit'); 
//If number of messages sent passes the limit
//Drop the request
if ($messageCount >= $limit) {
    //TODO Error
    head();
    die();
}

//4. SUBSCRIPTION CHECK
//Check to see if user has a subscription
//Check to see if user has credit
$credit = \Subscription::getCredit($accountId);

if ($credit === false) {
    //TODO Error
    //User doesn't have a subscription
    head();
    die();
} else if ($credit <= 0) {
    //Out of credit
    //Disable Subscription
    \Subscription::disable($accountId);
    Response::send(Response::error("Sorry you have run out of credits", "000"));
} else {
    //Has credit
    //5. READ
    read();
}

/* Stoping Double Sending */
head();
function head() {
    header("HTTP/1.1 200 OK");
    echo "200 OK";
}
?>
