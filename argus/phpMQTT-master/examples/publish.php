<?php

require("../phpMQTT.php");

$server = "mqtt.eurozapp.eu";     // change if necessary
$port = 8084;                     // change if necessary
$username = "siju";                   // set your username
$password = "Sju0981";                   // set your password
$client_id = "phpMQTT-publisher".uniqid(); // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new phpMQTT($server, $port, $client_id);

if ($mqtt->connect(true, NULL, $username, $password)) {
	$mqtt->publish("bluerhinos/phpMQTT/examples/publishtest", "Hello World! at " . date("r"), 0);
	$mqtt->close();
} else {
    echo "Time out!\n";
}
