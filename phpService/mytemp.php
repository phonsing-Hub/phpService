#!/bin/php
<?php
//64028780
require('phpMQTT.php');


$server = 'localhost';     // change if necessary
$port = 1883;                     // change if necessary
$username = '';                   // set your username
$password = '';                   // set your password
$client_id = 'phpMQTT-subscriber'; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
if(!$mqtt->connect(true, NULL, $username, $password)) {
	exit(1);
}

// $mqtt->debug = true;

$topics['Temp'] = array('qos' => 0, 'function' => 'procMsg');
$mqtt->subscribe($topics, 0);

while($mqtt->proc()) {

}

$mqtt->close();

function procMsg($topic, $msg){
	 $logMessage = "[" . date('M d, Y - H:i:s') . "] Temp: " . $msg . "\n";
    // echo $logMessage; // Output to console (optional)

    // Append the log message to the log file
    $logFilePath = '/tmp/mytemp.log';
    file_put_contents($logFilePath, $logMessage, FILE_APPEND);
}