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

// ============ Activation and Deactivation and Uninstall ============
$activateAndDeactivate = new OGActivationAndDeactivation();
register_activation_hook(__FILE__, array($activateAndDeactivate, 'activate'));
register_deactivation_hook(__FILE__, array($activateAndDeactivate, 'deactivate'));
register_uninstall_hook(__FILE__, 'OGUninstallPlugin');

// ============ Classes initialisation ============
// Data Class of the License
$license = new OGLicense();
// Loading in all the pages, menu's and sub-menu's
$pages = new OGPages();
// IF the license is activated, then load in the custom post types, and their respective sub-menu pages
if ($license->checkActivation()) {
    $postTypes = new OGPostTypes();
}

// ============ Start of Program ============
add_action('admin_notices', function() {
    echo(getLoadTime());

    // Making a new licensekey

});
