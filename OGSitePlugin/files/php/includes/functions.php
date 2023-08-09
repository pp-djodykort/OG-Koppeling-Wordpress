<?php
// ========= Imports =========
include_once 'classes.php';

// ============ Functions ============
class OGSiteTools {
    // ======== Functions ========
    static function adminNotice($type, $strInput): void {
        if ($type == "error") {
            add_action('admin_notices', function() use ($strInput) {
                echo ("<div class='alert alert-danger' role='alert'>"); print_r($strInput); echo ("</div>");
            });
        }
        else if ($type == "success") {
            add_action('admin_notices', function() use ($strInput) {
                echo ("<div class='alert alert-success' role='alert'>"); print_r($strInput); echo ("</div>");
            });
        }
        else if ($type == "warning") {
            add_action('admin_notices', function() use ($strInput) {
                echo ("<div class='alert alert-warning' role='alert'>"); print_r($strInput); echo ("</div>");
            });
        }
        else if ($type == "info") {
            add_action('admin_notices', function() use ($strInput) {
                echo ("<div class='alert alert-info' role='alert'>"); print_r($strInput); echo ("</div>");
            });
        }
        else {
            add_action('admin_notices', function() use ($strInput) {
                echo ("<div class='alert alert-primary' role='alert'>"); print_r($strInput); echo ("</div>");
            });
        }
    }
    static function htmlDetailHeader(): void {
        // ============ Declaring Variables ============
        # ======== Classes ========
        $OGSyncSettingsData = new OGSyncSettingsData;

        # ======== Variables ========
        # General
        $linkToSite = get_site_url();

        # Site Name
        $strNavbarTitle = get_option($OGSyncSettingsData::$settingPrefix.'siteName');

        # Site Logo
        $strNavbarImg = get_option($OGSyncSettingsData::$settingPrefix.'siteLogo');
        $strNavbarImgWidth = get_option($OGSyncSettingsData::$settingPrefix.'siteLogoWidth');
        $strNavbarImgHeight = get_option($OGSyncSettingsData::$settingPrefix.'siteLogoHeight');

        // ================ Start of Function ================
        echo("
	<head>
		<!-- Links -->
		<link rel='stylesheet' href='".plugins_url('css/bootstrap.min.css', dirname(__DIR__))."'>
		<link rel='stylesheet' href='".plugins_url('css/site-style.css', dirname(__DIR__))."'>
		<!-- Normal -->
		<title></title>
	</head>
	
	<!--==== Navigation ====-->
	<!-- Making a navigation bar that works across the whole site -->
	<nav class='navbar navbar-expand-lg navbar-light bg-light'>
		<div class='container-fluid'>
            <!-- Site Name/Logo -->
            <a href='$linkToSite'><img id='idNavbarImg' src='$strNavbarImg' width='$strNavbarImgWidth' height='$strNavbarImgHeight' alt='Error: Image niet gevonden.'></a>
            
            <!-- Menu Items -->
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
				<ul class='navbar-nav me-auto mb-2 mb-lg-0'>
					<li class='nav-item'>
						<a class='nav-link active' aria-current='page' href='$linkToSite'>Home</a>
					</li>
					<li class='nav-item dropdown'>
						
					</li>
					
				</ul>
			</div>
        </div>
	</nav>
	");
    }
    static function htmlDetailFooter(): void {
        echo("
	<!-- Bootstrap -->
	<script src='".plugins_url('js/bootstrap.bundle.min.js', dirname(__DIR__))."'></script>
	<!-- JQuery -->
	<script src='".plugins_url('js/jquery-3.7.0.min.js', dirname(__DIR__))."'></script>
	");
    }
    static function pre($input): void {
        echo('<pre>'); print_r($input); echo('</pre>');
    }
    static function getLoadTime(): string {
        // tell me how much time this took
        $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        return "This page took $time seconds to load.";
    }
}