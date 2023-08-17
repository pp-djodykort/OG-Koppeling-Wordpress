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
    public static string $settingPrefix = 'ppOGSite_';
    public static string $cacheFolder;

    # Arrays
    private static array $arrPages = [
        // Page 1 - Homepage
        /* Page Title= */'Homepagina' => [
            # Main Information
            'pageID' => 'ppOGSync_homepage',
            'templateFile' => 'page-homepage.php',

            # Page Information
            'pageTitle' => 'Homepagina',
            'pageContent' => '',
            'pageSlug' => '',
            # Page Settings
            'boolIsFrontPage' => True,

            # Child Pages
            'childPages' => array()
        ],
        // Page 2 - Diensten
        /* Page Title= */'Diensten' => [
            # Main Information
            'pageID' => 'ppOGSync_diensten',
            'templateFile' => 'page-diensten.php',

            # Page Information
            'pageTitle' => 'Diensten',
            'pageContent' => '',
            'pageSlug' => 'diensten',
            # Page Settings
            'boolIsFrontPage' => False,

            # Child Pages
            'childPages' => array(
                // Child Page 1 - Verkoop
                /* Page Title= */'Verkoop' => [
                    # Main Information
                    'pageID' => 'ppOGSync_dienstenVerkoop',
                    'templateFile' => 'page-dienstenVerkoop.php',

                    # Page Information
                    'pageTitle' => 'Verkoop',
                    'pageContent' => '',
                    'pageSlug' => 'verkoop',
                    # Page Settings
                    'boolIsFrontPage' => False,
                ],
                // Child Page 2 - Aankoop
                /* Page Title= */'Aankoop' => [
                    # Main Information
                    'pageID' => 'ppOGSync_dienstenAankoop',
                    'templateFile' => 'page-dienstenAankoop.php',

                    # Page Information
                    'pageTitle' => 'Aankoop',
                    'pageContent' => '',
                    'pageSlug' => 'aankoop',
                    # Page Settings
                    'boolIsFrontPage' => False,
                ],
                // Child Page 3 - Taxatie
                /* Page Title= */'Taxatie' => [
                    # Main Information
                    'pageID' => 'ppOGSync_dienstenTaxatie',
                    'templateFile' => 'page-dienstenTaxatie.php',

                    # Page Information
                    'pageTitle' => 'Taxatie',
                    'pageContent' => '',
                    'pageSlug' => 'taxatie',
                    # Page Settings
                    'boolIsFrontPage' => False,
                ],
                // Child Page 4 - Zoekprofiel
                /* Page Title= */'Zoekprofiel' => [
                    # Main Information
                    'pageID' => 'ppOGSync_dienstenZoekprofiel',
                    'templateFile' => 'page-dienstenZoekprofiel.php',

                    # Page Information
                    'pageTitle' => 'Zoekprofiel',
                    'pageContent' => '',
                    'pageSlug' => 'zoekprofiel',
                    # Page Settings
                    'boolIsFrontPage' => False,
                ],
                // Child Page 5 - Hypotheek advies
                /* Page Title= */'Hypotheek advies' => [
                    # Main Information
                    'pageID' => 'ppOGSync_dienstenHypotheekAdvies',
                    'templateFile' => 'page-dienstenHypotheekAdvies.php',

                    # Page Information
                    'pageTitle' => 'Hypotheek advies',
                    'pageContent' => '',
                    'pageSlug' => 'hypotheek-advies',
                    # Page Settings
                    'boolIsFrontPage' => False,
                ],
            )
        ],
    ];

    // ============ Getters ============
    public static function arrPages(): array {
        return self::$arrPages;
    }

    // ============ Constructor ============
    public function __construct() {
        // ======== Declaring Variables ========
        # Vars
        self::$cacheFolder = plugin_dir_path(dirname(__DIR__)).'caches'.DIRECTORY_SEPARATOR;
    }
}