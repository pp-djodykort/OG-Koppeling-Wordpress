<?php
// ========= Security =========
if (!defined('ABSPATH')) {
	die('Not allowed');
}

// ========= Plugin Info =========
/**
 * Plugin Name: Pixelplus - OG Aanbod Koppeling
 * Plugin URI: https://pixelplus.nl/
 * Description: Plugin to help
 * Version: 0.1
 * Author: Djody Kort
 * Author URI: https://djody.nl/
 **/

// ========= Imports =========
include_once 'files'.DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'classes.php';
include_once 'files'.DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'functions.php';

// ============ Activation and Deactivation and Uninstall ============
register_activation_hook(__FILE__, 'OGSyncActivationAndDeactivation::activate');
register_deactivation_hook(__FILE__, 'OGSyncActivationAndDeactivation::deactivate');
register_uninstall_hook(__FILE__, 'OGSyncActivationAndDeactivation::uninstall');

// ============ Classes initialisation ============
// Data Class of the License
$license = new OGSyncLicense();
// IF the license is activated, then load in the custom post types, and their respective sub-menu pages
if ($license->checkActivation()) {
    $postTypes = new OGSyncPostTypes();
}
$pages = new OGSyncPages();

// ============ Start of Program ============
add_action('admin_notices', function () {
	echo OGSyncTools::getLoadTime();
});