<?php
// ========== Imports =========
include_once 'functions.php';

// ========== Activation and Deactivation and Uninstall ============
class OGSiteActivationAndDeactivation {
    // ==== Activation ====
    public static function activate() {
        self::registerSettings();
        self::createCacheFiles();
    }
    // ==== Deactivation ====
    public static function deactivate() {

    }
    // ==== Uninstall ====
    public static function uninstall() {
        // ================ Start of Function ================
        // ======== Deleting Settings/Options ========
        // Check which settings are registered
        $OGoptions = wp_load_alloptions();

        // only get settings that start with ppOGSync_
        $OGoptions = array_filter($OGoptions, function($key) {
            return str_starts_with($key, OGSiteSettingsData::$settingPrefix);
        }, ARRAY_FILTER_USE_KEY);

        // Deleting all settings in database
        foreach ($OGoptions as $option => $value) {
            delete_option($option);
        }
    }

    // ==== Functions ====
    // A function for registering base settings of the unactivated plugin as activation hook.
    static function registerSettings(): void {
        // ==== Start of Function ====
        // Registering settings
        foreach (OGSiteSettingsData::arrOptions() as $settingName => $settingValue) {
            add_option(OGSiteSettingsData::$settingPrefix.$settingName, $settingValue);
        }
    }
    // A function for creating the cache files as activation hook.
    static function createCacheFiles(): void {
        // ==== Declaring Variables ====
        # Classes
        $settingsData = new OGSiteSettingsData();

        # Variables
        $cacheFolder = plugin_dir_path(dirname(__DIR__, 1)).$settingsData::$cacheFolder;

        // ==== Start of Function ====
        // Creating the cache files
        foreach ($settingsData::cacheFiles() as $cacheFile) {
            // Creating the cache folder if it doesn't exist
            if (!file_exists($cacheFolder)) {
                mkdir($cacheFolder, 0777, true);
            }

            // Creating the cache file if it doesn't exist
            if (!file_exists($cacheFolder.$cacheFile)) {
                $file = fopen($cacheFolder.$cacheFile, 'w');
                fwrite($file, '');
                fclose($file);
            }
        }
    }
}

// ========= Data Classes =========
class OGSiteSettingsData {
    // ============ Declare Variables ============
    # Strings
    public static string $settingPrefix = 'ppOGSite_'; // This is the prefix for all the settings used within the OG Plugin
    public static string $cacheFolder = 'caches/'; // This is the folder where all the cache files are stored within the server/ftp

    # Arrays
    private static array $apiURLs = [
        'license' => 'https://og-feeds2.pixelplus.nl/api/validate.php',
        'syncTimes' => 'https://og-feeds2.pixelplus.nl/api/latest.php'
    ];
    private static array $cacheFiles = [
        'licenseCache' => 'licenseCache.json', // This is the cache file for the checking the Licence key
    ];
    private static array $arrOptions = [
        # ======== OG Admin Settings ========
        # ==== Licentie ====
        /* Setting Name */'licenseKey' => /* Default Value */   '', // License Key
        
        # ==== Algemeen ====
        /* Setting Name */'siteName' => /* Default Value */     '',
        
        # ======== Uiterlijk Settings ========
        # ==== Logo ====
        /* Setting Name */'siteLogo' => /* Default Value */     '',
        /* Setting Name */'siteLogoWidth' => /* Default Value */     '',
        /* Setting Name */'siteLogoHeight' => /* Default Value */     '',

        # ==== Favicon ====
        /* Setting Name */'siteFavicon' => /* Default Value */     '',

        # ======== Wonen Settings ========
        /* Setting Name */'wonenDetailpaginaBasiskenmerken' => /* Default Value */      'Status:1f;Bouwjaar:1;Prijs:1f;PrijsPerM2:0;Woonoppervlakte:1;OverigeInpandigeOppervlakte:1;Inhoud:0;AantalSlaapkamers:1;AantalKamers:0',
        /* Setting Name */'wonenDetailpaginaOverdracht' => /* Default Value */          'Aanvaarding:1f',
        /* Setting Name */'wonenDetailpaginaBouwOnderhoud' => /* Default Value */       'Bouwjaar:1f;Ligging:1f;SoortBouw:1f;Bouwvorm:1;DakType:1f;DakMateriaal:1f;BouwgrondOppervlakte:1',
        /* Setting Name */'wonenDetailpaginaParkeergelegenheid' => /* Default Value */  'Parkeerfaciliteiten:1f;GarageSoorten:1f',
        /* Setting Name */'wonenDetailpaginaOppervlakteInhoud' => /* Default Value */   'Perceeloppervlakte:1f;Woonoppervlakte:1f;Gebruiksoppervlakte:1f;Inhoud:1f;OverigeInpandigeOppervlakte:1f;GebouwgebondenBuitenruimte:1f',
        /* Setting Name */'wonenDetailpaginaBergruimte' => /* Default Value */          'Bergruimte:1f;SchuurBergingSoort:1f;SchuurBergingVoorzieningen:1f;SchuurBergingIsolatie:1f;SchuurBergingTotaalAantal:1f',
        /* Setting Name */'wonenDetailpaginaIndeling' => /* Default Value */            'AantalWoonlagen:1f;AantalKamers:1f;AantalSlaapkamers:1f;AantalBadkamers:1',
        /* Setting Name */'wonenDetailpaginaEnergieInstallatie' => /* Default Value */  'EnergieLabel:1f;Isolatie:1f;Verwarming:1f;WarmWater:1f;CvKetelType:1f;CvKetelBouwjaar:1f;CvKetelEigendom:1;CvKetelBrandstof:0;EnergieEinddatum:1f',
    ];
    private static array $adminSettings = [
        // Settings 1
        /* Option Group= */ 'ppOGSite_adminOptions' => [
            // General information
            'settingPageSlug' => 'ppOGSite-plugin-settings',
            // Sections
            'sections' => [
                // Section 1 - Algemeen section
                /* Section Title= */'Algemeen' => [
                    'sectionID' => 'ppOGSite_SectionGeneral',
                    'sectionCallback' => '',
                    'permission' => 'plugin_activated',
                    // Fields
                    'fields' => [
                        // Field 1 - Site Naam
                        /* Setting Field Title= */'Site Naam' => [
                            'fieldID' => 'ppOGSite_siteName',
                            'fieldCallback' => '',
                        ],
                    ]
                ],
                // Section 2 - Licentie section
                /* Section Title= */'Licentie' => [
                    'sectionID' => 'ppOGSite_SectionLicence',
                    'sectionCallback' => 'htmlLicenceSection',
                    // Fields
                    'fields' => [
                        // Field 1 - Licentie sleutel
                        /* Setting Field Title= */'Licentie Sleutel' => [
                            'fieldID' => 'ppOGSite_licenseKey',
                            'fieldCallback' => 'htmlLicenceKeyField',
                        ]
                    ]
                ],
            ]
        ],
        // Settings 2
        /* Option Group= */ 'ppOGSite_WonenOptions' => [
            // General information
            'settingPageSlug' => 'ppOGSite-plugin-settings-wonen',
            // Sections
            'sections' => [
                // Section 1 - Detailpagina section
                /* Section Title= */'Detailpagina' => [
                    'sectionID' => 'ppOGSite_wonenDetailpagina',
                    'sectionCallback' => '',
                    // Fields
                    'fields' => [
                        // Field 1 - Basiskenmerken
                        /* Setting Field Title= */'Basiskenmerken' => [
                            'fieldID' => 'ppOGSite_wonenDetailpaginaBasiskenmerken',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_checkboxes'
                        ],
                        // Field 2 - Overdracht
                        /* Setting Field Title= */'Overdracht' => [
                            'fieldID' => 'ppOGSite_wonenDetailpaginaOverdracht',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_checkboxes'
                        ],
                        // Field 3 - Bouw en onderhoud
                        /* Setting Field Title= */'Bouw en onderhoud' => [
                            'fieldID' => 'ppOGSite_wonenDetailpaginaBouwOnderhoud',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_checkboxes'
                        ],
                        // Field 4 - Parkeergelegenheid
                        /* Setting Field Title= */'Parkeergelegenheid' => [
                            'fieldID' => 'ppOGSite_wonenDetailpaginaParkeergelegenheid',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_checkboxes'
                        ],
                        // Field 5 - Oppervlakte en inhoud
                        /* Setting Field Title= */'Oppervlakte en inhoud' => [
                            'fieldID' => 'ppOGSite_wonenDetailpaginaOppervlakteInhoud',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_checkboxes'
                        ],
                        // Field 6 - Bergruimte
                        /* Setting Field Title= */'Bergruimte' => [
                            'fieldID' => 'ppOGSite_wonenDetailpaginaBergruimte',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_checkboxes'
                        ],
                        // Field 7 - Indeling
                        /* Setting Field Title= */'Indeling' => [
                            'fieldID' => 'ppOGSite_wonenDetailpaginaIndeling',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_checkboxes'
                        ],
                        // Field 8 - Energie en installatie
                        /* Setting Field Title= */'Energie en installatie' => [
                            'fieldID' => 'ppOGSite_wonenDetailpaginaEnergieInstallatie',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_checkboxes'
                        ],
                    ]
                ],
            ]
        ],
        // Settings 3
        /* Option Group= */ 'ppOGSite_uiterlijkOptions' => [
            // General information
            'settingPageSlug' => 'ppOGSite-plugin-settings-uiterlijk',
            // Sections
            'sections' => [
                // Section 1 - Logo's section
                /* Section Title= */'Logo\'s' => [
                    'sectionID' => 'ppOGSite_uiterlijkLogos',
                    'sectionCallback' => '',
                    // Fields
                    'fields' => [
                        // Field 1 - Site logo
                        /* Setting Field Title= */'Site logo' => [
                            'fieldID' => 'ppOGSite_siteLogo',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_imageField'
                        ],
                        // Field 2 - Site logo width
                        /* Setting Field Title= */'Site logo width' => [
                            'fieldID' => 'ppOGSite_siteLogoWidth',
                            'fieldCallback' => '',
                        ],
                        // Field 3 - Site logo height
                        /* Setting Field Title= */'Site logo height' => [
                            'fieldID' => 'ppOGSite_siteLogoHeight',
                            'fieldCallback' => '',
                        ],
                    ]
                ],
                // Section 2 - Favicon section
                /* Section Title= */'Favicon' => [
                    'sectionID' => 'ppOGSite_uiterlijkFavicon',
                    'sectionCallback' => '',
                    // Fields
                    'fields' => [
                        // Field 1 - Favicon
                        /* Setting Field Title= */'Site favicon' => [
                            'fieldID' => 'ppOGSite_siteFavicon',
                            'fieldCallback' => '',
                            'sanitizeCallback' => 'sanitize_imageField'
                        ],
                    ]
                ],
            ]
        ]
    ];
    private static array $arrPages = [
        // Page 1 - Homepage
        /* Page Title= */'Homepagina' => [
            # Main Information
            'pageID' => 'ppOGSite_homepage',
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
            'pageID' => 'ppOGSite_diensten',
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
                    'pageID' => 'ppOGSite_dienstenVerkoop',
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
                    'pageID' => 'ppOGSite_dienstenAankoop',
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
                    'pageID' => 'ppOGSite_dienstenTaxatie',
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
                    'pageID' => 'ppOGSite_dienstenZoekprofiel',
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
                    'pageID' => 'ppOGSite_dienstenHypotheekAdvies',
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
    public static function apiURLs(): array {
        return self::$apiURLs;
    }
    public static function cacheFiles(): array {
        return self::$cacheFiles;
    }
    public static function arrOptions(): array {
        return self::$arrOptions;
    }
    public static function adminSettings(): array {
        return self::$adminSettings;
    }
    public static function arrPages(): array {
        return self::$arrPages;
    }

    // ============ HTML Functions ============
    // ======== Admin Options ========
    // Sections
    static function htmlLicenceSection(): void { ?>
        <p>De licentiesleutel die de plugin activeert</p>
    <?php }
    // Fields
    static function htmlLicenceKeyField(): void {
        // ===== Declaring Variables =====
        // Vars
        $licenseKey = get_option(self::$settingPrefix.'licenseKey');

        // ===== Start of Function =====
        // Check if licenseKey is empty
        echo("<input type='text' name='".self::$settingPrefix."licenseKey' value='".esc_attr($licenseKey)."'");
        if ($licenseKey == '') {
            // Display a message
            echo('Het veld is nog niet ingevuld.');
        }
    }
}

// ========= Inactivated/Activated state of Plugin =========
class OGSiteLicense {
    // ============ Declaring Variables ============
    # Nulls
    private static $licenseDataCache = null;
    
    # Strings
    private static string $PluginError_Ophaalfout = '#OGSite-Ophaalfout: Er is iets fout gegaan bij het ophalen van de licentie gegevens. Neem contact op met PixelPlus.';
    private static string $PluginError_Ongeldig = '#OGSite-Ongeldig: De licentie is ongeldig. Neem contact op met PixelPlus.';
    private static string $PluginError_Unknown = '#OGSite-Unknown: Er is iets fout gegaan bij het ophalen van de licentie gegevens. Neem contact op met PixelPlus.';
    private static string $PluginError_NotActivated = '#OGSite-NotActivated: De licentie is niet geactiveerd. Voer de licentie in en activeer de plugin.';

    // ============ Functions ============
    # Function to fetch the Licence data from the API
    private static function fetchLicenseData($url): mixed {
        // ==== Getting the JSON from the API ====
        $jsonData = OGSiteTools::getJSONFromAPI($url);

        if (is_wp_error($jsonData)) {
            return $jsonData;
        }

        // ==== Start of IF ====
        if (isset($jsonData['message']) and $jsonData['message'] == 'Authentication token is not set!') {
            return ['success' => false, 'message' => 'Authentication token is not set!'];
        }

        return $jsonData;
    }

    # Function to check the license and adminNotice the things that don't work
    private static function checkLicense(): mixed {
        // If the license data is already fetched, return it
        if (self::$licenseDataCache !== null) {
            return self::$licenseDataCache;
        }

        // ======== Declaring Variables ========
        # Cache
        $cacheFile = plugin_dir_path(dirname(__DIR__)) . OGSiteSettingsData::$cacheFolder . OGSiteSettingsData::cacheFiles()['licenseCache'];

        # API
        $url = OGSiteSettingsData::apiURLs()['license'];
        $qArgs = !empty(get_option(OGSiteSettingsData::$settingPrefix.'licenseKey')) ? "?token=".get_option(OGSiteSettingsData::$settingPrefix.'licenseKey') : '';

        // ======== Start of Function ========
        // If cache file doesn't exist, create it if the license is valid
        if (!file_exists($cacheFile)) {
            // ==== Declaring Variables IF ====
            # Vars
            $cacheData = self::fetchLicenseData($url . $qArgs);

            // ==== Start of IF ====
            if (is_wp_error($cacheData)) {
                OGSiteTools::adminNotice('error', self::$PluginError_Ophaalfout);
            }
            elseif (isset($cacheData['success']) and $cacheData['success']) {
                file_put_contents($cacheFile, json_encode($cacheData));
            }
            elseif (isset($cacheData['message']) and $cacheData['message'] == 'Invalid authentication token!') {
                OGSiteTools::adminNotice('error', self::$PluginError_Ongeldig);
            }
            elseif (isset($cacheData['message']) and $cacheData['message'] == 'Authentication token is not set!') {
                OGSiteTools::adminNotice('error', self::$PluginError_NotActivated);
            }
            else {
                OGSiteTools::adminNotice('error', self::$PluginError_Unknown);
            }
        }
        else {
            // ==== Declaring Variables ELSE ====
            // If cache file exists, fetch data from the cache
            $cacheData = json_decode(file_get_contents($cacheFile), true);

            // ==== Start of ELSE ====
            // Check if the data is stale (older than an hour) and needs to be updated
            if ((time() - filemtime($cacheFile)) >= 3600 || empty($cacheData)) {
                $cacheData = self::fetchLicenseData($url . $qArgs);

                // ==== Start of IF ====
                if (is_wp_error($cacheData)) {
                    OGSiteTools::adminNotice('error', "#OGSite Plugin Error: Er is iets fout gegaan bij het ophalen van de licentie gegevens. Neem contact op met PixelPlus.");
                }
                elseif (isset($cacheData['success']) and $cacheData['success']) {
                    file_put_contents($cacheFile, json_encode($cacheData));
                }
                elseif (isset($cacheData['message']) and $cacheData['message'] == 'Invalid authentication token!') {
                    OGSiteTools::adminNotice('error', self::$PluginError_Ongeldig);
                }
                elseif (isset($cacheData['message']) and $cacheData['message'] == 'Authentication token is not set!') {
                    OGSiteTools::adminNotice('error', self::$PluginError_NotActivated);
                }
                else {
                    OGSiteTools::adminNotice('error', self::$PluginError_Unknown);
                }
            }
        }

        // After fetching the license data, store it in the static cache variable
        self::$licenseDataCache = $cacheData;

        return $cacheData;
    }

    # Function to check if the plugin is activated or not
    public static function checkActivation(): bool {
        $jsonData = self::checkLicense();

        // ======== Start of Function ========
        # Checking if the license is valid
        if (is_wp_error($jsonData)) {
            return False;
        }
        elseif (isset($jsonData['success']) and $jsonData['success']) {
            return True;
        }
        else {
            return False;
        }
    }

    # Function to check the post type access
    public static function checkPostTypeAccess(): array {
        // ==== Start of Function ====
        $objectAccess = self::checkLicense();

        // Check if data exists
        $objectAccess = $objectAccess['data']['types'] ?? [];
        // Return the array
        return $objectAccess;
    }
}
class OGSitePages {
    // ======== Constructor ========
    public function __construct() {
        // ======== Start of Function ========
        // Creating the Menu's
        add_action('admin_menu', [__CLASS__, 'createMenus']);
        // Registering all the needed settings for the plugin
        add_action('admin_init', [__CLASS__, 'registerSettings']);
        // Updating the favicon
        add_action('init', function() {
            // ==== Declaring Variables ====
            $favicon = get_option(OGSiteSettingsData::$settingPrefix . 'siteFavicon') ?? '';

            // ==== Start of Function ====
            // Favicon
            if (!empty($favicon)) {
                update_option('site_icon', $favicon);
            }
        });


    }

    // ======== Functions ========
    // ==== Creating the menu's ====
    public static function createMenus() {
        // ==== Declaring Variables ====
        # Vars
        $boolPluginActivated = OGSiteLicense::checkActivation();

        // ==== Start of Function ====
        # Making the Global Settings Page
        add_menu_page(
            'Admin Settings',
            'OG Site Settings',
            'manage_options',
            'ppOGSite-plugin-settings',
            [__CLASS__, 'HTMLOGAdminSettings'],
            'dashicons-admin-generic',
            103
        );
        add_submenu_page(
            'ppOGSite-plugin-settings',
            'Algemeen',
            'Algemeen',
            'manage_options',
            'ppOGSite-plugin-settings',
            [__CLASS__, 'HTMLOGAdminSettings']
        );

        if ($boolPluginActivated) {
            # ==== Uiterlijk ====
            add_submenu_page(
                'ppOGSite-plugin-settings',
                'Uiterlijk',
                'Uiterlijk',
                'manage_options',
                'ppOGSite-plugin-settings-uiterlijk',
                [__CLASS__, 'HTMLOGUiterlijkSettings']
            );

            # ==== Wonen ====
            add_submenu_page(
                'ppOGSite-plugin-settings',
                'Wonen',
                'Wonen',
                'manage_options',
                'ppOGSite-plugin-settings-wonen',
                [__CLASS__, 'HTMLOGAdminSettingsWonen']
            );

            # ==== BOG ====
            add_submenu_page(
                'ppOGSite-plugin-settings',
                'BOG',
                'BOG',
                'manage_options',
                'ppOGSite-plugin-settings-bog',
                [__CLASS__, 'HTMLOGAdminSettingsBOG']
            );
        }
    }

    // ==== Registering the settings ====
    public static function registerSettings(): void {
        // ==== Declaring Variables ====
        # Vars
        $boolPluginActivated = OGSiteLicense::checkActivation();

        // ==== Start of Function ====
        # Setting sections and use the OGSiteSettingsData adminSettings data
        foreach(OGSiteSettingsData::adminSettings() as $optionGroup => $optionArray) {
            # Settings for on settings page
            foreach ($optionArray['sections'] as $sectionTitle => $sectionArray) {
                # Checking if this section has the permission to be created
                if (!empty($sectionArray['permission']) && $sectionArray['permission'] == 'plugin_activated' && !$boolPluginActivated) continue;

                # Creating the Section
                add_settings_section(
                    $sectionArray['sectionID'],
                    $sectionTitle,
                    !empty($sectionArray['sectionCallback']) ? "OGSiteSettingsData::{$sectionArray['sectionCallback']}" : function () {

                    },
                    $optionArray['settingPageSlug'],
                );
                foreach ($sectionArray['fields'] as $fieldTitle => $fieldArray) {
                    // Creating the Field
                    add_settings_field(
                        $fieldArray['fieldID'],
                        $fieldTitle,
                        !empty($fieldArray['fieldCallback']) ? "OGSiteSettingsData::{$fieldArray['fieldCallback']}" : function () use ($fieldArray) {
                            // ======== Declaring Variables ========
                            // Vars
                            $strOption = get_option($fieldArray['fieldID']);

                            // ======== Start of Function ========
                            # Checking if this needs to be a checkbox or textfield
                            if (!empty($fieldArray['sanitizeCallback'])) {
                                switch ($fieldArray['sanitizeCallback']) {
                                    case 'sanitize_checkboxes':
                                        self::createCheckboxField($fieldArray, $strOption);
                                        break;
                                    case 'sanitize_imageField':
                                        self::createImageField($fieldArray, $strOption);
                                        break;
                                    default:
                                        break;
                                }
                            }
                            else {
                                self::createTextField($fieldArray['fieldID'], $strOption);
                            }
                        },
                        $optionArray['settingPageSlug'],
                        $sectionArray['sectionID'],
                    );
                    // Registering the Field
                    register_setting($optionGroup, $fieldArray['fieldID'], !empty($fieldArray['sanitizeCallback']) ? "OGSiteSettingsData::{$fieldArray['sanitizeCallback']}" : '');
                }
            }
        }
    }

    // ==== Option functions ====
    static function createCheckboxes($input, $checkBoxName, $label): void {
        if ($input[1] == '0') {
            echo("<input type='hidden' name='{$checkBoxName}' value='0' checked>");
            echo("<input type='checkbox' name='{$checkBoxName}' value='1'>{$label}<br>");
        }
        elseif ($input[1] == '0f') {
            echo("<input type='hidden' name='{$checkBoxName}' value='0f' checked>");
            echo("<input type='checkbox' name='{$checkBoxName}' value='0f' disabled>{$label}<br>");
        }
        elseif ($input[1] == '1f') {
            echo("<input type='hidden' name='{$checkBoxName}' value='1f' checked>");
            echo("<input type='checkbox' name='{$checkBoxName}' value='1f' checked disabled>{$label}<br>");
        }
        else {
            echo("<input type='hidden' name='{$checkBoxName}' value='0' checked>");
            echo("<input type='checkbox' name='{$checkBoxName}' value='1' checked>{$label}<br>");
        }
    }
    static function createCheckboxField($fieldArray, $strOption): void {
        // ===== Declaring Variables ====
        $arrExplodedOption = explode(';', $strOption);

        // ===== Start of Function =====
        # Loop through the exploded array
        if (!empty($arrExplodedOption)) {
            foreach ($arrExplodedOption as $value) {
                // ==== Declaring Variables ====
                # Vars
                $explodedValue = explode(':', $value);
                if (empty($explodedValue)) continue;

                # Checkboxes
                $checkBoxName = "{$fieldArray['fieldID']}[$explodedValue[0]]"; // Append index to the checkbox name
                $label = preg_replace('/(?<!\ )[A-Z]/', ' $0', $explodedValue[0]);

                // ==== Start of Loop ====
                self::createCheckboxes($explodedValue, $checkBoxName, $label);
            }
        }
    }
    static function createTextField($fieldID, $strOption): void {
        // ===== Declaring Variables ====
        $value = esc_attr($strOption);

        // ===== Start of Function =====
        // Check if licenseKey is empty
        echo("<input type='text' name='$fieldID' value='$value'");
    }
    static function createImageField($fieldArray, $strOption): void {
        // ========== Declaring Variables =========
        # Vars
        $strTrimmedOption = basename($strOption) ?? '';

        // ========== Start of Function ==========
        # Initialize media enqueue
        wp_enqueue_media();

        // ===== Displaying the Image =====
        echo("
        <br/>
        <table class='form-table'>
            <tr>
                <th>
                    <!-- Border -->
                    <img style='padding: 2px; border: 1px solid rgba(0, 0, 0, 0.1);' id='{$fieldArray['fieldID']}_logoPreview' src='$strOption' width='115' alt='⠀Niks gekozen' />
                    <p id='{$fieldArray['fieldID']}_Text' style='font-size: 14px;'>$strTrimmedOption</p>
                </th>
                
                <td>
                    <input type='hidden' id='{$fieldArray['fieldID']}_URL' name='{$fieldArray['fieldID']}' value='$strOption'/>
                    <input type='button' id='{$fieldArray['fieldID']}_upload' class='button button-primary' value='Selecteer Logo'/>
                    <input type='button' id='{$fieldArray['fieldID']}_remove' class='button button-secondary' value='Verwijder Logo'/>
                </td>
            </tr>
        </table>
        <br/>
        ");

        // ===== Script =====
        # Script - Select Button
        echo( "<script>
            jQuery(document).ready(function($){
                // ======== Declaring Variables ========
                // Query Selectors
                const logoPreview = $('#{$fieldArray['fieldID']}_logoPreview');
                const logoURL = $('#{$fieldArray['fieldID']}_URL');
                const logoText = $('#{$fieldArray['fieldID']}_Text');
                
                // CSS
                const logoPadding = '1px';
                const logoBorder = '1px solid rgba(0, 0, 0, 0.2)';
                
                // ======== Functions ========
                // Check if the source is found or not
                if (logoURL.val() === '' || logoURL.val() === undefined) {
                    // Border
                    logoPreview.css('border', 'none');
                }
                
                // ==== Select Button ====
                $('#{$fieldArray['fieldID']}_upload').click(function(e) {
                    e.preventDefault();
                    const custom_uploader = wp.media({
                        title: 'Custom Image',
                        button: {
                            text: 'Use this image'
                        },
                        // Set this to true to allow multiple files to be selected
                        multiple: false
                        
                    }).on('select', function() {
                        // ===== Declaring Variables =====
                        const attachment = custom_uploader.state().get('selection').first().toJSON();
                        
                        // ==== Updating the logo preview ====
                        // Attachement URL
                        logoPreview.attr('src', attachment.url);
                        // CSS
                        logoPreview.css('padding', logoPadding);
                        logoPreview.css('border', logoBorder);
                        
                        // ==== Updating the logo URL ====
                        logoURL.val(attachment.url);
                        
                        logoText.text(attachment.url.split('/').reverse()[0]);
                    }).open();
                });
                
                // ==== Remove Button ====
                $('#{$fieldArray['fieldID']}_remove').click(function(e) {
                    e.preventDefault();
                    
                    // ===== Declaring Variables =====
                    // ==== Updating the logo preview ====
                    // Attachement URL
                    logoPreview.attr('src', '');
                    // CSS
                    logoPreview.css('padding', logoPadding);
                    logoPreview.css('border', 'none');
                    // Text
                    logoText.text('');
                    
                    // ==== Updating the logo URL ====
                    logoURL.val('');
                });
            });
        </script>" );
    }
    
    // ======== HTML ========
    // OG Site Admin Settings
    static function HTMLOGAdminSettings(): void {OGSiteTools::htmlAdminHeader('OG Admin Settings - Algemeen');
        $settingsData = new OGSiteSettingsData(); ?>
        <form method="post" action="options.php">
            <?php settings_fields(OGSiteSettingsData::$settingPrefix.'adminOptions');
            do_settings_sections('ppOGSite-plugin-settings');
            OGSiteTools::hidePasswordByName(OGSiteSettingsData::$settingPrefix.'licenseKey');
            submit_button('Opslaan', 'primary', 'submit_license');
            ?>
        </form>
    <?php OGSiteTools::htmlAdminFooter('OG Admin Settings - Algemeen');}
    static function HTMLOGUiterlijkSettings(): void { OGSiteTools::htmlAdminHeader('OG Admin Settings - Uiterlijk');
        // ======== Declaring Variables ========
        $settingsData = new OGSiteSettingsData(); ?>
        <form method="post" action="options.php">
            <?php settings_fields(OGSiteSettingsData::$settingPrefix.'uiterlijkOptions');
            do_settings_sections('ppOGSite-plugin-settings-uiterlijk');
            submit_button('Opslaan', 'primary', 'submit_uiterlijk');
            ?>
        </form>
        <?php OGSiteTools::htmlAdminFooter('OG Admin Settings - Uiterlijk');}
    static function HTMLOGAdminSettingsWonen(): void { OGSiteTools::htmlAdminHeader('OG Admin Settings - Wonen');
        // ======== Declaring Variables ========

        // ======== Start of Function ========
        $settingsData = new OGSiteSettingsData(); ?>
        <form method="post" action="options.php">
            <?php settings_fields(OGSiteSettingsData::$settingPrefix.'WonenOptions');
            do_settings_sections('ppOGSite-plugin-settings-wonen');
            submit_button('Opslaan', 'primary', 'submit_wonen');
            ?>
        </form>
        <?php OGSiteTools::htmlAdminFooter('OG Admin Settings - Wonen');}
    static function HTMLOGAdminSettingsBOG(): void { OGSiteTools::htmlAdminHeader('OG Admin Settings - BOG'); ?>

        <?php OGSiteTools::htmlAdminFooter('OG Admin Settings - BOG');}
    static function HTMLOGAdminSettingsNieuwbouw(): void { OGSiteTools::htmlAdminHeader('OG Admin Settings - Nieuwbouw'); ?>

        <?php OGSiteTools::htmlAdminFooter('OG Admin Settings - Nieuwbouw');}
    static function HTMLOGAdminSettingsALV(): void { OGSiteTools::htmlAdminHeader('OG Admin Settings - A&LV'); ?>

        <?php OGSiteTools::htmlAdminFooter('OG Admin Settings - A&LV');}
}