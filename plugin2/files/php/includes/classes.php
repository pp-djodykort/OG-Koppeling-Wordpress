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
    public $postTypes = array(
    );
}
class OGAuthentication {
    public $tableNames = array(
        'object_data_bog_queue' => 'ppOG_dataBOG',
        'object_data_bouwnummers_queue' => 'ppOG_dataBouwnummers',
        'object_data_bouwtypen_queue' => 'ppOG_dataBouwTypen',
        'object_data_nieuwbouw_queue' => 'ppOG_dataNieuwbouw',
        'object_data_provincies' => 'ppOG_dataProvincies',
        'object_data_wonen_queue' => 'ppOG_dataWonen',
        'object_image_types' => 'ppOG_imageTypes',
        'object_media_id' => 'ppOG_imageIDs',
        'og_types' => 'ppOG_ogTypes',
        'permalink_structure' => 'ppOG_permalinkStructure',
        'object_media_queue' => 'ppOG_imageQueue'
    );
    public $sourceDBAuth = array(
        "hostname" => "s244.webhostingserver.nl",
        "username" => "deb142504_pixelplus",
        "password" => "100%procentVeiligWachtwoord",
        "database" => "deb142504_pixelplus"
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
            'dashicons-plus-alt',
            40);
        // Changing the name of the first submenu item by creating a submenu item with the same name
        add_submenu_page(
            'pixelplus-og-plugin-aanbod',
            'Aanbod Dashboard',
            'Dashboard',
            'manage_options',
            'pixelplus-og-plugin-aanbod',
            array($this, 'htmlOGAanbodDashboard'));
        // Create 4 submenu custom post types
        add_submenu_page(
            'pixelplus-og-plugin-aanbod',
            'Wonen',
            'Wonen',
            'manage_options',
            'pixelplus-og-plugin-aanbod-wonen',
            array($this, 'htmlOGAanbodWonen'));
        add_submenu_page(
            'pixelplus-og-plugin-aanbod',
            'BOG',
            'BOG',
            'manage_options',
            'pixelplus-og-plugin-aanbod-bog',
            array($this, 'htmlOGAanbodBOG'));
        add_submenu_page(
            'pixelplus-og-plugin-aanbod',
            'Nieuwbouw',
            'Nieuwbouw',
            'manage_options',
            'pixelplus-og-plugin-aanbod-nieuwbouw',
            array($this, 'htmlOGAanbodNieuwbouw'));
        add_submenu_page(
            'pixelplus-og-plugin-aanbod',
            'A&LV',
            'A&LV',
            'manage_options',
            'pixelplus-og-plugin-aanbod-alv',
            array($this, 'htmlOGAanbodALV'));
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
        $customDB = new OGCustomDB();
        $wpColorScheme = new WPColorScheme();
        // Colors
        $buttonColor = $wpColorScheme->returnColor();

        // ======== Start of Function ========
        if (isset($_POST['buttonSync'])) {
            $customDB->syncTables();
        }

        htmlHeader('OG Admin Dashboard');?>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col' style='border-right: solid 1px black'>
                    <h2 class='text-center'>Synchroniseer Aanbod</h2>
                    <!-- ==== Button to sync the tables ==== -->
                    <form method='post'>
                    <div class='divAllAanbod clearfix'>
                        <!-- Big Sync Button -->
                        <button type='submit' name='buttonSync' style='background-color: <?php echo($buttonColor) ?>' class='text-center text-justify'>
                            Volledige aanbod<br/>
                            synchroniseren
                        </button>
                        <!-- Last sync time -->
                        <div class='mt-3 d-table'>
                            <img class='float-left me-2' src='<?php echo(plugins_url('img/recent-logo.png', dirname(__DIR__))) ?>' width='37px'>
                            <span class='text-center align-middle'>Laatste synchronisatie: vandaag 14.15</span>
                        </div>
                    </div>

                    <!-- 4 Smaller Sync Buttons -->
                    </form>
                </div>

                <div class='col'>
                    <h2 class='text-center'>Statistieken</h2>
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
    function HTMLOGAanbodWonen(): void { htmlHeader('OG Wonen'); ?>
        <h1>test</h1>
    <?php htmlFooter('OG Aanbod Wonen');}
    function HTMLOGAanbodBOG(): void { htmlHeader('OG BOG'); ?>
        <h1>test</h1>
    <?php htmlFooter('OG Aanbod BOG');}
    function HTMLOGAanbodNieuwbouw(): void { htmlHeader('OG Nieuwbouw'); ?>
        <h1>test</h1>
    <?php htmlFooter('OG Nieuwbouw');}
    function HTMLOGAanbodALV(): void { htmlHeader('OG Aanbod A&LV'); ?>
        <h1>test</h1>
    <?php htmlFooter('OG Aanbod A&LV');}
}
// Creating Custom Post types
class OGPostTypes {
    function __construct()
    {
        add_action('init', array($this, 'createPostTypes'));
//        add_action('init', array($this, 'insert_og_wonen_objects'));
    }

    // Functions
    function createPostTypes() {
        // ==== Declaring Variables ====
        $postTypes = new OGPostTypeData();

        // ==== Start of Function ====
        $labels = array(
            'name' => 'OG Wonen Objects',
            'singular_name' => 'OG Wonen Object',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New OG Wonen Object',
            'edit_item' => 'Edit OG Wonen Object',
            'new_item' => 'New OG Wonen Object',
            'view_item' => 'View OG Wonen Object',
            'search_items' => 'Search OG Wonen Objects',
            'not_found' => 'No OG Wonen Objects found',
            'not_found_in_trash' => 'No OG Wonen Objects found in Trash',
            'parent_item_colon' => '',
            'menu_name' => 'OG Wonen Objects'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'og-wonen-object'),
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'taxonomies' => array()
        );

        register_post_type('og-wonen-object', $args);
    }
    function insert_og_wonen_objects() {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM tbl_OG_wonen");

        foreach ($results as $result) {
            $post = array(
                'post_title' => $result->object_ObjectCode,
                'post_status' => 'publish',
                'post_type' => 'og-wonen-object'
            );

            $post_id = wp_insert_post($post);

            if ($post_id) {
                add_post_meta($post_id, 'id_provincies', $result->id_provincies);
                add_post_meta($post_id, 'datum_toegevoegd', $result->datum_toegevoegd);
                add_post_meta($post_id, 'toegevoegd_door', $result->toegevoegd_door);
                add_post_meta($post_id, 'datum_gewijzigd', $result->datum_gewijzigd);
                add_post_meta($post_id, 'gewijzigd_door', $result->gewijzigd_door);
                add_post_meta($post_id, 'object_ObjectCode', $result->object_ObjectCode);
            }
        }
    }


}

class OGCustomDB {
    // ==== Declaring Variables ====

    // ==== Start of Class ====
    function __construct() {
        // ==== Declaring Variables ====
        $ogAuthentication = new OGAuthentication();

        // ==== Start of Function ====
	    foreach ($ogAuthentication->tableNames as $tableName_Source => $tableName_Target) {
		    if (!$this->tableExits($tableName_Target)) {
			    $this->createTable($tableName_Target);
		    }
	    }
    }

	function tableExits($tableName_Target): bool {
		// ==== Declaring Variables ====
		global $wpdb;
		$sql = "SHOW TABLES LIKE '".$tableName_Target."'";
		$result = $wpdb->get_results($sql);
		// ==== Start of Function ====
		if (!empty($result)) {
			return True;
		}
		else {
			return False;
		}
	}
    function createTable($tableName_Target): void {
        // ======== Declaring Variables ========
	    $ogAuthentication = new OGAuthentication();
	    $tableName_Source = array_flip($ogAuthentication->tableNames)[$tableName_Target];

	    // Source Database Connection
	    $dbSourceLogin = $ogAuthentication->sourceDBAuth;
	    $source_connection = connectToDB($dbSourceLogin['hostname'], $dbSourceLogin['username'], $dbSourceLogin['password'], $dbSourceLogin['database']);

	    //Target Database Connection
	    global $wpdb;
        $db_target = 'admin_og-wp';

        // ======== Start of Function ========
        // Getting data structure from source database and echoing it
        try {
            $sql = "SHOW CREATE TABLE ".$tableName_Source;
            $result = $source_connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            $sql = $result[0]['Create Table'];
            $sql = str_replace($tableName_Source, $tableName_Target, $sql);

            $wpdb->query($sql);
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
	function syncTables(): void {
		// ======== Declaring Variables ========

		// ======== Start of Function ========
        echo('Syncing Tables'.PHP_EOL);


	}
}