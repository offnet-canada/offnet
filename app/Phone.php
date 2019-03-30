<?php
/*
 * Main Phone Class
 * Current Provider: Plivo
 */

//Current Provider SDK
require '../thirdparty/plivo-php/vendor/autoload.php';
use Plivo\RestAPI;

class Phone {
    //Plivo Rest Api Class
    public $p;

    function __construct() {
        //Plivo Auth Tokens
        $auth_id = Core::ini('pilvo', 'id');
        $auth_token = Core::ini('pilvo', 'token');
        $this->p = new RestAPI($auth_id, $auth_token);
    }

    //Verify UUID
    function verify($uuid) {
        $params = array('record_id' => $uuid);
        $response = $this->p->get_message($params);

        if ($response['status'] == 200) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Send SMS Function
     * @param int    $to   The number to send to
     * @param string $mess Message to send
     * @param string $ser  The type of message ex. "Error"
     */
    function send($to, $mess, $ser = "Test", $verify = false) {
        //Message details
        foreach ($mess as $i) {
            $params[] = array(
                'src' => '+12893233234', # Sender's phone number
                'dst' => $to,
                'text' =>  $i //Must be under 1600 Bytes
            );
        }

        //For Logging
        $strResponse = "";
        foreach($params as $i) {
            $strResponse .= $i['text'];
        }

        //Dev Testing
        if (Core::ini('system','debug')) {
            $date = date_create();
            $time = date_timestamp_get($date);
            foreach($params as $i) {
                echo($i['text']);
                echo "<br>";
            }
            //LOG
            \MessageLog::create(\Account::getId($to), $_SESSION["Text"], $strResponse, "DEV-TEST");
            die(); //Don't send sms
        }

        //Sending the split up message
        foreach($params as $i) {
            //Sending the message
            $response = $this->p->send_message($i);
            $uuid = $response['response']['message_uuid'][0];
            $params = array(
                'record_id' => $uuid // The Message UUID
            );

            //Getting information on the sent message
            $response = $this->p->get_message($params);

            //SUBSCRIPTION
            //Deducting Credits
            $credit = $response['response']['units'];
            \Subscription::useSub(\Account::getId($to), $credit);
        }

        //LOG MESSAGE
        \MessageLog::create(\Account::getId($to), $_SESSION["Text"], $strResponse, "SMS");
    }

    /*
     * Send Code
     * 
     * Used to send verificaiton code
     * 
     * @param int $to   Phone Number
     * @param int $code Verification Code
     */
    function sendCode($to, $code) {
        $message = "Your Verification Code: $code";
        $sms = array(
            'src' => '+12893233234', # Sender's phone number
            'dst' => $to,
            'text' =>  $message //Must be under 1600 Bytes
        );
        //Sending the message
        $response = $this->p->send_message($sms);
    }
}
