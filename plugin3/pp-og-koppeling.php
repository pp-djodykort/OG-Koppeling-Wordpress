<?php
/**
 * Plugin Name: Pixelplus - OG Koppeling
 * Plugin URI: https://pixelplus.nl/
 * Description: Plugin to help
 * Version: 0.1
 * Author: Pixelplus - Djody
 * Author URI: https://djody.nl/
 **/

// ========= Imports =========
include_once 'files/php/includes/classes.php';
include_once 'files/php/includes/functions.php';

// ============ Classes initialisation ============
$activateAndDeactivate = new OGActivationAndDeactivation();

// ============ Start of Program ============
// Activation and Deactivation and Uninstall
register_activation_hook(__FILE__, array($activateAndDeactivate, 'activate'));
register_deactivation_hook(__FILE__, array($activateAndDeactivate, 'deactivate'));
register_uninstall_hook(__FILE__, 'OGUninstallPlugin');