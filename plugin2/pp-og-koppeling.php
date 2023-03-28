<?php
/**
 * Plugin Name: Pixelplus - OG-Plugin
 * Plugin URI: https://pixelplus.nl/
 * Description: Plugin to help
 * Version: 0.1
 * Author: Pixelplus - Djody
 * Author URI: https://djody.nl/
 **/

// ========= Imports =========
include_once 'files/php/includes/classes.php';
include_once 'files/php/includes/functions.php';

// ============ Declaring Variables ============
$activateAndDeactivate = new OGActivationAndDeactivation();
$yes = new OGPostTypes();

$pages = new OGPages();

// ============ Start of Program ============
// Activation and Deactivation and Uninstall
register_activation_hook(__FILE__, array($activateAndDeactivate, 'activate'));
register_deactivation_hook(__FILE__, array($activateAndDeactivate, 'deactivate'));

