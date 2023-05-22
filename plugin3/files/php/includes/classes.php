<?php
// ========== Imports =========
include_once 'functions.php';

// ==== Activation and Deactivation (Uninstallation is in the functions.php because it needs to be a static function) ====
class OGActivationAndDeactivation {
    // ======== Activation ========
    function activate() {
        $this->registerSettings();
        $this->createCacheFiles();
    }

    // ======== Deactivation ========
    function deactivate()
    {

    }

    // ============ Functions ============
    // A function for registering base settings of the unactivated plugin as activation hook.
    function registerSettings() {
        // ==== Declaring Variables ====
        $settingData = new OGSettingsData();

        // ==== Start of Function ====
        // Registering settings
        foreach ($settingData->settings as $settingName => $settingValue) {
            add_option($settingData->settingPrefix.$settingName, $settingValue);
        }
    }

    function createCacheFiles() {
        // ==== Declaring Variables ====
        # Classes
        $settingsData = new OGSettingsData();

        # Variables
        $cacheFolder = plugin_dir_path(dirname(__DIR__, 1)).$settingsData->cacheFolder;

        // ==== Start of Function ====
        // Creating the cache files
        foreach ($settingsData->cacheFiles as $cacheFile) {
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

// ==== Data Classes ====
class OGPostTypeData {
    // ============ Begin of Class ============
    function customPostTypes() {
        // ===== Declaring Variables =====
        # Classes
        $license = new OGLicense();

        # Variables
        $objectAccess = $license->checkPostTypeAccess();
        $customPostTypes = array(
            // Post Type 1
            /* post_type */'wonen' => array(
                'post_type_args' => array(
                    'labels' => array(
                        'name' => 'OG Wonen Objecten',
                        'singular_name' => 'OG Wonen Object',
                        'add_new' => 'Nieuwe toevoegen',
                        'add_new_item' => 'Nieuw OG Wonen Object toevoegen',
                        'edit_item' => 'OG Wonen Object bewerken',
                        'new_item' => 'Nieuw OG Wonen Object',
                        'view_item' => 'Bekijk OG Wonen Object',
                        'search_items' => 'Zoek naar OG Wonen Objecten',
                        'not_found' => 'Geen OG Wonen Objecten gevonden',
                        'not_found_in_trash' => 'Geen OG Wonen Objecten gevonden in de prullenbak',
                        'parent_item_colon' => '',
                        'menu_name' => 'Wonen'
                    ),
                    'post_type_meta' => array(
                        'meta_box_title' => 'OG Wonen Object',
                        'meta_box_id' => 'og-wonen-object',
                        'meta_box_context' => 'normal',
                        'meta_box_priority' => 'high',
                        'meta_box_fields' => array(
                            'OG Wonen Object' => array(
                                'type' => 'text',
                                'id' => 'og-wonen-object',
                                'name' => 'og-wonen-object',
                                'label' => 'OG Wonen Object',
                                'placeholder' => 'OG Wonen Object',
                                'description' => 'OG Wonen Object',
                                'value' => '',
                                'required' => true
                            )
                        )
                    ),
                    'public' => true,
                    'seperate_table' => true,
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'show_in_menu' => 'pixelplus-og-plugin-aanbod',
                    'taxonomies' => array('category', 'post_tag')
                ),
                'database_tables' => array(
                    'tbl_OG_wonen' => array(
                        'ID' => 'object_ObjectTiaraID',
                        'post_title' => 'objectDetails_Adres_NL_Straatnaam;objectDetails_Adres_NL_Huisnummer',
                        'post_content' => 'objectDetails_Aanbiedingstekst',
                        'datum_gewijzigd' => 'datum_gewijzigd',
                    )
                )
            ),
            // Post Type 2
            /* post_type */'bog' => array(
                'post_type_args' => array(
                    'labels' => array(
                        'name' => 'OG BOG Objecten',
                        'singular_name' => 'OG BOG Object',
                        'add_new' => 'Nieuwe toevoegen',
                        'add_new_item' => 'Nieuw OG BOG Object toevoegen',
                        'edit_item' => 'OG BOG Object bewerken',
                        'new_item' => 'Nieuw OG BOG Object',
                        'view_item' => 'Bekijk OG BOG Object',
                        'search_items' => 'Zoek naar OG BOG Objecten',
                        'not_found' => 'Geen OG BOG Objecten gevonden',
                        'not_found_in_trash' => 'Geen OG BOG Objecten gevonden in de prullenbak',
                        'parent_item_colon' => '',
                        'menu_name' => 'BOG'
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'show_in_menu' => 'pixelplus-og-plugin-aanbod',
                    'taxonomies' => array('category', 'post_tag')
                ),
                'database_tables' => array(
                    'ppOG_dataBOG' => array(
                        'ID' => 'object_ObjectTiaraID',
                        'post_title' => 'objectDetails_Adres_Straatnaam;objectDetails_Adres_Huisnummer',
                        'post_content' => 'objectDetails_Aanbiedingstekst',
                        'datum_gewijzigd' => 'datum_gewijzigd',
                    )
                )
            ),
            // Post Type 3
            /* post_type */'nieuwbouw' => array(
                'post_type_args' => array(
                    'labels' => array(
                        'name' => 'OG Nieuwbouw Objecten',
                        'singular_name' => 'OG Nieuwbouw Object',
                        'add_new' => 'Nieuwe toevoegen',
                        'add_new_item' => 'Nieuw OG Nieuwbouw Object toevoegen',
                        'edit_item' => 'OG Nieuwbouw Object bewerken',
                        'new_item' => 'Nieuw OG Nieuwbouw Object',
                        'view_item' => 'Bekijk OG Nieuwbouw Object',
                        'search_items' => 'Zoek naar OG Nieuwbouw Objecten',
                        'not_found' => 'Geen OG Nieuwbouw Objecten gevonden',
                        'not_found_in_trash' => 'Geen OG Nieuwbouw Objecten gevonden in de prullenbak',
                        'parent_item_colon' => '',
                        'menu_name' => 'Nieuwbouw'
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'show_in_menu' => 'pixelplus-og-plugin-aanbod',
                    'taxonomies' => array('category', 'post_tag')
                ),
                'database_tables' => array(
                    'ppOG_dataNieuwbouw' => array(
                        'ID' => 'project_ObjectTiaraID',
                        'post_title' => 'project_ProjectDetails_Projectnaam',
                        'post_content' => 'project_ProjectDetails_Presentatie_Aanbiedingstekst',
                        'datum_gewijzigd' => 'datum_gewijzigd',
                    )
                )
            ),
            // Post Type 4
            /* post_type */'alv' => array(
                'post_type_args' => array(
                    'labels' => array(
                        'name' => 'OG A&LV Objecten',
                        'singular_name' => 'OG A&LV Object',
                        'add_new' => 'Nieuwe toevoegen',
                        'add_new_item' => 'Nieuw OG A&LV Object toevoegen',
                        'edit_item' => 'OG A&LV Object bewerken',
                        'new_item' => 'Nieuw OG A&LV Object',
                        'view_item' => 'Bekijk OG A&LV Object',
                        'search_items' => 'Zoek naar OG A&LV Objecten',
                        'not_found' => 'Geen OG A&LV Objecten gevonden',
                        'not_found_in_trash' => 'Geen OG A&LV Objecten gevonden in de prullenbak',
                        'parent_item_colon' => '',
                        'menu_name' => 'ALV'
                    ),
                    'public' => true,
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'capability_type' => 'post',
                    'hierarchical' => false,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                    'show_in_menu' => 'pixelplus-og-plugin-aanbod',
                    'taxonomies' => array('category', 'post_tag')
                ),
                'database_tables' => array(
                    'ppOG_dataALV' => null
                )
            )
        );

        // ===== Start of Construct =====
        foreach ($customPostTypes as $postType => $postTypeArgs) {
            if (!in_array($postType, $objectAccess)) {
                // Deleting it out of the array
                unset($customPostTypes[$postType]);
            }
        }
        // Returning the array
        return $customPostTypes;
    }
}
class WPColorScheme {
    // ================ Declaring Variables ================
    public array $mainColors = array(
        'light' => 3,
        'modern' => 1,
        'coffee' => 2,
        'ectoplasm' => 2,
        'midnight' => 3,
        'ocean' => 2,
        'sunrise' => 2,
        '80s-kid' => 1,
        'adderley' => 2,
        'aubergine' => 3,
        'blue' => 1,
        'contrast-blue' => 0,
        'cruise' => 3,
        'flat' => 2,
        'kirk' => 0,
        'lawn' => 3,
        'modern-evergreen' => 3,
        'primary' => 3,
        'seashore' => 3,
        'vinyard' => 3
    );

    // ================ Begin of Class ================
    function returnColor(): string
    {
        // ======== Declaring Variables ========
        global $_wp_admin_css_colors;
        $WPColorScheme = get_user_option('admin_color');
        $boolResult = false;

        // ======== Start of Function ========
        foreach ($this->mainColors as $key => $value) {
            if ($key == $WPColorScheme) {
                return $_wp_admin_css_colors[$WPColorScheme]->colors[$this->mainColors[$key]];
            }
        }
        return $_wp_admin_css_colors['fresh']->colors[2];
    }
}
class OGSettingsData {
    // ============ Declare Variables ============
    // Strings
    public $settingPrefix = 'ppOG_'; // This is the prefix for all the settings used within the OG Plugin
    public $cacheFolder = 'caches/'; // This is the folder where all the cache files are stored within the server/ftp
    // Arrays
    public array $apiURLs = [
        'license' => 'https://og-feeds2.pixelplus.nl/api/validate.php',
        'syncTimes' => 'https://og-feeds2.pixelplus.nl/api/latest.php'
    ];

    public array $cacheFiles = [
        'licenseCache' => 'licenseCache.json', // This is the cache file for the checking the Licence key
    ];

    public array $settings = [
        /* Setting Name */'licenseKey' => /* Default Value */       '',     // License Key
    ];
    public array $adminSettings = [
        // Settings 1
        /* Option Group= */ 'ppOG_AdminOptions' => [
            // General information
            'settingPageSlug' => 'pixelplus-og-plugin-settings',
            // Sections
            'sections' => [
                // Section 1 - Licentie section
                /* Section Title= */'Licentie' => [
                    'sectionID' => 'ppOG_SectionLicence',
                    'sectionCallback' => 'htmlLicenceSection',
                    // Fields
                    'fields' => [
                        // Field 1 - Licentie sleutel
                        /* Setting Field Title= */'Licentie Sleutel' => [
                            'fieldID' => 'ppOG_licenseKey',
                            'fieldCallback' => 'htmlLicenceKeyField',
                        ]
                    ]
                ]
            ]
        ]
    ];

    // ============ HTML Functions ============
    // Sections
    function htmlLicenceSection(): void { ?>
        <p>De licentiesleutel die de plugin activeert</p>
    <?php }
    // Fields
    function htmlLicenceKeyField(): void {
        // ===== Declaring Variables =====
        // Vars
        $licenseKey = get_option($this->settingPrefix.'licenseKey');

        // ===== Start of Function =====
        // Check if licenseKey is empty
        if ($licenseKey == '') {
            // Display a message
            echo('De licentiesleutel is nog niet ingevuld.');
        }
        echo(" <input type='text' name='".$this->settingPrefix."licenseKey' value='".esc_attr($licenseKey)."' ");
    }
}

// ========== Inactivated state of Plugin ==========
class OGLicense {
    // ============ Functions ============
    function checkLicense(): mixed {
        // ============= Declaring Variables =============
        # Classes
        $settingData = new OGSettingsData();

        # Cache
        $cacheFile = plugin_dir_path(dirname(__DIR__, 1)) . $settingData->cacheFolder . $settingData->cacheFiles['licenseCache'];
        $cacheData = null;

        # API
        $url = $settingData->apiURLs['license'];
        $qArgs = "?token=".get_option($settingData->settingPrefix.'licenseKey');

        // ================ Start of Function =============
        // Checking if our cache file exists AND if the modification time is less than 1 hour
        if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < 3600) {
            // Getting the data from the cache file
            $cacheData = json_decode(file_get_contents($cacheFile), true);

            // Checking if the data['success'] == True. If so then return otherwise check the API if anything changed by any chance
            if (isset($cacheData['success']) && ($cacheData['success'] == true)) {
                return $cacheData;
            }
            else {
                // Getting the data from API
                $cacheData = getJSONFromAPI($url.$qArgs);
                // Saving the data to the cache file
                file_put_contents($cacheFile, json_encode($cacheData));

                // Checking if the data['success'] == True. If so then return otherwise return the data
                if (isset($cacheData['success']) && ($cacheData['success'] == true)) {
                    $string = "";
                    foreach ($cacheData['data']['types'] as $value) {
                        $string .= $value.';';
                    }
                }
                return $cacheData;
            }
        }
        else {
            // Getting the data from API
            $cacheData = getJSONFromAPI($url.$qArgs);

            // Checking and updating the og types
            if (isset($cacheData['success']) && ($cacheData['success'] == true)) {
                $string = "";
                foreach ($cacheData['data']['types'] as $value) {
                    $string .= $value.';';
                }
            }
            // Saving the data to the cache file
            file_put_contents($cacheFile, json_encode($cacheData));
            return $cacheData;
        }

    }

    // A function for registering base settings of the unactivated plugin as activation hook.
    function checkActivation() {
        // ======== Declaring Variables ========
        $jsonData = $this->checkLicense();

        // ======== Start of Function ========
        // Checking if the license is valid
        if (isset($jsonData['success']) && $jsonData['success'] == true) {
            return True;
        }
        else {
            adminNotice('error', "De licentie is niet actief!");
            return False;
        }
    }

    // A function to see, which OG Post types the user has access to
    function checkPostTypeAccess(): array {
        // ==== Declaring Variables ====
        # Classes
        $settingData = new OGSettingsData();

        // ==== Start of Function ====
        $objectAccess = $this->checkLicense();

        // Check if data exists
        if (isset($objectAccess['data']['types'])) {
            $objectAccess = $objectAccess['data']['types'];
        }
        else {
            $objectAccess = [];
        }
        // Return the array
        return $objectAccess;
    }
}
class OGPages
{
    function __construct()
    {
        // Creating the Pages / Custom Post Types
        add_action('admin_menu', array($this, 'createPages'));
        // Registering all the needed settings for the plugin
        add_action('admin_init', array($this, 'registerSettings'));
        // Updating the permalinks
        add_action('init', function() {
            flush_rewrite_rules();
        });
    }

    // ======== Create Settings Page ========
    function createPages(): void {
        // ======= Declaring Variables =======
        // Classes
        $license = new OGLicense();
        $postTypeData = new OGPostTypeData();
        $postTypeData = $postTypeData->customPostTypes();
        // Vars
        $boolPluginActivated = $license->checkActivation();
        $objectAccess = $license->checkPostTypeAccess();

        // Making the Global Settings Page
        add_menu_page(
            'Admin Settings',
            'OG Settings',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'HTMLOGAdminSettings'),
            'dashicons-admin-generic',
            101
        );
        add_submenu_page(
            'pixelplus-og-plugin-settings',
            'Algemeen',
            'Algemeen',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'HTMLOGAdminSettings')
        );

        // ======= When Plugin is activated =======
        if ($boolPluginActivated) {
            // ==== OG Settings ====
            // Submenu Items based on the OG Post Types for in the OG Settings
            foreach ($postTypeData as $postType => $postTypeArray) {
                if (in_array($postType, $objectAccess)) {
                    $name = $postTypeArray['post_type_args']['labels']['menu_name'];
                    // Creating submenu for in the OG Settings
                    add_submenu_page(
                        'pixelplus-og-plugin-settings',
                        $name,
                        $name,
                        'manage_options',
                        'pixelplus-og-plugin-settings-' . strtolower($name),
                        array($this, 'HTMLOGAdminSettings'.$name)
                    );
                }
            }

            // ==== Items OG Admin ====
            // Menu Item: OG Dashboard
            add_menu_page(
                'Admin Dashboard',
                'OG Admin Dashboard',
                'manage_options',
                'pixelplus-og-plugin',
                array($this, 'HTMLOGAdminDashboard'),
                'dashicons-plus-alt',
                100);
            // First sub-menu item name change
            add_submenu_page(
                'pixelplus-og-plugin',
                'Admin Dashboard',
                'Dashboard',
                'manage_options',
                'pixelplus-og-plugin',
                array($this, 'HTMLOGAdminDashboard'));

            // ==== Items OG Aanbod ====
            // Menu Item: OG Aanbod Dashboard
            add_menu_page(
                'OG Aanbod',
                'OG Aanbod',
                'manage_options',
                'pixelplus-og-plugin-aanbod',
                array($this, 'HTMLOGAanbodDashboard'),
                'dashicons-admin-multisite',
                40);
            // First sub-menu item name change
            add_submenu_page(
                'pixelplus-og-plugin-aanbod',
                'Aanbod Dashboard',
                'Dashboard',
                'manage_options',
                'pixelplus-og-plugin-aanbod',
                array($this, 'HTMLOGAanbodDashboard'),
                0
            );
        }
    }
    // ==== Register Settings ====
    function registerSettings(): void {
        // ==== Vars ====
        $settings = new OGSettingsData();

        // ==== Start of Function ====
        // Setting sections and use the OGSettingsData adminSettings data
        foreach($settings->adminSettings as $optionGroup => $optionArray) {
            // Settings for on settings page
            foreach ($optionArray['sections'] as $sectionTitle => $sectionArray) {
                // Creating the Section
                add_settings_section(
                    $sectionArray['sectionID'],
                    $sectionTitle,
                    array($settings, $sectionArray['sectionCallback']),
                    $optionArray['settingPageSlug'],
                );
                foreach ($sectionArray['fields'] as $fieldTitle => $fieldArray) {
                    // Creating the Field
                    add_settings_field(
                        $fieldArray['fieldID'],
                        $fieldTitle,
                        array($settings, $fieldArray['fieldCallback']),
                        $optionArray['settingPageSlug'],
                        $sectionArray['sectionID'],
                    );
                    // Registering the Field
                    register_setting($optionGroup, $fieldArray['fieldID']);
                }
            }
        }
    }

    // ============ HTML ============
    // OG Admin
    function HTMLOGAdminDashboard(): void {
        // ======== Declaring Variables ========
        # Classes
        $settingData = new OGSettingsData();
        $postTypeData = new OGPostTypeData();
        $wpColorScheme = new WPColorScheme();

        # Variables
        $postTypeData = $postTypeData->customPostTypes();

        $url = $settingData->apiURLs['syncTimes'];
        $qArgs = "?token=".get_option($settingData->settingPrefix.'licenseKey');
        $lastSyncTimes = json_decode(wp_remote_get($url.$qArgs)['body'], true);

        $buttonColor = $wpColorScheme->returnColor();

        // ======== Start of Function ========
        # Checking if the API request is successful
        if (isset($lastSyncTimes['success']) && $lastSyncTimes['success'] == true) {
            adminNotice('success', 'De laatste syncs zijn succesvol opgehaald.');
            $lastSyncTimes = $lastSyncTimes['data'];
        }
        else {
            $lastSyncTimes = false;
        }

        # HTML
        htmlHeader('OG Admin Dashboard');
        echo("
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col' style='border-right: solid 1px black'>
    
                    </div>
                    <div class='col'>
                        <h2 class='text-center'>Statistieken</h2>
    
                        <!-- Table to show when the last syncs have been -->
                        <table class='table table-striped table-bordered'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th scope='col'>Post Type</th>
                                    <th scope='col'>Laatste Sync</th>
                                </tr>
                            </thead>
                            <tbody>");
                                foreach ($postTypeData as $postType => $postTypeArray) {
                                    echo(
                                        "<tr>
                                            <td>".$postTypeArray['post_type_args']['labels']['menu_name']."</td>
                                            <td>".($lastSyncTimes[$postType] ?? 'Nog niet gesynchroniseerd')."</td>
                                        </tr>"
                                    );
                                }
                      echo("</tbody>
                    </div>
                </div>
            </div>
        ");
        htmlFooter('OG Admin Dashboard');}
    // OG Admin Settings
    function HTMLOGAdminSettings(): void { htmlHeader('OG Admin Settings - Algemeen');
        $settingsData = new OGSettingsData();
        ?>
        <form method="post" action="options.php">
            <?php settings_fields($settingsData->settingPrefix.'AdminOptions');
            do_settings_sections('pixelplus-og-plugin-settings');
            hidePasswordByName($settingsData->settingPrefix.'licenseKey');
            submit_button('Opslaan', 'primary', 'submit_license');
            ?>
        </form>
        <?php htmlFooter('OG Admin Settings - Licentie');}
    function HTMLOGAdminSettingsWonen() { htmlHeader('OG Admin Settings - Wonen'); ?>

        <?php htmlFooter('OG Admin Settings - Wonen');}
    function HTMLOGAdminSettingsBOG() { htmlHeader('OG Admin Settings - BOG'); ?>

        <?php htmlFooter('OG Admin Settings - BOG');}
    function HTMLOGAdminSettingsNieuwbouw() { htmlHeader('OG Admin Settings - Nieuwbouw'); ?>

        <?php htmlFooter('OG Admin Settings - Nieuwbouw');}
    function HTMLOGAdminSettingsALV() { htmlHeader('OG Admin Settings - A&LV'); ?>

        <?php htmlFooter('OG Admin Settings - A&LV');}
    // OG Aanbod
    function HTMLOGAanbodDashboard(): void { htmlHeader('OG Aanbod Dashboard'); ?>
        <p>dingdong bishass</p>
        <?php htmlFooter('OG Aanbod Dashboard');}
}
// ========== Fully activated state of the plugin ==========
class OGPostTypes {
    // ==== Declaring Variables ====

    // ==== Start of Class ====
    function __construct() {
        add_action('init', array($this, 'createPostTypes'));
        add_action('init', array($this, 'checkMigrationPostTypes'));
    }

    // =========== Functions ===========
    function createPostTypes() {
        // ==== Declaring Variables ====
        // Classes
        $postTypeData = new OGPostTypeData();
        $postTypeData = $postTypeData->customPostTypes();

        // ==== Start of Function ====

        // Create the OG Custom Post Types (if the user has access to it)
        foreach($postTypeData as $postType => $postTypeArray) {
            register_post_type($postType, $postTypeArray['post_type_args']);
        }
    }
    # This function is for checking if the post types are migrated to different tables / metadata tables
    function checkMigrationPostTypes() {
        // ==== Declaring Variables ====
        # Classes
        global $wpdb;
        $postTypeData = new OGPostTypeData();
        $postTypeData = $postTypeData->customPostTypes();

        # Variables
        $defaultPrefix = "wp_cpt_";
        $sqlCheck = "SHOW TABLES LIKE '".$defaultPrefix."";

        // ==== Start of Function ====
        // Checking
        foreach ($postTypeData as $postType => $postTypeArray) {
            // Preparing the statement
            $result = $wpdb->get_results($sqlCheck.$postType."'");

            if (empty($result)) {
                // Migrating the data
                adminNotice('error', 'Please migrate the '.strtoupper($postType).' custom post type to the new table structure using the CPT Tables Plugin.');
            }
        }
    }
}
class OGOffers {
    // ==== Start of Class ====
    function __construct() {
        $this->examinePosts();
    }

    // ================ Functions ================
    function getNames($post_data, $object, $databaseKeys) {
        // ======== Declaring Variables ========
        $postTitle = explode(';', $databaseKeys['post_title']);

        // ======== Start of Function ========
        # Post Title
        foreach ($postTitle as $title) {
            $post_data['post_title'] .= $object->{$title}.' ';
        }
        // Removing the last space
        $post_data['post_title'] = rtrim($post_data['post_title']);

        # Post Content
        $post_data['post_content'] = $object->{$databaseKeys['post_content']};

        return $post_data;
    }

    function createPost($postTypeName, $object, $databaseKeys) {
        // ======== Declaring Variables ========
        $post_data = [
            'post_type' => $postTypeName,
            'post_title' => '',
            'post_content' => '',
            'post_status' => 'draft'
        ];
        $post_data = $this->getNames($post_data, $object, $databaseKeys);

        // ======== Start of Function ========
        # Creating the post
        $postID = wp_insert_post($post_data);

        # Adding the post meta
        foreach ($object as $key => $value) {
            add_post_meta($postID, $key, $value);
        }

        # Adding meta data for images

        # Publishing the post
        wp_publish_post($postID);
    }

    function updatePost($postID, $object, $databaseKeys) {
        // ======== Declaring Variables ========
        $post_data = [
            'ID' => $postID,
            'post_title' => '',
            'post_content' => ''
        ];

        $post_data = $this->getNames($post_data, $object, $databaseKeys);

        // ======== Start of Function ========
        # Overwriting the post
        wp_update_post($post_data);

        # Updating the post meta
        foreach ($object as $key => $value) {
            update_post_meta($postID, $key, $value);
        }
    }

    function checkPosts($objects, $databaseKeys, $postTypeName) {
        // ======== Start of Function ========
        foreach ($objects as $object) {
            // ==== Declaring Variables ====
            # Classes
            $postData = new WP_Query(([
                'post_type' => $postTypeName,
                'meta_key' => $databaseKeys['ID'],
                'meta_value' => $object->{$databaseKeys['ID']},
            ]));

            # Variables
            $postExists = $postData->have_posts();

            if ($postExists) {
                $dataUpdatedPost = $postData->posts[0]->{$databaseKeys['datum_gewijzigd']};
            }

            // Database object
            $tiaraID = $object->{$databaseKeys['ID']};
            $dataUpdatedObject = $object->{$databaseKeys['datum_gewijzigd']};

            // ==== Start of Function ====
            if ($postExists) {
                // Checking if the post is updated
                if ($dataUpdatedPost != $dataUpdatedObject) {
                    // Updating/overwriting the post
                    $this->updatePost($postData->posts[0]->ID, $object, $databaseKeys);
                }
            } else {
                // Creating the post
                $this->createPost($postTypeName, $object, $databaseKeys);
            }
        }
    }

    function examinePosts() {
        // ======== Declaring Variables ========
        # Classes
        global $wpdb;
        $postTypeData = new OGPostTypeData();

        # Variables
        $beginTime = time();
        $postTypeData = $postTypeData->customPostTypes();

        // ======== Start of Function ========s
        foreach ($postTypeData as $postTypeName => $postTypeArray) {
            // ==== Declaring Variables ====
            $databaseTableName = key($postTypeArray['database_tables']);
            $databaseKeys = $postTypeArray['database_tables'][$databaseTableName];

            # Getting the database objects
            $objects = $wpdb->get_results("SELECT * FROM ".$databaseTableName."");

            # Removing every null out of the objects so Wordpress won't get crazy
            foreach ($objects as $key => $object) {
                foreach ($object as $key2 => $value) {
                    if ($value == 'null' or $value == 'NULL' or $value == null) {
                        $objects[$key]->{$key2} = '';
                    }
                }
            }

            // ==== Start of Loop ====
            if (!empty($objects)) {
                // Looping through the objects and putting them in the right post type
                $this->checkPosts($objects, $databaseKeys, $postTypeName);
            }
        }

        // Putting in the database how much memory it ended up using maximum from bytes to megabytes
        $maxMemoryUsage = (memory_get_peak_usage(true) / 1024 / 1024);
        $memoryUsage = (memory_get_usage(true) / 1024 / 1024);
        $wpdb->insert('cronjobs', [
            'name' => 'OGOffers',
            # convert to megabytes
            'memoryUsageMax' => $maxMemoryUsage,
            'memoryUsage' => $memoryUsage,
            'datetime' => date('Y-m-d H:i:s', $beginTime),
            'duration' => round((time() - $beginTime) / 60, 2)
        ]);
    }
}