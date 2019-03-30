<?php
/*
 * Response class
 * Used to build and send responses
 */
class Response {
    /*
     * Main builder function
     *
     * @param string $title Title of response
     * @param string $body  Body of response
     */
    public static function builder($title, $body) {
        $response = array(
            "t" => $title,
            "b" => $body
        );
        $response = json_encode($response);
        $response = self::section(base64_encode($response));
        return $response; //Return Sectioned JSON
    }

    /*
     * Generic builder function
     *
     * @param array $params List of response params
     */
    public static function genericBuilder($params) {
        $response = $params;
        $response = json_encode($response);
        $response = self::section(base64_encode($response));
        return $response; //Return Sectioned JSON
    }

    /*
     * Error handler function
     *
     * @param string $message Error Message
     * @param int    $code    Error Code
     */
    public static function error($message, $code = "420") {
        if ($_SESSION["json"]) {
            //JSON Response
            $JSONresponse = array(
                "error" => $message,
            );
            if ($code) { 
                $JSONresponse["code"] = $code;
            }
            $response = json_encode($JSONresponse);
            $response = self::section(base64_encode($response));
        } else {
            //Raw Response
            $response = "Error ($code): $message";
            $response = self::section($response);
        }
        return $response; //Return Error Message
    }

    /*
     * Divide message into parts
     *
     * @param string $response
     * @param bool   $displayCount Option to disable count at start of text
     */
    public static function section($response, $displayCount = true) { 
        $response = utf8_encode($response);
        /* 737 (less then 737) is the max length for an SMS message
         * But we must also state the number the message is
         * ex.
         * 1/3:JSON.....
         */
        if (false) {
            $response = str_split($response, 731);
            //Adding count to divided message
            $count = count($response);
            $i = 1;
            foreach($response as $key => $f) {
                $response[$key] = $i . "/" . $count . ":" . $f;        
                $i++;
            }
        } else {
            $response = str_split($response, 736);
        }
        return $response;
    } 

    /*
     * Function used to convert JSON response to readable response
     *
     * @param array $response The build response from the Response class
     */
    public static function sendRaw($response) {
        //Start by checking to see if response is already a string
        if (is_string($response)) {
            $response = self::section($response, false);
        }
        //If Response is json array then simplfiy it
        //TODO finish this class
        self::send($response);
    }

    /*
     * Main send function
     * Determines to send to MMS or SMS
     *
     * @param array $response The build response from the Response class
     */
    public static function send($response) {
        if ($_SESSION["mms"]) {
            //MMS Reply
            $mms = new Email();
            $mms->send($response);
        } else {
            //SMS Reply
            $phone = new Phone();
            $phone->send($_SESSION["From"], $response); 
        }
    }
}
