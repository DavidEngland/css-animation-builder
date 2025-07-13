<?php
/**
 * CSS Animation Builder - Legacy Fixed Version
 * 
 * This is a backup/legacy version. The main plugin is css-animation-builder-pro.php
 * Do not activate this file as a WordPress plugin.
 * 
 * @package CSSAnimationBuilder
 * @author David England
 * @version 1.4.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CSS_ANIMATION_BUILDER_VERSION', '1.4.0');
define('CSS_ANIMATION_BUILDER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CSS_ANIMATION_BUILDER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CSS_ANIMATION_BUILDER_BASENAME', plugin_basename(__FILE__));

/**
 * Main Plugin Class
 */
class CSSAnimationBuilder {
    
    private static $instance = null;
    private $shortcodes_used = false;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'conditionally_enqueue_assets'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        // Register shortcodes
        add_shortcode('css-animation', array($this, 'render_css_animation'));
        add_shortcode('typewriter', array($this, 'render_typewriter'));
        add_shortcode('handwriting', array($this, 'render_handwriting'));
        
        // Admin interface
        if (is_admin()) {
            add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        }
        
        // Add settings link
        add_filter('plugin_action_links_' . CSS_ANIMATION_BUILDER_BASENAME, array($this, 'add_settings_link'));
    }
    
    public function activate() {
        add_option('css_animation_builder_version', CSS_ANIMATION_BUILDER_VERSION);
        add_option('css_animation_builder_settings', array(
            'load_google_fonts' => true,
            'enable_mobile_animations' => true,
            'default_animation_speed' => 'normal'
        ));
    }
    
    public function deactivate() {
        // Clean up if needed
    }
    
    public function add_settings_link($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=css-animation-builder') . '">' . __('Settings', 'css-animation-builder') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
    
    public function conditionally_enqueue_assets() {
        // Only enqueue if shortcodes are used
        if ($this->has_shortcode_in_content()) {
            $this->enqueue_frontend_assets();
        }
    }
    
    private function has_shortcode_in_content() {
        global $post;
        if (is_a($post, 'WP_Post')) {
            return (
                has_shortcode($post->post_content, 'css-animation') ||
                has_shortcode($post->post_content, 'typewriter') ||
                has_shortcode($post->post_content, 'handwriting')
            );
        }
        return false;
    }
    
    public function enqueue_frontend_assets() {
        // Google Fonts
        $settings = get_option('css_animation_builder_settings', array());
        if (!empty($settings['load_google_fonts'])) {
            wp_enqueue_style(
                'css-animation-builder-fonts',
                'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Great+Vibes&family=Caveat:wght@400;600;700&family=Tangerine:wght@400;700&display=swap',
                array(),
                null
            );
        }
        
        // Plugin CSS
        wp_enqueue_style(
            'css-animation-builder-styles',
            CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/css/handwriting-animations.css',
            array(),
            CSS_ANIMATION_BUILDER_VERSION
        );
        
        // Plugin JS (only when needed)
        wp_enqueue_script(
            'css-animation-builder-scripts',
            CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/js/frontend-animations.js',
            array('jquery'),
            CSS_ANIMATION_BUILDER_VERSION,
            true
        );
    }
    
    public function enqueue_admin_assets($hook) {
        if ($hook !== 'toplevel_page_css-animation-builder') {
            return;
        }
        
        wp_enqueue_style(
            'css-animation-builder-admin',
            CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            CSS_ANIMATION_BUILDER_VERSION
        );
        
        wp_enqueue_script(
            'css-animation-builder-admin',
            CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            CSS_ANIMATION_BUILDER_VERSION,
            true
        );
    }
    
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
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('CSS Animation Builder', 'css-animation-builder'); ?></h1>
            
            <div class="css-animation-admin">
                <div class="admin-section">
                    <h2><?php _e('Shortcode Examples', 'css-animation-builder'); ?></h2>
                    
                    <h3><?php _e('Handwriting Animations', 'css-animation-builder'); ?></h3>
                    <div class="shortcode-examples">
                        <p><strong>Quill Style:</strong></p>
                        <code>[css-animation class="handwriting-quill" text="Your Text Here"]</code>
                        
                        <p><strong>Fountain Pen:</strong></p>
                        <code>[css-animation class="handwriting-fountain" text="Elegant Writing"]</code>
                        
                        <p><strong>Casual Script:</strong></p>
                        <code>[css-animation class="handwriting-casual" text="Friendly Message"]</code>
                        
                        <p><strong>Signature Style:</strong></p>
                        <code>[css-animation class="handwriting-signature" text="Your Name"]</code>
                    </div>
                    
                    <h3><?php _e('Custom Duration', 'css-animation-builder'); ?></h3>
                    <code>[css-animation class="handwriting-quill" text="Slow Animation" duration="6s"]</code>
                    
                    <h3><?php _e('Live Preview', 'css-animation-builder'); ?></h3>
                    <div class="live-preview">
                        <div class="handwriting-demo handwriting-quill">CSS Animation Builder</div>
                    </div>
                </div>
                
                <div class="admin-section">
                    <h2><?php _e('Settings', 'css-animation-builder'); ?></h2>
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('css_animation_builder_settings');
                        $settings = get_option('css_animation_builder_settings', array());
                        ?>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e('Load Google Fonts', 'css-animation-builder'); ?></th>
                                <td>
                                    <input type="checkbox" name="css_animation_builder_settings[load_google_fonts]" value="1" <?php checked(!empty($settings['load_google_fonts'])); ?> />
                                    <p class="description"><?php _e('Automatically load Google Fonts for handwriting styles', 'css-animation-builder'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e('Mobile Animations', 'css-animation-builder'); ?></th>
                                <td>
                                    <input type="checkbox" name="css_animation_builder_settings[enable_mobile_animations]" value="1" <?php checked(!empty($settings['enable_mobile_animations'])); ?> />
                                    <p class="description"><?php _e('Enable animations on mobile devices', 'css-animation-builder'); ?></p>
                                </td>
                            </tr>
                        </table>
                        <?php submit_button(); ?>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    
    public function render_css_animation($atts, $content = '') {
        $atts = shortcode_atts(array(
            'class' => 'handwriting-quill',
            'text' => $content ?: 'Sample Text',
            'duration' => '4s',
            'style' => ''
        ), $atts, 'css-animation');
        
        // Mark that shortcodes are used
        $this->shortcodes_used = true;
        
        // Generate unique ID
        $unique_id = 'css-anim-' . uniqid();
        
        // Sanitize attributes
        $class = sanitize_html_class($atts['class']);
        $text = esc_html($atts['text']);
        $duration = sanitize_text_field($atts['duration']);
        $style = sanitize_text_field($atts['style']);
        
        // Build output
        $output = sprintf(
            '<div id="%s" class="css-animation-wrapper %s" data-text="%s" data-duration="%s" style="%s">%s</div>',
            esc_attr($unique_id),
            esc_attr($class),
            esc_attr($text),
            esc_attr($duration),
            esc_attr($style),
            $text
        );
        
        return $output;
    }
    
    public function render_typewriter($atts, $content = '') {
        $atts = shortcode_atts(array(
            'text' => $content ?: 'Typewriter Text',
            'speed' => '100',
            'cursor' => '|'
        ), $atts, 'typewriter');
        
        return $this->render_css_animation(array(
            'class' => 'typewriter-effect',
            'text' => $atts['text'],
            'data-speed' => $atts['speed'],
            'data-cursor' => $atts['cursor']
        ));
    }
    
    public function render_handwriting($atts, $content = '') {
        $atts = shortcode_atts(array(
            'text' => $content ?: 'Handwriting Text',
            'style' => 'quill',
            'speed' => 'normal'
        ), $atts, 'handwriting');
        
        $class_map = array(
            'quill' => 'handwriting-quill',
            'fountain' => 'handwriting-fountain',
            'casual' => 'handwriting-casual',
            'formal' => 'handwriting-formal',
            'signature' => 'handwriting-signature'
        );
        
        $class = isset($class_map[$atts['style']]) ? $class_map[$atts['style']] : 'handwriting-quill';
        
        return $this->render_css_animation(array(
            'class' => $class,
            'text' => $atts['text']
        ));
    }
}

// Initialize plugin
add_action('plugins_loaded', function() {
    CSSAnimationBuilder::getInstance();
});

// Settings registration
add_action('admin_init', function() {
    register_setting('css_animation_builder_settings', 'css_animation_builder_settings');
});
?>
