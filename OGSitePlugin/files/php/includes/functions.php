<?php
// ========= Imports =========
include_once 'classes.php';

// ============ Functions ============
class OGSiteTools {
    // ============ HTML Functions ============
    static function htmlAdminHeader(string $title): void {
        echo("
		<head>
			<link rel='stylesheet' href='".plugins_url('css/bootstrap.min.css', dirname(__DIR__))."'>
			<link rel='stylesheet' href='".plugins_url('css/style.css', dirname(__DIR__))."'>
		</head>	
				<!-- Showing the header -->
		<header>
			<div class='container-fluid'>
	            <div class='div-Header'>
	                <div class='floatLeft'><h1><b>$title</b></h1></div>
	            </div>
	        </div>
		</header>
		<hr/>
		");
    }
    static function htmlAdminFooter(string $title=''): void {
        echo("
	<!-- Bootstrap -->
	<script src='".plugins_url('js/bootstrap.bundle.min.js', dirname(__DIR__))."'></script>
	<!-- JQuery -->
	<script src='".plugins_url('js/jquery-3.7.1.min.js', dirname(__DIR__))."'></script>
	");
    }
    static function adminNotice($type, $input): void {
        if ($type == "error") {
            add_action('admin_notices', function() use ($input) {
                echo ("<div class='alert alert-danger' role='alert'>"); print_r($input); echo ("</div>");
            });
        }
        else if ($type == "success") {
            add_action('admin_notices', function() use ($input) {
                echo ("<div class='alert alert-success' role='alert'>"); print_r($input); echo ("</div>");
            });
        }
        else if ($type == "warning") {
            add_action('admin_notices', function() use ($input) {
                echo ("<div class='alert alert-warning' role='alert'>"); print_r($input); echo ("</div>");
            });
        }
        else if ($type == "info") {
            add_action('admin_notices', function() use ($input) {
                echo ("<div class='alert alert-info' role='alert'>"); print_r($input); echo ("</div>");
            });
        }
        else {
            add_action('admin_notices', function() use ($input) {
                echo ("<div class='alert alert-primary' role='alert'>"); print_r($input); echo ("</div>");
            });
        }
    }
    static function pre($input): void {
        echo('<pre>'); print_r($input); echo('</pre>');
    }
    static function br(): void {
        echo("<br/>");
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
}