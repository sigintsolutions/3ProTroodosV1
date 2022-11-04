<?php

require("../phpMQTT.php");


$server = "mqtt.eurozapp.eu";     // change if necessary
$port = 8084;                     // change if necessary
$username = "siju";                   // set your username
$password = "Sju0981";                   // set your password
$client_id = "phpMQTT-subscriber".uniqid(); // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new phpMQTT($server, $port, $client_id);

if(!$mqtt->connect(true, NULL, $username, $password)) {
	exit(1);
}

$topics['bluerhinos/phpMQTT/examples/publishtest'] = array("qos" => 0, "function" => "procmsg");
$mqtt->subscribe($topics, 0);

while($mqtt->proc()){
		
}


$mqtt->close();

function procmsg($topic, $msg){
		echo "Msg Recieved: " . date("r") . "\n";
		echo "Topic: {$topic}\n\n";
		echo "\t$msg\n\n";
}
