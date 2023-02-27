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
    function __construct() {
        // ==== Declaring Variables ====
        $ogAuthentication = new OGAuthentication();

        // ==== Start of Function ====
        foreach ($ogAuthentication->tableNames as $tableName) {
            if (!$this->tableExits($tableName)) {
                $this->createTable($tableName);
            }
        }
    }

    function tableExits($table_name): bool {
        // ==== Declaring Variables ====
        global $wpdb;

        $sql = "SHOW TABLES LIKE '".$table_name."'";
        $result = $wpdb->get_results($sql);

        // ==== Start of Function ====
        if (!empty($result)) {
            return True;
        }
        else {
            return False;
        }
    }

    function createTable($table_name): bool {
        // ==== Declaring Variables ====
        global $wpdb;
        $tries = 0;

        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE ".$table_name." (
            name_ID int(5) AUTO_INCREMENT PRIMARY KEY,
            name varchar(255) NOT NULL,
            description varchar(255) NOT NULL
        ) ".$charset_collate.";";

        // ==== Start of Function ====
        while (true) {
	        $result = $wpdb->query($sql);
	        if ($result) {
                return True;
	        }
            else {
                sleep(1);
                $tries++;
                if ($tries > 3) {
                    return False;
                }
            }
        }
    }

    function copyIntoTable(): void {
	    // ======== Declaring Variables ========
        $ogAuthentication = new OGAuthentication();
	    // Source Database
	    $dbHostname = 's244.webhostingserver.nl';
	    $dbUsername = "deb142504_pixelplus";
	    $dbPassword = "100%procentVeiligWachtwoord";
	    $db_source  = 'deb142504_pixelplus';
	    //Target Database
	    global $wpdb;
	    $db_target = 'admin_og-wp';

	    // Create Source Connection
	    $source_connection = connectToDB( $dbHostname, $dbUsername, $dbPassword);

	    // ======== Start of Function ========
        try {
            // Loop through all the tables
            foreach ($ogAuthentication->tableNames as $tableName_Target => $tableName_Source) {
                // Get the data from the source database
                $sql = "SELECT * FROM ".$db_source.".".$tableName_Source;
                $result = $source_connection->query($sql);

                // Loop through the data
                while ($row = $result->fetch_assoc()) {
                    echo $row['name']."<br>";

                }
            }

        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


    }
}