<?php
// ========= Imports =========
include_once 'classes.php';

// ============ Functions ============
class OGSyncTools {
	// ============ HTML Functions ============
	static function pre($input): void {
		echo('<pre>'); print_r($input); echo('</pre>');
	}
	static function br(): void {
		echo("<br/>");
	}
	static function htmlAdminHeader($title): void {
		echo("
		<head>
			<link rel='stylesheet' href='".plugins_url('css/bootstrap.min.css', dirname(__DIR__))."'>
			<link rel='stylesheet' href='".plugins_url('css/style.css', dirname(__DIR__))."'>
		</head>
		<header>
			<div class='container-fluid'>			
	            <div class='div-Header'>
	                <span class='floatLeft'><h1><b>$title</b></h1></span>
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
	static function getLoadTime(): string {
		// tell me how much time this took
		$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
		return "This page took $time seconds to load.";
	}
	static function removeParentheses ($string): array|string {
		// ======== Start of Function ========
		// Removing the parentheses from the string and returning it
		return str_replace(")", "", str_replace("(", "", $string));
	}
	static function isConditional($dbString): bool {
		// ======== Start of Function ========
		# Check if the string is empty or null
		if (empty($dbString) || $dbString == null) {
			return false;
		}
		# Checking if the string is an coditional based off the first and last character
		elseif (str_starts_with($dbString, "(") && str_ends_with($dbString, ")")){
			return true;
		}
		else {
			return false;
		}
	}
	static function isNumericBasedOffMetaKey($meta_key): bool {
		// ======== Declaring Variables ========
		# Globals
		global $wpdb;

		// ======== Start of Function ========
		$meta_values = $wpdb->get_col($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s", $meta_key));
		foreach ($meta_values as $meta_value) {
			if (!is_numeric($meta_value)) {
				return false;
			}
		}

		return true;
	}
	static function getThumbnailOfPost($postID) {
		$postThumbnail = new WP_Query([
			'post_type' => 'attachment',
			'posts_per_page' => 1,
			'post_status' => 'any',
			'post_parent' => $postID,
			'post_excerpt' => 'HOOFDFOTO'
		]);
		if ($postThumbnail->have_posts()) {
			// ==== Start of Function ====
			# Making it thumbnail sized
			return wp_get_attachment_image_src($postThumbnail->post->ID, 'thumbnail')[0] ?? '';
		}
		return '';
	}
	static function checkIfAanbodColumnThumbnail($column, $post_id): void {
		if (strtolower($column) == 'thumbnail') {
			$imgSource = OGSyncTools::getThumbnailOfPost($post_id);
			if (!empty($imgSource)) {
				echo("<img style='width: ".'-webkit-fill-available'.";' src='$imgSource' alt='Thumbnail niet beschikbaar'/>");
			}

		}
	}
}