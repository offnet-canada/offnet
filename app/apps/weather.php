<?php
/* ____  _____________   ______________
  / __ \/ ____/ ____/ | / / ____/_  __/
 / / / / /_  / /_  /  |/ / __/   / /   
/ /_/ / __/ / __/ / /|  / /___  / /    
\____/_/   /_/   /_/ |_/_____/ /_/  */

namespace Apps;
class Weather {
    public $location;

    public function raw($msg) {
        $this->location = $msg[1];
        return self::start()["text"];
    }

    public function json($json) {
        $this->location = $json->location;
        return \Response::genericBuilder(self::start()["json"]);
    }

    function start() {
        $location = $this->location;
        // Get lat and long by address
        $address = $location;
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;

        if ($phpObj['query']['results'] == null) { //ERROR
            \Response::send(\Response::error("Invaild Location"));
            die();
        } else {
            $date = $phpObj['query']['results']['channel']['lastBuildDate'];
            $title = $phpObj['query']['results']['channel']['item']['title'];
            $current =  "CURRENTLY:\n" . a($phpObj['query']['results']['channel']['item']['condition']['temp']) . "C and " . $phpObj['query']['results']['channel']['item']['condition']['text'];
            $forecast = $phpObj['query']['results']['channel']['item']['forecast'];
            $cast = "";
            //JSON
            $json = array();
            $json["d"] = $date;
            $json["t"] = $title;
            $json["c"] = array(
                "t" =>  a($phpObj['query']['results']['channel']['item']['condition']['temp']),
                "c" =>  $phpObj['query']['results']['channel']['item']['condition']['text']
            );
            $i = 1;
            foreach ($forecast as $for) {
                $day = $for['day'];
                $high = a($for['high']);
                $low = a($for['low']);
                $con = $for['text'];
                $cast .= "\n(" . $day . ")" . " High of:" . $high . "C Low of:" . $low . "C And " . $con . "";
                //JSON
                $json["f"][$i] = array(
                    "d" => $day,
                    "h" => $high,
                    "l" => $low,
                    "c" => $con
                );
                $i++;
            }
            $date = substr($date, 0, -12);
            $text = "[" . $date . " " . $title . "] " .  $current . "\nFORECAST:" . $cast;
            return array("text"=>$text, "json"=>$json);
        }

    }
}
?>
