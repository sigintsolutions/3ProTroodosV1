<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
</head>

<body>

<script>
var mqtt = require('mqtt');
var Topic = '#'; //subscribe to all topics
var Broker_URL = 'mqtt://mqtt.eurozapp.eu';
var Database_URL = 'localhost';

var options = {
	clientId: 'MyMQTT',
	port: 8084,
	username: 'siju',
	password: 'Sju0981',	
	keepalive : 60
};

var client  = mqtt.connect(Broker_URL, options);
client.on('connect', mqtt_connect);
client.on('reconnect', mqtt_reconnect);
client.on('error', mqtt_error);
client.on('message', mqtt_messsageReceived);
client.on('close', mqtt_close);

function mqtt_connect() {
    //console.log("Connecting MQTT");
    client.subscribe(Topic, mqtt_subscribe);
}

function mqtt_subscribe(err, granted) {
    console.log("Subscribed to " + Topic);
    if (err) {console.log(err);}
}

function mqtt_reconnect(err) {
    //console.log("Reconnect MQTT");
    //if (err) {console.log(err);}
	client  = mqtt.connect(Broker_URL, options);
}

function mqtt_error(err) {
    //console.log("Error!");
	//if (err) {console.log(err);}
}

function after_publish() {
	//do nothing
}

function mqtt_messsageReceived(topic, message, packet) {
	//console.log('Message received = ' + message);
	insert_message(topic, message, packet);
}

function mqtt_close() {
	//console.log("Close MQTT");
}

////////////////////////////////////////////////////
///////////////////// MYSQL ////////////////////////
////////////////////////////////////////////////////
var mysql = require('mysql');

//Create Connection
var connection = mysql.createConnection({
	host: Database_URL,
	user: "newuser",
	password: "mypassword",
	database: "mydb"
});

connection.connect(function(err) {
	if (err) throw err;
	//console.log("Database Connected!");
});

//insert a row into the tbl_messages table
function insert_message(topic, message, packet) {
	var clientID= "client001";
	var sql = "INSERT INTO ?? (??,??,??) VALUES (?,?,?)";
	var params = ['tbl_messages', 'clientID', 'topic', 'message', clientID, topic, message];
	sql = mysql.format(sql, params);	
	connection.query(sql, function (error, results) {
		if (error) throw error;
		console.log("1 record inserted");
	});
};
</script>
</body>
</html>
