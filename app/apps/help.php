<?php
namespace Apps;

class Help {
	public $mess;

	public function raw($msg) {
		$this->mess = $msg[1];
		return self::start();
	}

	public function json($json) {
		$this->mess = $json->number;
		return \Response::genericBuilder(self::start());
	}

	public function start() {
		$option = $this->mess;

		switch($option) {
		case "1":
			$mess = "Weather, 'weather:location' ex 'weather:halifax ns'";
			break;
		case "2":
			$mess = "Dictionary, 'define:word' ex 'define:bike'";
			break;
		case "3":
			$mess = "Directions, 'From:location To:location' ex 'From:Halifax, NS To:Sydney, NS'";
			break;
		case "4":
			$mess = "Wikipedia, 'wiki:title' ex 'wiki:meme'";
			break;
		case "5":
			$mess = "Twitter, Posting A Tweet:'Twitter:Tweet:Message' Reading Feed: 'Twitter:Feed:'";
			break;
		case "6":
			$mess = "Details on source 'help:#' 8.CNN 9.CBC 10.BBC";
			break;	
		case "7":
			$mess = "Any Website, 'http://<url>' ex 'http://example.com'";
			break;	
		case "8":
			$mess = "CNN, 'News:CNN:type:story#' Types:World,Money,Science,Sports,Art,Tech,Recent";
			break;	
		case "9":
			$mess = "CBC, 'News:CBC:type:story#' Types:World,Money,Canada,Politics,Art,Tech,Sport,Hockey,Nova Scotia";
			break;
		case "10":
			$mess = "BBC, 'News:BBC:type:story#' Types:World,Money,Canada,Politics,Art,Tech,Health,Science,Mid East";	
			break;
		default:
			$mess = "For Details 'help:#' 1.Weather 2.Dictionary 3.Directions 4.Wikipedia 5.Twitter 6.News 7.Any Website";
			break;	
		}
		return $mess;
	}
}
