<?php
/*
Plugin Name: AI-Powered Content Suggestions
Description: Provides AI-powered content suggestions for WordPress posts.
Version: 1.0
Author: ProSaqib
*/

// Define constants
define('AI_CS_PATH', plugin_dir_path(__FILE__));
define('AI_CS_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once AI_CS_PATH . 'includes/class-ai-content-suggestions.php';
require_once AI_CS_PATH . 'includes/ai-api.php';

// Initialize the plugin
function ai_content_suggestions_init() {
    AI_Content_Suggestions::get_instance();
}
add_action('plugins_loaded', 'ai_content_suggestions_init');
?>
