<?php
/* ____  _____________   ______________
  / __ \/ ____/ ____/ | / / ____/_  __/
 / / / / /_  / /_  /  |/ / __/   / /   
/ /_/ / __/ / __/ / /|  / /___  / /    
\____/_/   /_/   /_/ |_/_____/ /_/  */

namespace Apps;

class Define {
	public $word;

    public function raw($msg) {
        $this->word = $msg[1];
        return self::start();
    }

    public function json($json) {
        $this->word = $json->word;
        $response = array(
            "d" => self::start()
        );
        return \Response::genericBuilder($response); 
    }

	function start(){
		$word = $this->word;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://services.aonaware.com/DictService/DictService.asmx/Define?word=" . $word);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$buffer = curl_exec($ch);
		curl_close($ch);
		$j = simplexml_load_string($buffer);
		$m= $j->Definitions->Definition->WordDefinition;
		$m = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $m)));

		$word = strtoupper($word);
		if ($m == "") {
            \Response::send(\Response::error("$word Is An Invaild Word"));
			die();
        }
        return $m;
	}
}
