<?php
// ========= Imports =========
include_once 'classes.php';

// ============ Functions ============
// HTML Functions
function htmlHeader($title): void {
	echo("
	<head>
		<link rel='stylesheet' href='".plugins_url('css/bootstrap.min.css', dirname(__DIR__))."'>
	</head>

	<div class='container'>
		<div class='row show-grid'>
            <div class='col-md-8'>
            	<img src='".plugins_url('img/pixelplus-logo.jpg', dirname(__DIR__))."' alt='Pixelplus Logo' style='float: left; width: 75px;'>
				<h1 style='font-size: 2rem; float: left;'><b>$title</b></h1>
			</div>
  			<div class='col-md-4'>
  				<h2>Statistieken</h2>
			</div>
		</div>
	</div>
	");
}

function htmlFooter($title): void {
	echo("
	<!-- Bootstrap -->
	<script src='".plugins_url('js/bootstrap.min.js', dirname(__DIR__))."'></script>
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