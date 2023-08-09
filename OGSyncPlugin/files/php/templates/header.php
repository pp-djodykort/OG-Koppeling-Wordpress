<?php
// ============ Declaring Variables ============
$bootstrapCSSPath = plugins_url('css/bootstrap.min.css', dirname(__DIR__));
print_r($bootstrapCSSPath);
// ============ Functions ============
function enqueue_styles() {

}

// ============ Start of Header template ============
remove_action('wp_head', 'wp_generator');