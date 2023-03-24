<?php
// ========== Imports =========
include_once 'functions.php';

// ==== Data Classes ====
class OGBaseData {
    public $settingPrefix = 'ppOG_';
    public $settings = [
        /* Setting Name */'licenseKey' => /* Default Value */'',
    ];
}

// ==== Activation and Deactivation (Uninstallation is in the functions.php because it needs to be a static function) ====
class OGActivationAndDeactivation {
	// ======== Activation ========
	function activate() {
        $this->registerSettings();
	}
	// ======== Deactivation ========
	function deactivate()
	{

	}

	// ============ Functions ============
    // A function for registering base settings of the unactivated plugin as activation hook.
    function registerSettings() {
        // ==== Declaring Variables ====
        $settingData = new OGBaseData();

        // ==== Start of Function ====
        // Registering settings
        foreach ($settingData->settings as $settingName => $settingValue) {
            add_option($settingData->settingPrefix.$settingName, $settingValue);
        }
    }
}


// ========== Inactivated state of Plugin ==========
class