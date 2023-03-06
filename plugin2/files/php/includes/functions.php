<?php
// ========= Imports =========
include_once 'classes.php';

// ============ Functions ============
// HTML Functions
function htmlHeader($title): void {
	echo("
	<head>
		<link rel='stylesheet' href='".plugins_url('css/bootstrap.min.css', dirname(__DIR__))."'>
		<link rel='stylesheet' href='".plugins_url('css/style.css', dirname(__DIR__))."'>
	</head>
	<header>
		<div class='container-fluid'>
			<!-- Having the logo and title next to each other -->
			<img width='75px' src='".plugins_url('img/pixelplus-logo.jpg', dirname(__DIR__))."' alt='Pixelplus Logo' style='float: left;'>
		
			<h1 style=''><b>$title</b></h1>
			
		</div>
	</header>
	");
}

function htmlFooter($title): void {
	echo("
	<!-- Bootstrap -->
	<script src='".plugins_url('js/bootstrap.min.js', dirname(__DIR__))."'></script>
	</div>
	");
}

function welcomeMessage(): void {
	$welcomeMessage = "Welcome";
	$wpUser = _wp_get_current_user();

	if ($wpUser->user_firstname != "") {
		$welcomeMessage .= " " . $wpUser->user_firstname;
	}
	else {
		$welcomeMessage .= " " . $wpUser->user_login;
	}
	echo("<p>$welcomeMessage</p>");
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