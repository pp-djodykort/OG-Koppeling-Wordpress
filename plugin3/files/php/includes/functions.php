<?php
// ========= Imports =========
include_once 'classes.php';

// ============ Functions ============
// Uninstallation of the plugin
function OGUninstallPlugin() {
    // ================ Start of Function ================
    // ======== Deleting Settings/Options ========
    // Check which settings are registered
    $OGoptions = wp_load_alloptions();

    // only get settings that start with ppOG_
    $OGoptions = array_filter($OGoptions, function($key) {
        return strpos($key, 'ppOG_') === 0;
    }, ARRAY_FILTER_USE_KEY);

    // Deleting all settings
    foreach ($OGoptions as $option => $value) {
        delete_option($option);
    }

    // ======== Deleting Custom Post Types ========

}

// ============ HTML Functions ============
function htmlHeader($title): void {
    echo("
	<head>
		<link rel='stylesheet' href='".plugins_url('css/bootstrap.min.css', dirname(__DIR__))."'>
		<link rel='stylesheet' href='".plugins_url('css/style.css', dirname(__DIR__))."'>
	</head>
	<header>
		<div class='container-fluid'>
			<!-- Having the logo and title next to each other -->
			<img src='".plugins_url('img/pixelplus-logo.jpg', dirname(__DIR__))."' alt='Pixelplus Logo'>
		
            <div class='div-Header'>
                <span class='floatLeft'><h1><b>$title</b></h1></span>
                <span class='floatRight'><h5>".welcomeMessage()."</h5></span>
            </div>
	</header>
	<hr/>
	");
}

function htmlFooter($title): void {
    // Getting the expiration date of the license

    echo("
	<!-- Bootstrap -->
	<script src='".plugins_url('js/bootstrap.min.js', dirname(__DIR__))."'></script>
	</div>
	");
}

function welcomeMessage(): string {
    $welcomeMessage = "Welkom";
    $wpUser = _wp_get_current_user();

    if ($wpUser->user_firstname != "") {
        $welcomeMessage .= " ".$wpUser->user_firstname;
    }
    else {
        $welcomeMessage .= " ".$wpUser->user_login;
    }
    return $welcomeMessage;
}

// ============ Normal Functions ============
function getLoadTime(): string {
    // tell me how much time this took
    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    return "This page took $time seconds to load.";
}