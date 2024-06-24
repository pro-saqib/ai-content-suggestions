<?php

class AI_Content_Suggestions {

    private static $instance = null;

    private function __construct() {
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Enqueue scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));

        // Add meta box to post editor
        add_action('add_meta_boxes', array($this, 'add_meta_box'));

        // Register AJAX handlers
        add_action('wp_ajax_ai_get_suggestions', array($this, 'ajax_get_suggestions'));
    }

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function add_admin_menu() {
        add_menu_page(
            'AI Content Suggestions',
            'AI Content Suggestions',
            'manage_options',
            'ai-content-suggestions',
            array($this, 'admin_page')
        );
    }

    public function admin_page() {
        require_once AI_CS_PATH . 'admin/ai-content-suggestions-admin.php';
    }

    public function enqueue_assets($hook) {
        if ($hook != 'post.php' && $hook != 'post-new.php') {
            return;
        }
        wp_enqueue_style('ai-content-suggestions', AI_CS_URL . 'assets/css/ai-content-suggestions.css');
        wp_enqueue_script('ai-content-suggestions', AI_CS_URL . 'assets/js/ai-content-suggestions.js', array('jquery'), null, true);
        wp_localize_script('ai-content-suggestions', 'aiContentSuggestions', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ai_content_suggestions_nonce')
        ));
    }

    public function add_meta_box() {
        add_meta_box(
            'ai_content_suggestions_meta',
            'AI Content Suggestions',
            array($this, 'meta_box_callback'),
            'post',
            'side'
        );
    }

    public function meta_box_callback($post) {
        ?>
        <div id="ai-content-suggestions">
            <h4>Analyze Your Content</h4>
            <?php wp_nonce_field('ai_content_suggestions_nonce', 'ai_content_suggestions_nonce'); ?>
            <textarea id="ai-content" rows="5" style="width:100%;"></textarea>
            <button type="button" id="analyze-content" class="button">Analyze</button>
            <div id="ai-suggestions"></div>
        </div>
        <?php
    }

    public function ajax_get_suggestions() {
        check_ajax_referer('ai_content_suggestions_nonce', 'nonce');

        $content = sanitize_text_field($_POST['content']);
        $suggestions = call_ai_service($content);

        echo esc_html($suggestions);
        wp_die();
    }
}

?>
