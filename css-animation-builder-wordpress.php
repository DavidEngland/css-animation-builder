<?php
/**
 * Plugin Name: CSS Animation Builder
 * Plugin URI: https://github.com/DavidEngland/css-animation-builder
 * Description: Advanced CSS animation builder with typewriter and handwriting effects. Developed by Real Estate Intelligence Agency (REIA).
 * Version: 1.6.0
 * Author: David England
 * Author URI: https://github.com/DavidEngland
 * License: MIT
 * Text Domain: css-animation-builder
 * Domain Path: /languages
 * 
 * @package CSSAnimationBuilder
 * @author David England <DavidEngland@hotmail.com>
 * @copyright 2025 Real Estate Intelligence Agency (REIA)
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CSS_ANIMATION_BUILDER_VERSION', '1.1.0');
define('CSS_ANIMATION_BUILDER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CSS_ANIMATION_BUILDER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Autoload classes
spl_autoload_register(function ($class) {
    $prefix = 'Reia\\CSSAnimationBuilder\\';
    $base_dir = CSS_ANIMATION_BUILDER_PLUGIN_DIR . 'src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Initialize plugin
add_action('plugins_loaded', function() {
    // Initialize WordPress integration
    \Reia\CSSAnimationBuilder\WordPressPlugin::getInstance();
});

// Activation hook
register_activation_hook(__FILE__, function() {
    // Create database tables if needed
    // Set default options
    add_option('css_animation_builder_version', CSS_ANIMATION_BUILDER_VERSION);
    add_option('css_animation_builder_settings', [
        'default_theme' => 'default',
        'enable_typewriter' => true,
        'enable_handwriting' => true,
        'enable_advanced_features' => true
    ]);
});

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    // Clean up if needed
});

// Uninstall hook
register_uninstall_hook(__FILE__, function() {
    // Remove options
    delete_option('css_animation_builder_version');
    delete_option('css_animation_builder_settings');
});

// Add settings link to plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links) {
    $settings_link = '<a href="' . admin_url('admin.php?page=css-animation-builder') . '">' . __('Settings', 'css-animation-builder') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
});

// Quick shortcode examples for testing
add_shortcode('typewriter', function($atts, $content = '') {
    $atts = shortcode_atts([
        'speed' => '100',
        'cursor' => '|',
        'theme' => 'default',
        'text' => $content
    ], $atts);
    
    $unique_id = 'typewriter-' . uniqid();
    
    wp_enqueue_script(
        'css-animation-builder-typewriter',
        CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/js/typewriter-animation.js',
        [],
        CSS_ANIMATION_BUILDER_VERSION,
        true
    );
    
    wp_enqueue_style(
        'css-animation-builder-text',
        CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/css/text-animations.css',
        [],
        CSS_ANIMATION_BUILDER_VERSION
    );
    
    ob_start();
    ?>
    <div id="<?php echo esc_attr($unique_id); ?>" class="typewriter-animation <?php echo esc_attr($atts['theme']); ?>"></div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const typewriter = new TypewriterAnimation('#<?php echo esc_js($unique_id); ?>', {
            speed: <?php echo intval($atts['speed']); ?>,
            cursor: '<?php echo esc_js($atts['cursor']); ?>',
            cursorBlink: true,
            humanize: true
        });
        typewriter.type('<?php echo esc_js($atts['text']); ?>');
    });
    </script>
    <?php
    return ob_get_clean();
});

add_shortcode('handwriting', function($atts, $content = '') {
    $atts = shortcode_atts([
        'speed' => '50',
        'style' => 'cursive',
        'color' => 'var(--text-primary)',
        'text' => $content
    ], $atts);
    
    $unique_id = 'handwriting-' . uniqid();
    
    wp_enqueue_script(
        'css-animation-builder-handwriting',
        CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/js/handwriting-animation.js',
        [],
        CSS_ANIMATION_BUILDER_VERSION,
        true
    );
    
    wp_enqueue_style(
        'css-animation-builder-text',
        CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/css/text-animations.css',
        [],
        CSS_ANIMATION_BUILDER_VERSION
    );
    
    ob_start();
    ?>
    <div id="<?php echo esc_attr($unique_id); ?>" class="handwriting-animation <?php echo esc_attr($atts['style']); ?>" style="min-height: var(--layout-min-height-md); display: flex; align-items: center; justify-content: center; font-size: var(--font-size-xxl);"></div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const handwriting = new HandwritingAnimation('#<?php echo esc_js($unique_id); ?>', {
            speed: <?php echo intval($atts['speed']); ?>,
            strokeColor: '<?php echo esc_js($atts['color']); ?>',
            style: '<?php echo esc_js($atts['style']); ?>',
            penType: '<?php echo esc_js($atts['style']); ?>' === 'old-english' ? 'quill' : 'fountain'
        });
        handwriting.writeText('<?php echo esc_js($atts['text']); ?>');
    });
    </script>
    <?php
    return ob_get_clean();
});
