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
    function createPages(){
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
            'Settings',
            'manage_options',
            'pixelplus-og-plugin-settings',
            array($this, 'htmlSettingPage'));
    }

    // ==== Register Settings ====
    function registerSettings(){
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
    function htmlOGDashboard() { ?>
        <div class='wrap text'>
            <h1 style='text-align: center; font-size: 2rem;'><b>OG Dashboard</b></h1>
        </div>
    <?php }

    // HTML for Settings Page
	    function htmlSettingPage() { ?>
        <div class='wrap text'>
            <h1 style='text-align: center; font-size: 2rem;'><b>Settings</b></h1>
            <form method='post' action='options.php'>
                <?php
                settings_fields('ppOG');
                do_settings_sections('pixelplus-og-plugin');
                submit_button();
                ?>
            </form>
        </div>
    <?php }

    // HTML for Settings Section
    function HTMLppOGSection1() { ?>
        <p>Enter your license key to enable updates and support.</p>
    <?php }

    // HTML for License Key Field
    function HTMLppOGLicenseKey() { ?>
        <input type='text' name='ppOG_license_key' value='<?php echo get_option('ppOG_license_key'); ?>'>
    <?php }
    
}