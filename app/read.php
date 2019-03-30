<?php
 /* ____  _____________   ______________
   / __ \/ ____/ ____/ | / / ____/_  __/
  / / / / /_  / /_  /  |/ / __/   / /   
 / /_/ / __/ / __/ / /|  / /___  / /    
 \____/_/   /_/   /_/ |_/_____/ /_/  */

//Matches incoming message to correct response class
function read() {
	//Check to see if JSON
	if ($_SESSION["json"]) {
		readJSON();
    } else {
        //Uses : tokens to split up text messages
        $split = explode(":", $_SESSION["Text"]);
        //Check to make sure message contains class name
        if (class_exists('\Apps\\'.$split[0])) {
            $class = ucfirst('\Apps\\'.$split[0]);
            $new = new $class();
            //Send Split up raw message to raw handler
            $response = $new->raw($split);
            Response::sendRaw($response);
        } else {
            //If nothing matches then send response error
            unlisted();
        }
    }
}

/*
 * Reads in JSON and data information to correct class
 *
 * Formating of the incoming JSON:
 * {
 *    "s": "weather", 
 *    "p": {
 *     "location": "Halifax NS"
 *    }
 * }
 * 
 * @param int    $to   Number to send to
 * @param string $json JSON String
 */
function readJSON() { 
	$json = json_decode(urldecode($_SESSION["Text"]));
	//Check to make sure service valid
	if (class_exists('\Apps\\'.$json->s)) {
		$class = ucfirst('\Apps\\'.$json->s);
		$new = new $class();
		//Passes "p" paramters to json handler
		$response = $new->json($json->p);
		Response::send($response);
	} else {
		//Catch Unlisted Error
		unlisted();
	}
}

//Invaild input reponse
function unlisted(){
	Response::send(Response::error($_SESSION["Text"]));
}


