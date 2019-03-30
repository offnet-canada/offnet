<?php
namespace Apps;

class Example {
	//Storing the params locally
	public $params;

	/*
	 * Function to handle Raw input requests
	 *
	 * Example of input
	 * array(
	 * [0] => "Hali"
	 * [1] => "Cali"
	 * )
	 *
	 * @param Array $arr String of params given
	 */
	public function raw($arr) {
		$this->params = $arr;
	}

	/*
	 * Function to handle JSON input requests
	 *
	 * Example of input
	 * array(
	 * "From" => "Halif"
	 * "To" => "Cali"
	 * )
	 *
	 * @param Array $param The param given in the input
	 */
	public function json($arr) {
		$this->params = $arr;
	}

	/*
	 * Function used to build response
	 */
	public function response() {
		return Response::builder($title, $body);
		//return Response:genericBuilder($params);
	}
}
