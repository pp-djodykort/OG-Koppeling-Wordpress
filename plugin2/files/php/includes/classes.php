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

        // Create Submenu Item with Settings HTML
        add_submenu_page(
            'pixelplus-og-plugin',
            'Pixelplus OG - Settings',
            'OG - Settings',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'htmlSettingPage'));
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

// ==== HTML ====
    // HTML for OG Dashboard
    function htmlOGDashboard(): void {
        // ======== Declaring Variables ========
	    $customDB = new OGCustomDB();

        // ======== Start of Function ========
        if (isset($_POST['buttonSync'])) {
            $customDB->copyIntoTable();
        }
        htmlHeader('OG Dashboard');?>
        <div class="wrap">
            <p>Welkom op de OG Dashboard pagina.</p>
            <!-- Create a button for a function that I'm gonna declare later -->
            <form method="post">
                Sync all the database tables: <input type="submit" name="buttonSync" value="Sync Tables">
            </form>
        </div>
    <?php htmlFooter('OG Dashboard');}

    // HTML for Settings Page
    function htmlSettingPage(): void { htmlHeader('OG Settings'); ?>
        <form method='post' action='options.php'>
            <?php
            settings_fields('ppOG');
            do_settings_sections('pixelplus-og-plugin');
            submit_button();
            ?>
        </form>
    <?php htmlFooter('OG Settings');}

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
            $result = $source_connection->query($sql)->FetchAll(PDO::FETCH_ASSOC);

            $sql = $result[0]['Create Table'];
            $sql = str_replace($tableName_Source, $tableName_Target, $sql);

            $wpdb->query($sql);
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }










    }
    function copyIntoTable(): void {
	    // ======== Declaring Variables ========
        $ogAuthentication = new OGAuthentication();

        // Source Database Connection
        $dbSourceLogin = $ogAuthentication->sourceDBAuth;
        $source_connection = connectToDB($dbSourceLogin['hostname'], $dbSourceLogin['username'], $dbSourceLogin['password'], $dbSourceLogin['database']);
	    //Target Database Connection
	    global $wpdb;
	    $db_target = 'admin_og-wp';

	    // ======== Start of Function ========
        foreach ($ogAuthentication->tableNames as $tableName_Source => $tableName_Target) {
            // Getting data structure from source database and echoing it
            try {
                $sql = "SELECT * FROM ".$tableName_Source;
                $result = $source_connection->query($sql)->FetchAll(PDO::FETCH_ASSOC);
                // Inserting the data into the database
                foreach ($result as $row) {
                    $wpdb->insert($tableName_Target, $row);
                }
                // Updating the data in the database
                $sql = "SELECT * FROM ".$tableName_Target;
                $result = $wpdb->get_results($sql);
                foreach ($result as $row) {
                    $wpdb->update($tableName_Target, $row, array('id' => $row->id));
                }
                echo("Table ".$tableName_Target." has been synced.<br>");


            }
            catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }


    }
}