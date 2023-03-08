<?php
// ========== Imports =========
include_once 'functions.php';

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
class OGSettingsPage
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'createPages'));
        add_action('admin_init', array($this, 'registerSettings'));

    }

    // ==== Create Settings Page ====
    function createPages(): void {
        // Create Menu Item with OG Dashboard HTML
        add_menu_page(
            'Pixelplus OG - Dashboard',
            'Pixelplus OG',
            'manage_options',
            'pixelplus-og-plugin',
            array($this, 'htmlOGDashboard'),
            'dashicons-plus-alt',
            100);

        // Create Submenu Item for the Settings with Settings HTML
        add_submenu_page(
            'pixelplus-og-plugin',
            'Pixelplus OG - Settings',
            'OG - Settings',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'htmlSettingPage'));

        // Create Submenu Item for the Aanbod with Admin Aanbod HTML
        add_submenu_page(
            'pixelplus-og-plugin',
            'Pixelplus OG - Aanbod',
            'OG - Aanbod',
            'manage_options',
            'pixelplus-og-plugin-aanbod',
            array($this, 'htmlAdminAanbod'));
    }

    // ==== Register Settings ====
    function registerSettings(): void {
        // Register Settings Section
        add_settings_section(
            'ppOG_section1',
            'Licensing',
            array($this, 'HTMLppOGSection1'),
            'pixelplus-og-plugin');

        // Register Settings Field
        add_settings_field(
            'ppOG_license_key',
            'License Key',
            array($this, 'HTMLppOGLicenseKey'),
            'pixelplus-og-plugin',
            'ppOG_section1');

        // Register Settings
        register_setting('ppOG', 'ppOG_license_key');
    }

    // ==== Creating an extra post type for 3341111
// ==== HTML ====
    // HTML for OG Dashboard
    function htmlOGDashboard(): void {
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

        htmlHeader('OG Dashboard');?>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col' style='border-right: solid 1px black'>
                    <h2 class='text-center'>Synchroniseer Aanbod</h2>
                    <!-- ==== Button to sync the tables ==== -->
                    <form method='post''>
                        <div class='divAllAanbod clearfix'>
                            <!-- Big Sync Button -->
                            <button style='background-color: <?php echo($buttonColor) ?>' class='text-center text-justify'>
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
    <?php htmlFooter('OG Dashboard');}

    // HTML for Settings Page
    function htmlSettingPage(): void { htmlHeader('OG Settings'); ?>
        <div class='container-fluid'>
	        <?php welcomeMessage(); ?>
            <form method='post' action='options.php'>
		        <?php
		        settings_fields('ppOG');
		        do_settings_sections('pixelplus-og-plugin');
		        submit_button();
		        ?>
            </form>
        </div>
    <?php htmlFooter('OG Settings');}

	// HTML for OG Aanbod Page
    function htmlAdminAanbod(): void { htmlHeader('OG Aanbod'); ?>
        <div class='container-fluid'>
	        <?php welcomeMessage(); ?>
        </div>
    <?php htmlFooter('OG Aanbod');}

    // HTML for Settings Section
    function HTMLppOGSection1(): void { ?>
        <p>Enter your license key to enable updates and support.</p>
    <?php }

    // HTML for License Key Field
    function HTMLppOGLicenseKey(): void { ?>
        <input type='text' name='ppOG_license_key' value='<?php echo get_option('ppOG_license_key'); ?>'>
    <?php }

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