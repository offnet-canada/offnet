<?php
/* ____  _____________   ______________
  / __ \/ ____/ ____/ | / / ____/_  __/
 / / / / /_  / /_  /  |/ / __/   / /   
/ /_/ / __/ / __/ / /|  / /___  / /    
\____/_/   /_/   /_/ |_/_____/ /_/  */

namespace Apps;
class Wiki {
    public $keywords;

    public function raw($msg) {
        $this->keywords = $msg[1];
        return self::start()["text"];
    }

    public function json($json) {
        $this->keywords = $json->keywords;
        return \Response::genericBuilder(self::start()["json"]);
    }

    public function start() {
        $ch = curl_init();
        $keywords = urlencode($this->keywords);
        curl_setopt($ch, CURLOPT_URL, "https://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&titles=$keywords");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $buffer = curl_exec($ch);
        curl_close($ch);
        $j = json_decode($buffer,true);
        $body = $j["query"]["pages"];

        foreach ($body as $k) {
            $title = $k["title"];
            $body = $k["extract"];
        }
        $body = strip_tags($body);
        $m = $title . " :: " . $body;
        $json = array(
            "t" => $title,
            "b" => $body
        );

        if ($body == "") {
            send($this->to, "$keywords Is An Invaild Wiki Page");
            die;
        }
        return array("text"=>$m, "json"=>$json);
    }
}

