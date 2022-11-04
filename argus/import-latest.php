<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php /*?><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php */?><title>Untitled Document</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
<script src="https://www.npmjs.com/package/mqtt"></script>
</head>

<body>
</body>
<?php /*?><script>
// Create a client instance
client = new Paho.MQTT.Client('mqtt.eurozapp.eu', Number(8084), "clientId");

// set callback handlers
client.onConnectionLost = onConnectionLost;
client.onMessageArrived = onMessageArrived;

// connect the client
client.connect({onSuccess:onConnect});


// called when the client connects
function onConnect() {
  // Once a connection has been made, make a subscription and send a message.
  console.log("onConnect");
  client.subscribe("World");
  message = new Paho.MQTT.Message("Hello");
  message.destinationName = "World";
  client.send(message);
}

// called when the client loses its connection
function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
    console.log("onConnectionLost:"+responseObject.errorMessage);
  }
}

// called when a message arrives
function onMessageArrived(message) {
  console.log("onMessageArrived:"+message.payloadString);
}
</script><?php */?>
<?php /*?><script>
var mqtt = require('mqtt'), url = require('url');
// Parse
var mqtt_url = url.parse(process.env.CLOUDAMQP_MQTT_URL || 'mqtt.eurozapp.eu:1883');
var auth = (mqtt_url.auth || 'siju:Sju0981').split(':');
var url = "mqtt://" + mqtt_url.host;

//username: auth[0] + ":" + auth[0] if you are on a shared instance
var options = {
  port: mqtt_url.port,
  clientId: 'mqttjs_' + Math.random().toString(16).substr(2, 8),
  username: auth[0],
  password: auth[1],
};

// Create a client connection
var client = mqtt.connect(url, options);

client.on('connect', function() { // When connected

  // subscribe to a topic
  client.subscribe('hello/world', function() {
    // when a message arrives, do something with it
    client.on('message', function(topic, message, packet) {
      console.log("Received '" + message + "' on '" + topic + "'");
    });
  });

  // publish a message to a topic
  client.publish('hello/world', 'my message', function() {
    console.log("Message is published");
    client.end(); // Close the connection when published
  });
});
</script><?php */?>
<script>
var mqtt = require('mqtt'); //https://www.npmjs.com/package/mqtt
var Topic = '#'; //subscribe to all topics
var Broker_URL = 'mqtt://mqtt.eurozapp.eu';
var Database_URL = 'localhost';



var options = {
	clientId: 'MyMQTT',
	port: 1883,
	username: 'siju',
	password: 'Sju0981',	
	keepalive : 60
};

var client  = mqtt.connect(Broker_URL, options);
client.on('connect', mqtt_connect);
client.on('reconnect', mqtt_reconnect);
client.on('message', mqtt_messsageReceived);
client.on('close', mqtt_close);

function mqtt_connect() {
    console.log("Connecting MQTT");
    client.subscribe(Topic, mqtt_subscribe);
};

function mqtt_subscribe(err, granted) {
    console.log("Subscribed to " + Topic);
    if (err) {console.log(err);}
};

function mqtt_reconnect(err) {
    console.log("Reconnect MQTT");
    if (err) {console.log(err);}
	client  = mqtt.connect(Broker_URL, options);
};



function after_publish() {
	//do nothing
};

//receive a message from MQTT broker
function mqtt_messsageReceived(topic, message, packet) {
	var message_str = message.toString(); //convert byte array to string
	console.log("message to string", message_str);
	message_str = message_str.replace(/\n$/, ''); //remove new line
	//message_str = message_str.toString().split("|");
    console.log("message to params array",message_str);
	//payload syntax: clientID,topic,message
	if (message_str.length == 0) {
		console.log("Invalid payload");
		} else {	
		insert_message(topic, message_str, packet);
		//console.log(message_arr);
	}
};

function mqtt_close() {
	//console.log("Close MQTT");
};

////////////////////////////////////////////////////
///////////////////// MYSQL ////////////////////////
////////////////////////////////////////////////////
var mysql = require('mysql'); //https://www.npmjs.com/package/mysql
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
function insert_message(topic, message_str, packet) {
	var message_arr = extract_string(message_str); //split a string into an array
	var clientID= message_arr[0];
	var message = message_arr[1];
	var date= new Date();
	var sql = "INSERT INTO ?? (??,??,??,??) VALUES (?,?,?,?)";
	var params = ['tbl_messages', 'clientID', 'topic', 'message','date', clientID, topic, message, date];
	sql = mysql.format(sql, params);	
	
	connection.query(sql, function (error, results) {
		if (error) throw error;
		console.log("Message added: " + message_str);
	}); 
};	

//split a string into an array of substrings
function extract_string(message_str) {
	var message_arr = message_str.split(","); //convert to array	
	return message_arr;
};	

//count number of delimiters in a string
var delimiter = ",";
function countInstances(message_str) {
	var substrings = message_str.split(delimiter);
	return substrings.length - 1;
};
</script>
<?php /*?><script>
//var mqtt = require('mqtt');
var Topic = '#'; //subscribe to all topics
var Broker_URL = 'eurozapp.eu';
var Database_URL = 'localhost';

var options = {
	clientId: 'MyMQTT',
	port: 8084,
	username: 'siju',
	password: 'Sju0981',	
	keepalive : 60
};

//var client  = mqtt.eurozapp.eu;
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
</script><?php */?>
</html>
