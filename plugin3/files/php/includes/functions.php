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