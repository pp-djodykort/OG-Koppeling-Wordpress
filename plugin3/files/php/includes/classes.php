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
    // Wonen, BOG, Nieuwbouw en A&LV
    public $customPostTypes = array(
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
                'show_in_menu' => 'edit.php?post_type=wonen-object',
                'taxonomies' => array('category', 'post_tag')
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
                'show_in_menu' => 'edit.php?post_type=bog-object',
                'taxonomies' => array('category', 'post_tag')
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
                'show_in_menu' => 'edit.php?post_type=nieuwbouw-object',
                'taxonomies' => array('category', 'post_tag')
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
                'show_in_menu' => 'edit.php?post_type=alv-object',
                'taxonomies' => array('category', 'post_tag')
            )
        )
    );
}
class WPColorScheme {
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
    public $settingPrefix = 'ppOG_';
    public $cacheFolder = 'caches/';
    // Arrays
    public array $cacheFiles = [
        'licenseCache' => 'licenseCache.json',
    ];

    public array $settings = [
        /* Setting Name */'licenseKey' => /* Default Value */'', // License Key
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
        $data = null;

        # API
        $url = "https://og-feeds2.pixelplus.nl/api/validate.php?";
        $qArgs = "token=".get_option($settingData->settingPrefix.'licenseKey');

        // ================ Start of Function =============
        // Checking if our cache file exists AND if the modification time is less than 1 hour
        if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < 3600) {
            // Getting the data from the cache file
            $data = json_decode(file_get_contents($cacheFile), true);

            // Checking if the data['success'] == True. If so then return otherwise check the API if anything changed by any chance
            if (isset($data['success']) && ($data['success'] == true)) {
                return $data;
            }
            else {
                // Getting the data from API
                $data = getJSONFromAPI($url.$qArgs);
                // Saving the data to the cache file
                file_put_contents($cacheFile, json_encode($data));

                // Checking if the data['success'] == True. If so then return otherwise return the data
                if (isset($data['success']) && ($data['success'] == true)) {
                    foreach ($data['data']['types'] as $value) {
                        $string .= $value.';';
                    }

                    print_r($string);
                }
                return $data;
            }
        }
        else {
            // Getting the data from API
            $data = getJSONFromAPI($url.$qArgs);

            // Checking and updating the og types
            if (isset($data['success']) && ($data['success'] == true)) {
                foreach ($data['data']['types'] as $value) {
                    $string .= $value.';';
                }
                print_r($string);
            }
            // Saving the data to the cache file
            file_put_contents($cacheFile, json_encode($data));
            return $data;
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
            foreach ($postTypeData->customPostTypes as $postType => $postTypeArray) {
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
                array($this, 'HTMLOGAanbodDashboard'));
            // Submenu Items based on the OG Post Types for in the OG Aanbod
            foreach ($postTypeData->customPostTypes as $postType => $postTypeArray) {
                // Creating submenu for in the OG Aanbod
                if (in_array($postType, $objectAccess)) {
                    add_submenu_page(
                        'pixelplus-og-plugin-aanbod',
                        $postTypeArray['post_type_args']['labels']['menu_name'],
                        $postTypeArray['post_type_args']['labels']['menu_name'],
                        'manage_options',
                        'edit.php?post_type=' . $postType,
                    );
                }
            }
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
        // Classes
        $ogSync = new OGSync();
        $wpColorScheme = new WPColorScheme();
        // Colors
        $buttonColor = $wpColorScheme->returnColor();

        // ======== Start of Function ========
        if (isset($_POST['buttonSync'])) {
            $ogSync->syncAll();
        }
        if (isset($_POST['buttonSyncWonen'])) {
            $ogSync->syncWonen();
        }
        if (isset($_POST['buttonSyncBOG'])) {
            $ogSync->syncBOG();
        }
        if (isset($_POST['buttonSyncNieuwbouw'])) {
            $ogSync->syncNieuwbouw();
        }
        if (isset($_POST['buttonSyncALV'])) {
            $ogSync->syncALV();
        }

        htmlHeader('OG Admin Dashboard');?>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col' style='border-right: solid 1px black'>
                    <!-- ==== Button to sync the tables ==== -->
                    <form method='post'>
                        <h2>Synchroniseer Aanbod</h2>
                        <!-- Wordpress Big Sync Button -->
                        <div class='divAllAanbod clearfix'>

                            <button type='submit' name='buttonSync' style='background-color: <?php echo($buttonColor) ?>'>
                                Volledig aanbod<br/>Synchroniseren
                            </button>
                            <!-- Last sync time -->
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='25px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div>
                        </div>
                        <!-- 4 Smaller Sync Buttons -->
                        <h3>Synchroniseer per categorie</h3>
                        <div class='divSmallAanbod clearfix'>
                            <!-- Wonen -->
                            <button type='submit' name='buttonSyncWonen' style='border-color: <?php echo($buttonColor) ?>'>
                                <img src='<?php echo(plugins_url('img/house-icon.png', dirname(__DIR__))) ?>' width='40px' alt=''><span>Wonen</span>
                            </button>
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='20px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div><br/>

                            <!-- BOG -->
                            <button type='submit' name='buttonSyncBOG' style='border-color: <?php echo($buttonColor) ?>'>
                                <img src='<?php echo(plugins_url('img/bog-logo.png', dirname(__DIR__))) ?>' width='40px' alt=''><span>BOG</span>
                            </button><br/>
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='20px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div><br/>

                            <!-- Nieuwbouw -->
                            <button type='submit' name='buttonSyncNieuwbouw' style='border-color: <?php echo($buttonColor) ?>'>
                                <img src='<?php echo(plugins_url('img/nieuwbouw.png', dirname(__DIR__))) ?>' width='40px' alt=''><span>Nieuwbouw</span>
                            </button><br/>
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='20px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div><br/>

                            <!-- A&LV -->
                            <button type='submit' name='buttonSyncALV' style='border-color: <?php echo($buttonColor) ?>'>
                                <img src='<?php echo(plugins_url('img/ALV-logo.png', dirname(__DIR__))) ?>' width='40px' alt=''><span>A&LV</span>
                            </button><br/>
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='20px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div><br/>
                        </div>
                    </form>
                </div>
                <div class='col'>
                    <h2 class='text-center'>Statistieken</h2>
                </div>
            </div>
        </div>
        <?php htmlFooter('OG Admin Dashboard');}
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
    }

    // Functions
    function createPostTypes() {
        // ==== Declaring Variables ====
        // Classes
        $postTypeData = new OGPostTypeData();
        $license = new OGLicense();
        // Vars
        $objectAccess = $license->checkPostTypeAccess();

        // ==== Start of Function ====

        // Create the OG Custom Post Types (if the user has access to it)
        foreach($postTypeData->customPostTypes as $postType => $postTypeArray) {
            // Checking if the user has access to the post type
            if (!in_array($postType, $objectAccess)) {
                continue;
            }
            // args array with labels
            register_post_type($postType, $postTypeArray['post_type_args']);
            // Subpages are created elsewhere
        }
    }
}
class OGOffers {
    // ==== Declaring Variables ====

    // ==== Start of Class ====
    function __construct() {
        add_action('init', array($this, 'createPosts'));
    }

    // ======== Functions ========
    // This function is for getting the column info and putting that as meta data in the custom post types.
    function createPosts() {
        // ======== Declaring Variables ========
        global $wpdb;

        // Getting the column info from the database
        $wonenObjects = $wpdb->get_results('SELECT * FROM ppOG_dataWonen');
        $bogObjects = $wpdb->get_results('SELECT * FROM ppOG_dataBOG');
        $nieuwbouwObjects = $wpdb->get_results('SELECT * FROM ppOG_dataNieuwbouw');

        $post_data = [
            'post_title' => '',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => '',

        ];

        // ======== Start of Function ========
        echo('Creating Posts...'.PHP_EOL);

        // ======= Wonen =======
        // Looping through them and putting them into the post type wonen
        foreach($wonenObjects as $wonenObject) {
            // Check if post already exists with this data
            $boolExists = $wpdb->('SELECT COUNT(*) FROM wp_posts WHERE post_title = "'.$wonenObject->object_ObjectTiaraID.'"');

            print_r($boolExists);

            $post_data['post_title'] = $wonenObject->object_ObjectTiaraID;
            $post_data['post_content'] = $wonenObject->objectDetails_Aanbiedingstekst;
            $post_data['post_type'] = 'wonen';

        }
    }

    // This function is for getting the data from the database off the synced tables into the custom post types.
    function addDa() {
        // ======== Declaring Variables ========
        global $wpdb;


        // ======== Start of Function ========
        echo('Checking Database...'.PHP_EOL);


        $wonenData = $wpdb->get_results('SELECT * FROM ppOG_dataWonen');
        print_r($wonenData);
    }
}
class OGSync {
    // ==== Declaring Variables ====

    // ==== Start of Class ====
    function syncTiaraItem(): void {
        // ======== Declaring Variables ========
        // ======== Start of Function ========
        echo('Syncing Tables Wonen'.PHP_EOL);
        $ding = wp_remote_get('https://og-feeds2.pixelplus.nl/api/import.php?token=5OeaDu1MU7MMBWXrJvtQkNv5pTBrps1m&type=wonen&id=4178995');
        var_dump($ding);
    }
}