<?php
// ========== Imports =========
include_once 'functions.php';

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
        $settingData = new OGSettingsData();

        // ==== Start of Function ====
        // Registering settings
        foreach ($settingData->settings as $settingName => $settingValue) {
            add_option($settingData->settingPrefix.$settingName, $settingValue);
        }
    }
}

// ==== Data Classes ====
class OGPostTypeData {
    // Wonen, BOG, Nieuwbouw en A&LV
    public $customPostTypes = array(
        // Post Type 1
        /* post_type */'og-wonen' => array(
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
                'show_in_menu' => 'edit.php?post_type=og-wonen-object',
                'taxonomies' => array('category', 'post_tag')
            )
        ),
        // Post Type 2
        /* post_type */'og-bog' => array(
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
                'show_in_menu' => 'edit.php?post_type=og-bog-object',
                'taxonomies' => array('category', 'post_tag')
            )
        ),
        // Post Type 3
        /* post_type */'og-nieuwbouw' => array(
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
                'show_in_menu' => 'edit.php?post_type=og-nieuwbouw-object',
                'taxonomies' => array('category', 'post_tag')
            )
        ),
        // Post Type 4
        /* post_type */'og-alv' => array(
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
                    'menu_name' => 'A&LV'
                ),
                'public' => true,
                'has_archive' => true,
                'publicly_queryable' => true,
                'query_var' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                'show_in_menu' => 'edit.php?post_type=og-alv-object',
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
    // Arrays
    public $settings = [
        /* Setting Name */'licenseKey' => /* Default Value */'',
        /* Setting Name */'licenseStatus' => /* Default Value */'not checked',
        /* Setting Name */'objectAccess' => /* Default Value */'',
    ];
    public $adminSettings = [
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
        <p>Settings for the OG Plugin</p>
    <?php }
    // Fields
    function htmlLicenceKeyField(): void { ?>
        <input type="text" name="ppOG_licenseKey" value="<?php echo esc_attr(get_option('ppOG_licenseKey')); ?>" />
    <?php }
}

// ========== Inactivated state of Plugin ==========
class OGLicense {
    // ============ Functions ============
    // A function for registering base settings of the unactivated plugin as activation hook.
    function checkActivation(): bool {
        // ==== Declaring Variables ====
        $settingData = new OGSettingsData();

        // ==== Start of Function ====
        // Getting the licenseStatus
        $licenseStatus = get_option($settingData->settingPrefix.'licenseStatus');

        // Checking if licenseStatus is 'not checked'
        if ($licenseStatus == 'not checked') {
            // Say that the plugin is not yet activate

            add_action('admin_notices', function() {
                echo('De OG Koppeling Plugin is nog niet geactiveerd. Ga naar de OG Admin Instellingen om de plugin te activeren.');
            });
            return False;
        }
        try {
            // Begin decrypting the licenseKey
            for ($i = 0; $i < 2; $i++) {
                $licenseStatus = base64_decode($licenseStatus);
                $licenseStatus = hex2bin($licenseStatus);
            }
            // Exploding
            $licenseStatus = explode(';', $licenseStatus);
            if (isset($licenseStatus[1])) {
                // Checking if the license hasn't expired
                if ($licenseStatus[1] >= date('d-m-Y')) {
                    // If the license has expired, say that the plugin is not activated
                    add_action('admin_notices', function() {
                        echo('De OG Koppeling Plugin is niet meer geactiveerd. Contacteer Pixelplus voor een nieuwe licentie sleutel of verlenging.');
                    });
                    return False;
                } // If the license hasn't expired, say that the plugin is activated
                else {
                    return True;
                }
            }
            else {
                // If the licenseKey is not valid, say that the plugin is not activated
                add_action('admin_notices', function() {
                    echo('Contacteer PixelPlus, er is iets fout gegaan met de licentie status!');
                });
                return False;
            }
        }
        catch (Exception $e) {
            // If the licenseKey is not valid, say that the plugin is not activated
            add_action('admin_notices', function() {
                echo('Contacteer PixelPlus, er is iets fout gegaan met de licentie status!');
            });
            return False;
        }
    }
}
class OGPostTypes {
    // ==== Declaring Variables ====

    // ==== Start of Class ====
    function __construct() {
        add_action('admin_menu', array($this, 'createPostTypes'));
//        add_action('init' , array($this, 'checkPostTypeContent'));
    }

    // Functions
    function createPostTypes() {
        // ==== Declaring Variables ====
        $postTypeData = new OGPostTypeData();

        // ==== Start of Function ====
        // Getting the objectAccess option
        $objectAccess = get_option('ppOG_objectAccess');

        // Exploding the objectAccess option into an array
        $objectAccess = explode(';', $objectAccess);

        // Create the OG Custom Post Types (if the user has access to it)
        foreach($postTypeData->customPostTypes as $postType => $postTypeArray) {
            // Checking if the user has access to the post type
            if (!in_array($postType, $objectAccess)) {
                continue;
            }
            // args array with labels
            register_post_type($postType, $postTypeArray['post_type_args']);
            // adding meta boxes
            add_submenu_page(
                'pixelplus-og-plugin-aanbod',
                $postTypeArray['post_type_args']['labels']['menu_name'],
                $postTypeArray['post_type_args']['labels']['menu_name'],
                'manage_options',
                'edit.php?post_type=' . $postType
            );
        }
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
        $license = new OGLicense();
        $boolPluginActivated = $license->checkActivation();
        $postTypeData = new OGPostTypeData();
        // ==== Items OG Admin ====
        if ($boolPluginActivated) {
            // Menu Item: OG Dashboard
            add_menu_page(
                'Admin Dashboard',
                'OG Admin',
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
            // Second sub-menu: OG Admin Settings
            add_submenu_page(
                'pixelplus-og-plugin',
                'Settings',
                'Settings',
                'manage_options',
                'pixelplus-og-plugin-settings',
                array($this, 'HTMLOGAdminSettings'));
            // ==== Pages for on the Settins Submenu ====
            // License
            add_submenu_page(
                'pixelplus-og-plugin-settings',
                'License',
                'License',
                'manage_options',
                'pixelplus-og-plugin-settings-license',
                array($this, 'HTMLOGAdminSettingsLicense'));

        }
        else {
            add_menu_page(
            'Admin Dashboard',
            'OG Admin',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'HTMLOGAdminSettings'),
            'dashicons-plus-alt',
            100);
        }
        // ==== Items OG Aanbod ====
        if ($boolPluginActivated) {
            // Menu Item: OG Aanbod Dashboard
            add_menu_page(
                'Aanbod Dashboard',
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
    function HTMLOGAdminSettings(): void { htmlHeader('OG Admin Settings');set_current_screen('pixelplus-og-plugin-settings'); ?>
        <h1>hi</h1>
    <?php htmlFooter('OG Admin Settings');}

        function HTMLOGAdminSettingsLicense(): void { htmlHeader('OG Admin Settings - Licentie');
        // Manually highlighting the main sub-menu item
        global $submenu_file;
        $submenu_file = 'admin.php?page=pixelplus-og-plugin-settings';
        // if isset submit_license
        if(isset($_POST['submit_license'])) {
            // if isset license_key
            if(isset($_POST['license_key'])) {
                // if license_key is not empty
                if(!empty($_POST['license_key'])) {
                    // update license_key
                    update_option('license_key', $_POST['license_key']);
                }
            }
        }
        ?>
        <form method="post" action="options.php">
            <?php settings_fields('ppOG_AdminOptions'); ?>
            <?php do_settings_sections('pixelplus-og-plugin-settings'); ?>
            <?php submit_button(null, 'primary', 'submit_license'); ?>
        </form>
        <?php htmlFooter('OG Admin Settings - Licentie');}
    // OG Aanbod
    function HTMLOGAanbodDashboard(): void { htmlHeader('OG Aanbod Dashboard'); ?>
        <p>dingdong bishass</p>
        <?php htmlFooter('OG Aanbod Dashboard');}

}
class OGSync {
    // ==== Declaring Variables ====

    // ==== Start of Class ====
    function syncWonen(): void {
        // ======== Declaring Variables ========
        // ======== Start of Function ========
        echo('Syncing Tables Wonen'.PHP_EOL);
        $ding = wp_remote_get('https://og-feeds2.pixelplus.nl/api/import.php?token=5OeaDu1MU7MMBWXrJvtQkNv5pTBrps1m&type=wonen&id=4178995');
        var_dump($ding);
    }
    function syncBOG(): void {
        // ======== Declaring Variables ========

        // ======== Start of Function ========
        echo('Syncing Tables'.PHP_EOL);

    }
    function syncNieuwbouw(): void {
        // ======== Declaring Variables ========

        // ======== Start of Function ========
        echo('Syncing Tables'.PHP_EOL);

    }
    function syncALV(): void {
        // ======== Declaring Variables ========

        // ======== Start of Function ========
        echo('Syncing Tables'.PHP_EOL);

    }
}