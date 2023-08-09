<?php
// ========== Imports =========
include_once 'functions.php';

// ========== Activation and Deactivation and Uninstall ============
class OGSiteActivationAndDeactivation {
    // ==== Activation ====
    public static function activate() {

    }
    // ==== Deactivation ====
    public static function deactivate() {

    }
    // ==== Uninstall ====
    public static function uninstall() {

    }

    // ==== Functions ====
    private function registerSettings() {

    }
}

// ========= Data Classes =========
class OGSiteSettingsData {
    // ============ Declare Variables ============
    # Strings
    public static $settingPrefix = 'ppOGSite_';
    public static $cacheFolder;


    // ============ Constructor ============
    public function __construct() {
        // ======== Declaring Variables ========
        # Vars
        self::$cacheFolder = plugin_dir_path(__FILE__).'cache'.DIRECTORY_SEPARATOR;
        OGSiteTools::adminNotice('info', self::$cacheFolder);
    }
}