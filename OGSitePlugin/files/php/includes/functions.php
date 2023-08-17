<?php
// ========= Imports =========
include_once 'classes.php';

// ============ Functions ============
class OGSiteTools {
    // ============ HTML Functions ============
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
    static function htmlAdminHeader($title): void {
        echo("
	<head>
		<link rel='stylesheet' href='".plugins_url('css/bootstrap.min.css', dirname(__DIR__))."'>
		<link rel='stylesheet' href='".plugins_url('css/style.css', dirname(__DIR__))."'>
	</head>
	<header>
		<div class='container-fluid'>
			<!-- Having the logo and title next to each other -->
			<img src='".plugins_url('img/pixelplus-logo.jpg', dirname(__DIR__))."' alt='Pixelplus Logo'>
		
            <div class='div-Header'>
                <span class='floatLeft'><h1><b>$title</b></h1></span>
                <span class='floatRight'><h5>".self::welcomeMessage()."</h5></span>
            </div>
        </div>
	</header>
	<hr/>
	");
    }
    static function htmlAdminFooter($title=''): void {
        echo("
	<!-- Bootstrap -->
	<script src='".plugins_url('js/bootstrap.bundle.min.js', dirname(__DIR__))."'></script>
	<!-- JQuery -->
	<script src='".plugins_url('js/jquery-3.7.0.min.js', dirname(__DIR__))."'></script>
	");
    }
    static function htmlDetailHeader(): void {
        // ============ Declaring Variables ============
        # ======== Classes ========
        $OGSiteSettingsData = new OGSiteSettingsData;

        # ======== Variables ========
        # General
        $linkToSite = get_site_url();

        # Site Name
        $strNavbarTitle = get_option($OGSiteSettingsData::$settingPrefix.'siteName');

        # Site Logo
        $strNavbarImg = get_option($OGSiteSettingsData::$settingPrefix.'siteLogo');
        $strNavbarImgWidth = get_option($OGSiteSettingsData::$settingPrefix.'siteLogoWidth');
        $strNavbarImgHeight = get_option($OGSiteSettingsData::$settingPrefix.'siteLogoHeight');

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
    static function welcomeMessage(): string {
        $welcomeMessage = "Welkom";
        $wpUser = _wp_get_current_user();

        if ($wpUser->user_firstname != "") {
            $welcomeMessage .= " ".$wpUser->user_firstname;
        }
        else {
            $welcomeMessage .= " ".$wpUser->user_login;
        }
        return $welcomeMessage;
    }

    // ============ JS Functions ============
    static function hidePasswordByName($name): void {
        echo("
    <script>
        // ======== Declaring Variables ========
        let passwordTextField = document.getElementsByName('$name')[0];
        
        // ======== Functions ========
        function showPassword() {
            if (passwordTextField.type === 'password') {
                passwordTextField.type = 'text';
                document.getElementsByName('$name')[0].type = 'text';
                document.getElementsByClassName('eye')[0].src = '" .plugins_url('img/eye-slash.svg', dirname(__DIR__))."';
            }
            else {
                passwordTextField.type = 'password';
                document.getElementsByClassName('eye')[0].src = '".plugins_url('img/eye.svg', dirname(__DIR__))."';
            }
        }
        
        // ======== Start of Function ========
        // Hide password
        passwordTextField.type = 'password';
        
        // Creating a test button
        button = document.getElementsByName('$name')[0].insertAdjacentHTML('afterend', '<img width=\"37px\" src=\"".plugins_url('img/eye.svg', dirname(__DIR__))."\" alt=\"Show Password\" class=\"eye\" onclick=\"showPassword()\">');
        // Giving the button a cursor pointer
        document.getElementsByClassName('eye')[0].style.cursor = 'pointer';
        // A bit of margin to the right
        document.getElementsByClassName('eye')[0].style.marginLeft = '14px';
    </script>
    ");
    }

    // ============ Normal Functions ============
    static function getJSONFromAPI($url, $args=null) {
        // ======== Start of Function ========
        // Get data from API
        $response = wp_remote_get($url, $args);

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            $response_code = wp_remote_retrieve_response_code($response);
            $response_body = wp_remote_retrieve_body($response);
            // Log or display the error information for debugging
            error_log("WP_Error: $error_message, Response Code: $response_code, Response Body: $response_body");

            // Return data
            return $response;
        }
        else {
            return json_decode($response['body'], true);
        }
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
                OGSiteTools::adminNotice('info', '<h1>Page was not created</h1>');
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
                        OGSiteTools::adminNotice('info', '<h1>Child Page was not created</h1>');
                    }
                }
            }

            // Checking if the page is supposed to be the homepage
            if ($wordpressPage['boolIsFrontPage']) {
                // Setting the page as the homepage
                update_option('page_on_front', $pageID);
                update_option('show_on_front', 'page');

                OGSiteTools::adminNotice('info', '<h1>Page is created</h1>');
            }
        }
    }
}