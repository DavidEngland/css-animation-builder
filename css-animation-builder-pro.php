<?php
/**
 * Plugin Name: CSS Animation Builder Pro
 * Plugin URI: https://github.com/DavidEngland/css-animation-builder
 * Description: Professional handwriting and typewriter animations for WordPress with live preview admin interface.
 * Version: 1.7.0
 * Author: David England
 * Author URI: https://github.com/DavidEngland
 * License: MIT
 * Text Domain: css-animation-builder
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 * 
 * @package CSSAnimationBuilderPro
 * @author David England
 * @copyright 2025 David England
 * @license MIT
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

// Define plugin constants
define('CAB_VERSION', '1.7.0');
define('CAB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CAB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CAB_BASENAME', plugin_basename(__FILE__));
define('CAB_ASSETS_URL', CAB_PLUGIN_URL . 'assets/');

/**
 * Main CSS Animation Builder Plugin Class
 */
class CSSAnimationBuilderPro {
    
    private static $instance = null;
    private $shortcode_used = false;
    private $settings;
    
    /**
     * Singleton instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->settings = get_option('cab_settings', $this->get_default_settings());
        
        // Core hooks
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'maybe_enqueue_frontend_assets'));
        add_action('wp_footer', array($this, 'init_animations'));
        
        // Admin hooks
        if (is_admin()) {
            add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action('wp_ajax_cab_preview_animation', array($this, 'ajax_preview_animation'));
        }
        
        // Plugin lifecycle
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        
        // Settings link
        add_filter('plugin_action_links_' . CAB_BASENAME, array($this, 'add_settings_link'));
    }
    
    /**
     * Load text domain for translations
     */
    public function load_textdomain() {
        load_plugin_textdomain('css-animation-builder', false, dirname(CAB_BASENAME) . '/languages');
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Register shortcodes
        add_shortcode('css-animation-builder', array($this, 'render_animation_shortcode'));
        add_shortcode('typewriter', array($this, 'render_typewriter_shortcode'));
        add_shortcode('handwriting', array($this, 'render_handwriting_shortcode'));
        
        // Buffer output to detect shortcode usage
        add_action('wp_head', array($this, 'start_output_buffer'));
    }
    
    /**
     * Start output buffer to detect shortcode usage
     */
    public function start_output_buffer() {
        ob_start(array($this, 'detect_shortcodes'));
    }
    
    /**
     * Detect if shortcodes are used in content
     */
    public function detect_shortcodes($content) {
        if (strpos($content, 'cab-animation') !== false) {
            $this->shortcode_used = true;
        }
        return $content;
    }
    
    /**
     * Get default settings
     */
    private function get_default_settings() {
        return array(
            'load_google_fonts' => true,
            'enable_mobile_animations' => true,
            'animation_trigger' => 'viewport', // viewport, click, hover
            'default_speed' => 'normal',
            'enable_sound_effects' => false,
            'preload_animations' => false
        );
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        add_option('cab_version', CAB_VERSION);
        add_option('cab_settings', $this->get_default_settings());
        
        // Create upload directory for custom animations
        $upload_dir = wp_upload_dir();
        $cab_dir = $upload_dir['basedir'] . '/css-animation-builder';
        if (!file_exists($cab_dir)) {
            wp_mkdir_p($cab_dir);
        }
        
        flush_rewrite_rules();
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        flush_rewrite_rules();
    }
    
    /**
     * Add settings link to plugin page
     */
    public function add_settings_link($links) {
        $settings_link = sprintf(
            '<a href="%s">%s</a>',
            admin_url('admin.php?page=css-animation-builder'),
            __('Settings', 'css-animation-builder')
        );
        array_unshift($links, $settings_link);
        return $links;
    }
    
    /**
     * Maybe enqueue frontend assets
     */
    public function maybe_enqueue_frontend_assets() {
        global $post;
        
        $should_load = false;
        
        // Check if shortcodes exist in current post
        if (is_a($post, 'WP_Post')) {
            $content = $post->post_content;
            if (has_shortcode($content, 'css-animation-builder') ||
                has_shortcode($content, 'typewriter') ||
                has_shortcode($content, 'handwriting')) {
                $should_load = true;
            }
        }
        
        // Check for shortcodes in widgets/sidebars
        if (!$should_load && (is_active_sidebar('sidebar-1') || is_active_sidebar('footer-1'))) {
            $should_load = true; // Conservative approach for widgets
        }
        
        if ($should_load || $this->shortcode_used) {
            $this->enqueue_frontend_assets();
        }
    }
    
    /**
     * Enqueue frontend assets
     */
    private function enqueue_frontend_assets() {
        // Google Fonts (conditional)
        if ($this->settings['load_google_fonts']) {
            wp_enqueue_style(
                'cab-google-fonts',
                'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Great+Vibes&family=Caveat:wght@400;600;700&family=Tangerine:wght@400;700&family=Courier+Prime&family=Special+Elite&display=swap',
                array(),
                null
            );
        }
        
        // Plugin CSS
        wp_enqueue_style(
            'cab-frontend-css',
            CAB_ASSETS_URL . 'css/frontend.css',
            array(),
            CAB_VERSION
        );
        
        wp_enqueue_style(
            'cab-animations-css',
            CAB_ASSETS_URL . 'css/animations.css',
            array('cab-frontend-css'),
            CAB_VERSION
        );
        
        // Plugin JavaScript
        wp_enqueue_script(
            'cab-frontend-js',
            CAB_ASSETS_URL . 'js/frontend.js',
            array('jquery'),
            CAB_VERSION,
            true
        );
        
        // Localize script with settings
        wp_localize_script('cab-frontend-js', 'cabSettings', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cab_nonce'),
            'settings' => $this->settings,
            'mobile' => wp_is_mobile()
        ));
    }
    
    /**
     * Initialize animations in footer
     */
    public function init_animations() {
        if ($this->shortcode_used) {
            echo '<script>jQuery(document).ready(function($) { if (window.CSSAnimationBuilder) { window.CSSAnimationBuilder.init(); } });</script>';
        }
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('CSS Animation Builder', 'css-animation-builder'),
            __('CSS Animations', 'css-animation-builder'),
            'manage_options',
            'css-animation-builder',
            array($this, 'admin_page'),
            'dashicons-art',
            30
        );
        
        add_submenu_page(
            'css-animation-builder',
            __('Settings', 'css-animation-builder'),
            __('Settings', 'css-animation-builder'),
            'manage_options',
            'css-animation-builder-settings',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'css-animation-builder') === false) {
            return;
        }
        
        // Google Fonts for admin preview
        wp_enqueue_style(
            'cab-admin-fonts',
            'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Great+Vibes&family=Caveat:wght@400;600;700&family=Tangerine:wght@400;700&family=Courier+Prime&family=Special+Elite&display=swap',
            array(),
            null
        );
        
        // Admin CSS
        wp_enqueue_style(
            'cab-admin-css',
            CAB_ASSETS_URL . 'css/admin.css',
            array(),
            CAB_VERSION
        );
        
        // Include frontend CSS for preview
        wp_enqueue_style(
            'cab-admin-preview-css',
            CAB_ASSETS_URL . 'css/animations.css',
            array('cab-admin-css'),
            CAB_VERSION
        );
        
        // Admin JavaScript
        wp_enqueue_script(
            'cab-admin-js',
            CAB_ASSETS_URL . 'js/admin.js',
            array('jquery', 'wp-color-picker'),
            CAB_VERSION,
            true
        );
        
        // Include frontend JS for preview
        wp_enqueue_script(
            'cab-admin-preview-js',
            CAB_ASSETS_URL . 'js/frontend.js',
            array('cab-admin-js'),
            CAB_VERSION,
            true
        );
        
        // Localize admin script
        wp_localize_script('cab-admin-js', 'cabAdmin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cab_admin_nonce'),
            'strings' => array(
                'copied' => __('Shortcode copied to clipboard!', 'css-animation-builder'),
                'preview' => __('Preview Animation', 'css-animation-builder'),
                'loading' => __('Loading...', 'css-animation-builder')
            )
        ));
        
        // Color picker
        wp_enqueue_style('wp-color-picker');
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('cab_settings_group', 'cab_settings', array($this, 'sanitize_settings'));
    }
    
    /**
     * Sanitize settings
     */
    public function sanitize_settings($input) {
        $sanitized = array();
        
        $sanitized['load_google_fonts'] = !empty($input['load_google_fonts']);
        $sanitized['enable_mobile_animations'] = !empty($input['enable_mobile_animations']);
        $sanitized['animation_trigger'] = sanitize_text_field($input['animation_trigger']);
        $sanitized['default_speed'] = sanitize_text_field($input['default_speed']);
        $sanitized['enable_sound_effects'] = !empty($input['enable_sound_effects']);
        $sanitized['preload_animations'] = !empty($input['preload_animations']);
        
        return $sanitized;
    }
    
    /**
     * Main admin page
     */
    public function admin_page() {
        include CAB_PLUGIN_DIR . 'templates/admin-page.php';
    }
    
    /**
     * Settings page
     */
    public function settings_page() {
        include CAB_PLUGIN_DIR . 'templates/settings-page.php';
    }
    
    /**
     * AJAX preview animation
     */
    public function ajax_preview_animation() {
        check_ajax_referer('cab_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('Insufficient permissions', 'css-animation-builder'));
        }
        
        $type = sanitize_text_field($_POST['type']);
        $text = sanitize_text_field($_POST['text']);
        $style = sanitize_text_field($_POST['style']);
        
        $shortcode = sprintf('[%s text="%s" style="%s"]', $type, $text, $style);
        $output = do_shortcode($shortcode);
        
        wp_send_json_success(array('html' => $output));
    }
    
    /**
     * Render main animation shortcode
     */
    public function render_animation_shortcode($atts, $content = '') {
        $this->shortcode_used = true;
        
        $atts = shortcode_atts(array(
            'type' => 'handwriting',
            'style' => 'quill',
            'text' => $content ?: 'Sample Animation',
            'speed' => $this->settings['default_speed'],
            'trigger' => $this->settings['animation_trigger'],
            'color' => '',
            'size' => '',
            'delay' => '0',
            'duration' => '4s',
            'loop' => 'false',
            'class' => ''
        ), $atts, 'css-animation-builder');
        
        return $this->generate_animation_html($atts);
    }
    
    /**
     * Render typewriter shortcode
     */
    public function render_typewriter_shortcode($atts, $content = '') {
        $this->shortcode_used = true;
        
        $atts = shortcode_atts(array(
            'text' => $content ?: 'Typewriter Effect',
            'speed' => '100',
            'cursor' => '|',
            'sound' => 'false',
            'backspace' => 'false',
            'loop' => 'false'
        ), $atts, 'typewriter');
        
        $animation_atts = array(
            'type' => 'typewriter',
            'text' => $atts['text'],
            'speed' => $atts['speed'],
            'data-cursor' => $atts['cursor'],
            'data-sound' => $atts['sound'],
            'data-backspace' => $atts['backspace'],
            'loop' => $atts['loop']
        );
        
        return $this->generate_animation_html($animation_atts);
    }
    
    /**
     * Render handwriting shortcode
     */
    public function render_handwriting_shortcode($atts, $content = '') {
        $this->shortcode_used = true;
        
        $atts = shortcode_atts(array(
            'text' => $content ?: 'Handwriting Effect',
            'style' => 'quill',
            'speed' => 'normal',
            'pen' => 'fountain'
        ), $atts, 'handwriting');
        
        $animation_atts = array(
            'type' => 'handwriting',
            'style' => $atts['style'],
            'text' => $atts['text'],
            'speed' => $atts['speed'],
            'data-pen' => $atts['pen']
        );
        
        return $this->generate_animation_html($animation_atts);
    }
    
    /**
     * Generate animation HTML
     */
    private function generate_animation_html($atts) {
        $unique_id = 'cab-' . uniqid();
        $type = $atts['type'];
        $text = esc_html($atts['text']);
        
        // Build CSS classes
        $classes = array('cab-animation-wrapper', 'cab-' . $type);
        
        if (!empty($atts['style'])) {
            $classes[] = 'cab-' . $type . '-' . $atts['style'];
        }
        
        if (!empty($atts['class'])) {
            $classes[] = sanitize_html_class($atts['class']);
        }
        
        // Build data attributes
        $data_attrs = array();
        foreach ($atts as $key => $value) {
            if (strpos($key, 'data-') === 0 || in_array($key, array('speed', 'trigger', 'delay', 'duration', 'loop'))) {
                $data_key = strpos($key, 'data-') === 0 ? $key : 'data-' . $key;
                $data_attrs[] = sprintf('%s="%s"', esc_attr($data_key), esc_attr($value));
            }
        }
        
        // Build inline styles
        $styles = array();
        if (!empty($atts['color'])) {
            $styles[] = 'color: ' . sanitize_hex_color($atts['color']);
        }
        if (!empty($atts['size'])) {
            $styles[] = 'font-size: ' . sanitize_text_field($atts['size']);
        }
        
        $style_attr = !empty($styles) ? ' style="' . implode('; ', $styles) . '"' : '';
        
        // Generate HTML
        $html = sprintf(
            '<div id="%s" class="%s" data-text="%s" %s%s><span class="cab-text">%s</span></div>',
            esc_attr($unique_id),
            esc_attr(implode(' ', $classes)),
            esc_attr($text),
            implode(' ', $data_attrs),
            $style_attr,
            $text
        );
        
        return $html;
    }
}

// Initialize the plugin
CSSAnimationBuilderPro::getInstance();
