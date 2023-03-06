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
	    $customDB = new OGCustomDB();

        // ======== Start of Function ========
        if (isset($_POST['buttonSync'])) {
            $customDB->syncTables();
        }
        htmlHeader('OG Dashboard');?>
        <div class='container-fluid'>
            <?php welcomeMessage(); ?>

            <form method="post" class='syncForm'>
                <!-- Blue update buttons -->
                Synchroniseer: <input type="submit" name="buttonSync" value="Al het aanbod"><br/>
                Synchroniseer: <input type="submit" name="buttonSync" value="Wonen"><br/>
                Synchroniseer: <input type="submit" name="buttonSync" value="BOG"><br/>
                Synchroniseer: <input type="submit" name="buttonSync" value="Nieuwbouw"><br/>
                Synchroniseer: <input type="submit" name="buttonSync" value="A&LV">
            </form>
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
		$ogAuthentication = new OGAuthentication();

		// Source Database Connection
		$dbSourceLogin = $ogAuthentication->sourceDBAuth;
		$source_connection = connectToDB($dbSourceLogin['hostname'], $dbSourceLogin['username'], $dbSourceLogin['password'], $dbSourceLogin['database']);
		if (!$source_connection) {
			die("Failed to connect to the source database.");
		}

		//Target Database Connection
		global $wpdb;
		$db_target = 'admin_og-wp';

        // Pagination
		$page_size = 1000; // Number of rows to fetch per page
		// ======== Start of Function ========
		foreach ($ogAuthentication->tableNames as $tableName_Source => $tableName_Target) {
			$page = 0;              // Starting page
			$synced_ids = array();  // IDs that have been synced
			// Getting data structure from source database and echoing it
			try {
				while (true) {
					$offset = $page_size * $page; // Offset to fetch the next page
					$sql = "SELECT * FROM ".$tableName_Source." LIMIT ".$page_size." OFFSET ".$offset;
					$result = $source_connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
					if (empty($result)) {
						// No more rows to fetch, exit the loop
						break;
					}
					// Inserting the data into the database
					foreach ($result as $row) {
						$wpdb->replace($tableName_Target, $row);
						$synced_ids[] = $row['id']; // Keep track of synced IDs
					}
                    // Usleep for a few milliseconds to prevent the server from crashing
                    usleep(1000);
					$page++;
				}
				// Deleting the data that is not in the source database but still in the target database.
				if (!empty($synced_ids)) {
					$synced_ids_str = implode(",", $synced_ids);
					$sql = "DELETE FROM ".$tableName_Target." WHERE id NOT IN (".$synced_ids_str.")";
					$wpdb->query($sql);
				}
				echo ("Successfully synced ".$tableName_Source." with ".$tableName_Target.".<br>");
                sleep(1);
			} catch (Exception $e) {
                echo("Failed to sync ".$tableName_Source." with ".$tableName_Target.".<br>");
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
	}
}