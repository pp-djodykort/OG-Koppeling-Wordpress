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

    static function createWordpressPages(): void {
        // ======== Declaring Variables ========
        # Variables
        $arrWordpressPages = OGSiteSettingsData::arrPages();

        // ======== Start of Function ========
        // Creating the pages
        foreach ($arrWordpressPages as $wordpressPageKey => $wordpressPage) {
            // ==== Declaring Variables ====
            # Variables
            $pageQuery = new WP_Query([
                'post_type' => 'page',
                'post_status' => ['any', 'trash'],
                'meta_key' => 'pageID',
                'meta_value' => $wordpressPage['pageID'],
            ]);
            $pageExists = $pageQuery->have_posts();

            // ==== Start of Function ====
            # IF the page exists then continue
            if ($pageExists) {
                // Don't need to do anything
                continue;
            }

            // Creating the page
            $pageID = wp_insert_post([
                'post_title' => $wordpressPage['pageTitle'],
                'post_content' => $wordpressPage['pageContent'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_slug' => $wordpressPage['pageSlug'],
                'page_template' => $wordpressPage['templateFile'],
                'meta_input' => [
                    'pageID' => $wordpressPage['pageID'],
                ],
            ]);

            // Checking if the page was created
            if ($pageID == 0) {
                // Page was not created
                OGSyncTools::adminNotice('info', '<h1>Page was not created</h1>');
                continue;
            }

            // Checking the child pages
            if (isset($wordpressPage['childPages'])) {
                // Creating the child pages
                foreach ($wordpressPage['childPages'] as $childPageKey => $childPage) {
                    // Creating the child page
                    $childPageID = wp_insert_post([
                        'post_title' => $childPage['pageTitle'],
                        'post_content' => $childPage['pageContent'],
                        'post_status' => 'publish',
                        'post_type' => 'page',
                        'post_slug' => $childPage['pageSlug'],
                        'page_template' => $childPage['templateFile'],
                        'post_parent' => $pageID,
                        'meta_input' => [
                            'pageID' => $childPage['pageID'],
                        ],
                    ]);

                    // Checking if the page was created
                    if ($childPageID == 0) {
                        // Page was not created
                        OGSyncTools::adminNotice('info', '<h1>Child Page was not created</h1>');
                    }
                }
            }

            // Checking if the page is supposed to be the homepage
            if ($wordpressPage['boolIsFrontPage']) {
                // Setting the page as the homepage
                update_option('page_on_front', $pageID);
                update_option('show_on_front', 'page');

                OGSyncTools::adminNotice('info', '<h1>Page is created</h1>');
            }
        }
    }
}