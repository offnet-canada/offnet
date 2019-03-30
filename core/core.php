<?php
/*
 * Main System Functions
 *
 */

//Check if copy is a dev copy
if (Core::ini('system', 'debug') == true) {
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(-1);
} else {
	error_reporting(0);
}
//Escape a string for database input
function escape($mysqli, $s) {
	return mysqli_real_escape_string($mysqli, $s);
}
//Die and output data
function derp($a) {
	var_dump($a);
	die();
}
//Connect to database
function db($db) {
	$name = Core::ini("database", "name");
	$password = Core::ini("database", "pass");
	$mysqli = mysqli_connect("localhost", $name, $password, $db);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	return $mysqli;
}

//Core Class
class Core {
    //Config file to be read
	public $ini_file;

	//Read Ini File
	public static function ini($address, $id) {
		$ini_file = parse_ini_file("/home/offnet/public_html/offnet/config/system.ini", true);
		return $ini_file[$address][$id];
	}
}
