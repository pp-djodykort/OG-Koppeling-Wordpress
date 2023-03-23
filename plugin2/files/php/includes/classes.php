<?php
// ========== Imports =========
include_once 'functions.php';

// =========== Data Classes ===========
class OGSettingsData {
    // ============ Declare Variables ============
    public $adminSettings = array(
        // Settings 1
        /* Option Group= */ 'ppOGAdminOptions' => array(
            // General information
            'settingPageSlug' => 'pixelplus-og-plugin-settings',
            // Sections
            'sections' => array(
                // Section 1 - Licentie section
                /* Section Title= */'Licentie' => array(
                    'sectionID' => 'ppOGSectionLicence',
                    'sectionCallback' => 'htmlLicenceSection',
                    // Fields
                    'fields' => array(
                        // Field 1 - Licentie sleutel
                        /* Setting Field Title= */'Licentie Sleutel' => array(
                            'fieldID' => 'ppOGLicenceKey',
                            'fieldCallback' => 'htmlLicenceKeyField',
                        )
                    )

                )
            )
        ),
    );

    // ============ HTML Functions ============
    // Sections
    function htmlLicenceSection(): void { ?>
        <p>Settings for the OG Plugin</p>
    <?php }
    // Fields
    function htmlLicenceKeyField(): void { ?>
        <input type="text" name="ppOGLicenceKey" value="<?php echo esc_attr(get_option('ppOGLicenceKey')); ?>" />
    <?php }
}
class OGPostTypeData {
    // Wonen, BOG, Nieuwbouw en A&LV
    public $customPostTypes = array(
        // Post Type 1
        /* Menu name */'Wonen' => array(
            'post_type' => 'og-wonen-object',
            'post_type_labels' => array(
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
            'post_type_args' => array(
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'wonen'),
                'menu_icon' => 'dashicons-admin-home',
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                'taxonomies' => array('category', 'post_tag')
            )
        ),
        // Post Type 2
        /* Menu name */'BOG' => array(
            'post_type' => 'og-bog-object',
            'post_type_labels' => array(
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
            'post_type_args' => array(
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'bog'),
                'menu_icon' => 'dashicons-admin-home',
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                'taxonomies' => array('category', 'post_tag')
            )
        ),
        // Post Type 3
        /* Menu name */'Nieuwbouw' => array(
            'post_type' => 'og-nieuwbouw-object',
            'post_type_labels' => array(
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
            'post_type_args' => array(
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'nieuwbouw'),
                'menu_icon' => 'dashicons-admin-home',
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                'taxonomies' => array('category', 'post_tag')
            )
        ),
        // Post Type 4
        /* Menu name */'A&LV' => array(
            'post_type' => 'og-alv-object',
            'post_type_labels' => array(
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
            'post_type_args' => array(
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'alv'),
                'menu_icon' => 'dashicons-admin-home',
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                'taxonomies' => array('category', 'post_tag')
            )
        ),
        // End Post Type
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
// ==== Activation and Deactivation ====
class OGActivationAndDeactivation {
    // ======== Activation ========
    function activate() {
    }
    // ======== Deactivation ========
    function deactivate()
    {
        add_action('init', array($this, 'deletePostType'));
    }

    // ============ Functions ============
    function deletePostType() {
        // ==== Vars ====
        $postType = 'post_type';
        // ==== Start of Function ====
        unregister_post_type($postType);
    }

}

// ====== Excecuted every time the plugin is loaded ======
// Creating Pages
class OGPages
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'createPages'));
        add_action('admin_init', array($this, 'registerSettings'));
    }

    // ======== Create Settings Page ========
    function createPages(): void {
        // ======= Declaring Variables =======
        $postTypeData = new OGPostTypeData();
        // ==== Items OG Admin ====
        // Create Menu Item with OG Dashboard HTML
        add_menu_page(
            'Admin Dashboard',
            'OG Admin',
            'manage_options',
            'pixelplus-og-plugin',
            array($this, 'htmlOGAdminDashboard'),
            'dashicons-plus-alt',
            100);
        // Changing the name of the first submenu item by creating a submenu item with the same name
        add_submenu_page(
            'pixelplus-og-plugin',
            'Admin Dashboard',
            'Dashboard',
            'manage_options',
            'pixelplus-og-plugin',
            array($this, 'htmlOGAdminDashboard'));
        // Create Submenu Item for the Settings with Settings HTML
        add_submenu_page(
            'pixelplus-og-plugin',
            'Settings',
            'Settings',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'htmlOGAdminSettings'));
        // ==== Items OG Aanbod ====
        // Create Menu Item with OG Aanbod HTML
        add_menu_page(
            'Aanbod Dashboard',
            'OG Aanbod',
            'manage_options',
            'pixelplus-og-plugin-aanbod',
            array($this, 'htmlOGAanbodDashboard'),
            'dashicons-admin-multisite',
            40);
        // Changing the name of the first submenu item by creating a submenu item with the same name
        add_submenu_page(
            'pixelplus-og-plugin-aanbod',
            'Aanbod Dashboard',
            'Dashboard',
            'manage_options',
            'pixelplus-og-plugin-aanbod',
            array($this, 'htmlOGAanbodDashboard'));
        // Create 4 custom post types
    }
    // ==== Register Settings ====
    function registerSettings(): void {
        // ==== Vars ====
        $settings = new OGSettingsData();

        // ==== Start of Function ====
        // Setting sections and use the OGSettingsData adminSettings data
        foreach($settings->adminSettings as $optionGroup => $optionArray) {
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

                        <div class='divAllAanbod clearfix'>
                            <!-- Wordpress Big Sync Button -->
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
                            <button type='submit' name='buttonSyncWonen'>
                                <img src='<?php echo(plugins_url('img/house-icon.png', dirname(__DIR__))) ?>' width='40px' alt=''><span>Wonen</span>
                            </button>
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='20px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div><br/>

                            <!-- BOG -->
                            <button type='submit' name='buttonSyncBOG'>
                                <img src='<?php echo(plugins_url('img/bog-logo.png', dirname(__DIR__))) ?>' width='40px' alt=''><span>BOG</span>
                            </button><br/>
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='20px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div><br/>

                            <!-- Nieuwbouw -->
                            <button type='submit' name='buttonSyncNieuwbouw'>
                                <img src='<?php echo(plugins_url('img/nieuwbouw.png', dirname(__DIR__))) ?>' width='40px' alt=''><span>Nieuwbouw</span>
                            </button><br/>
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='20px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div><br/>

                            <!-- A&LV -->
                            <button type='submit' name='buttonSyncALV'>
                                <img src='<?php echo(plugins_url('img/ALV-logo.png', dirname(__DIR__))) ?>' width='40px' alt=''><span>A&LV</span>
                            </button><br/>
                            <div class='mt-2 d-table'>
                                <img class='float-left me-2' alt='Error: recent-logo.png' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='20px'>
                                <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                            </div><br/>

                    </div>
                    </form>

                    <div class='col'>
                        <h2 class='text-center'>Statistieken</h2>
                    </div>
                </div>
            </div>
        </div>
        <?php htmlFooter('OG Admin Dashboard');}
    // OG Admin Settings
    function HTMLOGAdminSettings(): void { htmlHeader('OG Admin Settings'); ?>
        <form method="post" action="options.php">
            <?php settings_fields('ppOGAdminOptions'); ?>
            <?php do_settings_sections('pixelplus-og-plugin-settings'); ?>
            <?php submit_button(); ?>
        </form>
    <?php htmlFooter('OG Admin Settings');}
    // OG Aanbod
    function HTMLOGAanbodDashboard(): void { htmlHeader('OG Aanbod Dashboard'); ?>

    <?php htmlFooter('OG Aanbod Dashboard');}
}

class OGSync {
    // ==== Declaring Variables ====

    // ==== Start of Class ====
	function syncWonen(): void {
		// ======== Declaring Variables ========

		// ======== Start of Function ========
        echo('Syncing Tables Wonen'.PHP_EOL);
        $ding = wp_remote_get('https://og-feeds2.pixelplus.nl/api/import.php?token=5OeaDu1MU7MMBWXrJvtQkNv5pTBrps1m&type=wonen');
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