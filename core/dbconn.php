<?php
//Basic sql database functions
$name = Core::ini("database", "name");
$password = Core::ini("database", "pass");
$mysqli = mysqli_connect("localhost", $name, $password, "accounts");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

