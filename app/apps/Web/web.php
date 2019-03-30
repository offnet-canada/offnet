<?php
/* ____  _____________   ______________
  / __ \/ ____/ ____/ | / / ____/_  __/
 / / / / /_  / /_  /  |/ / __/   / /   
/ /_/ / __/ / __/ / /|  / /___  / /    
\____/_/   /_/   /_/ |_/_____/ /_/  */

namespace Apps;
require "../../../thirdparty/simple_html_dom.php";

class Http {
	public $url;

    public function raw($msg) {
        $this->url = implode(":", $msg);
        return self::start();
    }

    public function json($json) {
        $this->url = $json->url;
        return \Response::builder("text", self::start());
    }

	function start() {
		$url = $this->url;
		$opts = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: en\r\n" .
				"Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
				"User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
			)
		);

		$context = stream_context_create($opts);
		$buffer = file_get_html($url, false, $context);

		#title
		foreach($buffer->find('title') as $element) {
			$title = strip_tags($element->innertext . '<br>');
		}

		#description
		foreach($buffer->find('meta') as $element) {
			if($element->name == "description") {
				#		echo $element->content;
			}
		}

		#body 
		foreach($buffer->find('div') as $element) {
			$one = $element->innertext;
		}

		$gud = $buffer->plaintext; 
		$gud =  html_entity_decode($gud);	
		$good = preg_replace('/\s+/', ' ', $gud);
		$striped = strip_tags($good);
		$short = substr($striped, 0, 1000);
		if($title) {
			$ready = $title . ": " . $short;
		} else {
			$ready = $short;
		}

		return $ready;
	}
}
