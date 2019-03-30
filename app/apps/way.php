<?php
/* ____  _____________   ______________
  / __ \/ ____/ ____/ | / / ____/_  __/
 / / / / /_  / /_  /  |/ / __/   / /   
/ /_/ / __/ / __/ / /|  / /___  / /    
\____/_/   /_/   /_/ |_/_____/ /_/  */

namespace Apps;

class Directions { 
    public $start;
    public $finish;

    public function raw($msg) {
        $this->start = $msg[1];
        $this->finish = $msg[2];
        return self::start()["text"];
    }

    public function json($json) {
        $this->start = $json->from;
        $this->finish = $json->to;
        return \Response::genericBuilder(self::start()["json"]);
    }

    function start() {
        $start = $this->start;
        $finish = $this->finish;

        $ch = curl_init();
        $start = str_replace(" ", "+", $start);
        $finish = str_replace(" ", "+", $finish);
        curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/directions/json?origin=" . $start . "&destination=" . $finish . "&key=" . Core::ini('apps', 'way'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $buffer = curl_exec($ch);
        curl_close($ch);
        $j = json_decode($buffer,true);
        $s = $j['routes'][0]['legs'][0]['start_address'];
        $e = $j['routes'][0]['legs'][0]['end_address'];
        $j = $j['routes'][0]['legs'][0];
        $step = $j['steps'];

        $m = "";
        $json = array();
        $z = 0;
        foreach ($step as $k) {
            $z++;
            $k = $k["html_instructions"];
            $k = strip_tags($k);
            $m .=  " | " . $z . "." . $k . " ";
            $json[$z] = $k;
        }

        if ($m == "") {
            \Response::send(\Response::error("$start Is An Invaild Location"));
            die;
        }
        return array("text"=>$m, "json"=>$json);
    }
}
