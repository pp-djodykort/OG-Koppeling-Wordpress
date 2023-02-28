<?php
// ========= Imports =========
include_once 'classes.php';

// ============ Functions ============
// HTML Functions
function htmlHeader($title) {
	echo("
	<div class='wrap text'>
		<img src='".plugins_url('img/pixelplus-logo.jpg', dirname(__DIR__, 1))."' alt='Pixelplus Logo' style='float: left; width: 75px;'>
		<h1 style='font-size: 2rem; float: right;'><b>".$title."</b></h1>
	</div>
		
		
	
	");
}

function htmlFooter($title) {
	echo("
	</div>
	");
}

// Database Functions
function connectToDB($dbHostname, $dbUsername, $dbPassword, $dbDatabase="") {
	// ======== Declaring Variables ========
	$dbPort = 3306;

	// ======== Start of Program ========
	try {
		$conn = new PDO( "mysql:host=[$dbHostname]; port=$dbPort; dbname=$dbDatabase", $dbUsername, $dbPassword ); // Create the actual connection
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	}
	catch ( PDOException $e ) {
		die( "Connection failed: " . $e->getMessage() );
	}
	return ($conn);
}