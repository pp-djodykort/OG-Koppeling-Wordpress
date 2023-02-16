<?php

class SettingsPage
{
    // Constructor
    function __construct()
    {
        add_action('admin_menu', array($this, 'createSettingPage'));
        add_action('admin_init', array($this, 'registerSettings'));

    }
    
    // Create Settings Page
    function createSettingPage()
    {
        add_options_page(
            'Pixelplus OG Settings',
            'PixelPlus OG Settings',
            'manage_options',
            'pixelplus-og-plugin',
            array($this, 'htmlSettingPage'));
    }

    function htmlSettingPage(): void
    {?>
        <div class='wrap text'>
            <h1 style='text-align: center; font-size: 2rem;'><b>Hello World</b></h1>
        </div>
    <?php }

    // Settings itself
    function registerSettings()
    {
        register_setting('PixelPlusOGPlugin', 'ppOG');

    }
}