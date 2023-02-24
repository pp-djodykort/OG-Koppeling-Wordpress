<?php
// ========== Imports =========
include_once './functions.php';

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
    function htmlOGDashboard(): void { htmlHeader('OG Dashboard');?>
        <h1>cyka</h1>
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
        $tableNames = array(
            'ppOG_dataBOG',
            'ppOG_dataBouwnummers',
            'ppOG_dataBouwTypen',
            'ppOG_dataNieuwbouw',
            'ppOG_dataProvincies',
            'ppOG_dataWonen',
        );

        // ==== Start of Function ====
        foreach ($tableNames as $tableName) {
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
        while (True) {
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

    function copyIntoTable() {
        // ==== Declaring Variables ====
        $database_source = 'admin_og_wp-feeds';
        $database_target = 'admin_og_wp';

        $table_source = 'object_data_bog_queue';
        $table_target = 'ppOG_dataBOG';

        // ==== Start of Function ====

    }
}