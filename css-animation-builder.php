<?php
/**
 * Plugin Name: CSS Animation Builder
 * Plugin URI: https://github.com/DavidEngland/css-animation-builder
 * Description: A standalone CSS Animation Builder that provides an interactive interface for creating beautiful CSS animations. Developed by Real Estate Intelligence Agency (REIA). Works as a Composer package, WordPress plugin, or standalone HTML/JS application.
 * Version: 1.0.1
 * Author: David England (REIA - Real Estate Intelligence Agency)
 * Author URI: https://github.com/DavidEngland
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: css-animation-builder
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 * 
 * @package CSSAnimationBuilder
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CSS_ANIMATION_BUILDER_VERSION', '1.0.1');
define('CSS_ANIMATION_BUILDER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CSS_ANIMATION_BUILDER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CSS_ANIMATION_BUILDER_PLUGIN_FILE', __FILE__);

// Load Composer autoloader if it exists
if (file_exists(CSS_ANIMATION_BUILDER_PLUGIN_DIR . 'vendor/autoload.php')) {
    require_once CSS_ANIMATION_BUILDER_PLUGIN_DIR . 'vendor/autoload.php';
} else {
    // Fallback: manually load classes
    require_once CSS_ANIMATION_BUILDER_PLUGIN_DIR . 'src/Builder.php';
    require_once CSS_ANIMATION_BUILDER_PLUGIN_DIR . 'src/WordPressPlugin.php';
}

use Reia\CSSAnimationBuilder\WordPressPlugin;

/**
 * Main plugin class
 */
class CSSAnimationBuilderMain
{
    /**
     * Plugin instance
     * 
     * @var CSSAnimationBuilderMain
     */
    private static $instance = null;

    /**
     * WordPress plugin instance
     * 
     * @var WordPressPlugin
     */
    private $plugin;

    /**
     * Get plugin instance
     * 
     * @return CSSAnimationBuilderMain
     */
    public static function getInstance(): CSSAnimationBuilderMain
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private constructor
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * Initialize plugin
     * 
     * @return void
     */
    private function init()
    {
        // Check WordPress version
        if (!$this->checkWordPressVersion()) {
            return;
        }

        // Initialize WordPress plugin
        $this->plugin = WordPressPlugin::getInstance();

        // Hook into WordPress
        add_action('plugins_loaded', [$this, 'loadTextDomain']);
        add_action('wp_enqueue_scripts', [$this, 'enqueuePublicAssets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
        
        // Plugin lifecycle hooks
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        register_uninstall_hook(__FILE__, [__CLASS__, 'uninstall']);

        // Add settings link to plugins page
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'addSettingsLink']);
        
        // Add plugin meta links
        add_filter('plugin_row_meta', [$this, 'addPluginMeta'], 10, 2);
    }

    /**
     * Check WordPress version compatibility
     * 
     * @return bool
     */
    private function checkWordPressVersion(): bool
    {
        global $wp_version;
        
        $required_version = '5.0';
        
        if (version_compare($wp_version, $required_version, '<')) {
            add_action('admin_notices', function() use ($required_version) {
                echo '<div class="notice notice-error"><p>';
                printf(
                    __('CSS Animation Builder requires WordPress %s or higher. Please update WordPress.', 'css-animation-builder'),
                    $required_version
                );
                echo '</p></div>';
            });
            return false;
        }
        
        return true;
    }

    /**
     * Load text domain
     * 
     * @return void
     */
    public function loadTextDomain()
    {
        load_plugin_textdomain(
            'css-animation-builder',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }

    /**
     * Enqueue public assets
     * 
     * @return void
     */
    public function enqueuePublicAssets()
    {
        // Only enqueue if shortcode or block is present
        if ($this->shouldEnqueueAssets()) {
            wp_enqueue_style(
                'css-animation-builder-public',
                CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/css/public.css',
                [],
                CSS_ANIMATION_BUILDER_VERSION
            );

            wp_enqueue_script(
                'css-animation-builder-public',
                CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/js/public.js',
                ['jquery'],
                CSS_ANIMATION_BUILDER_VERSION,
                true
            );

            wp_localize_script('css-animation-builder-public', 'cssAnimationBuilderPublic', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('css_animation_builder_nonce'),
                'pluginUrl' => CSS_ANIMATION_BUILDER_PLUGIN_URL,
                'version' => CSS_ANIMATION_BUILDER_VERSION
            ]);
        }
    }

    /**
     * Enqueue admin assets
     * 
     * @param string $hook Current admin page hook
     * @return void
     */
    public function enqueueAdminAssets($hook)
    {
        // Only load on our admin pages
        if (strpos($hook, 'css-animation-builder') !== false) {
            wp_enqueue_style(
                'css-animation-builder-admin',
                CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/css/admin.css',
                [],
                CSS_ANIMATION_BUILDER_VERSION
            );

            wp_enqueue_script(
                'css-animation-builder-admin',
                CSS_ANIMATION_BUILDER_PLUGIN_URL . 'assets/js/admin.js',
                ['jquery', 'wp-color-picker'],
                CSS_ANIMATION_BUILDER_VERSION,
                true
            );

            wp_localize_script('css-animation-builder-admin', 'cssAnimationBuilderAdmin', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('css_animation_builder_admin_nonce'),
                'pluginUrl' => CSS_ANIMATION_BUILDER_PLUGIN_URL,
                'version' => CSS_ANIMATION_BUILDER_VERSION,
                'strings' => [
                    'copied' => __('Copied!', 'css-animation-builder'),
                    'error' => __('Error copying to clipboard', 'css-animation-builder'),
                    'success' => __('Success!', 'css-animation-builder')
                ]
            ]);
        }
    }

    /**
     * Check if assets should be enqueued
     * 
     * @return bool
     */
    private function shouldEnqueueAssets(): bool
    {
        global $post;
        
        // Check for shortcode in post content
        if ($post && has_shortcode($post->post_content, 'css-animation-builder')) {
            return true;
        }
        
        // Check for block in post content
        if ($post && has_block('css-animation-builder/animation-builder', $post)) {
            return true;
        }
        
        // Check for specific page templates
        if (is_page_template('page-animation-generator.php')) {
            return true;
        }
        
        return false;
    }

    /**
     * Plugin activation
     * 
     * @return void
     */
    public function activate()
    {
        // Create options with default values
        add_option('css_animation_builder_version', CSS_ANIMATION_BUILDER_VERSION);
        add_option('css_animation_builder_settings', [
            'enable_shortcode' => true,
            'enable_block' => true,
            'enable_admin_page' => true,
            'default_theme' => 'default',
            'cache_duration' => 3600
        ]);

        // Flush rewrite rules
        flush_rewrite_rules();

        // Log activation
        error_log('CSS Animation Builder activated - Version: ' . CSS_ANIMATION_BUILDER_VERSION);
    }

    /**
     * Plugin deactivation
     * 
     * @return void
     */
    public function deactivate()
    {
        // Clear any scheduled events
        wp_clear_scheduled_hook('css_animation_builder_cleanup');
        
        // Flush rewrite rules
        flush_rewrite_rules();

        // Log deactivation
        error_log('CSS Animation Builder deactivated');
    }

    /**
     * Plugin uninstall
     * 
     * @return void
     */
    public static function uninstall()
    {
        // Remove options
        delete_option('css_animation_builder_version');
        delete_option('css_animation_builder_settings');
        
        // Remove any transients
        delete_transient('css_animation_builder_cache');
        
        // Clean up any files
        $upload_dir = wp_upload_dir();
        $plugin_folder = $upload_dir['basedir'] . '/css-animation-builder/';
        if (is_dir($plugin_folder)) {
            array_map('unlink', glob($plugin_folder . '*'));
            rmdir($plugin_folder);
        }

        // Log uninstall
        error_log('CSS Animation Builder uninstalled');
    }

    /**
     * Add settings link to plugins page
     * 
     * @param array $links Plugin action links
     * @return array Modified links
     */
    public function addSettingsLink($links): array
    {
        $settings_link = sprintf(
            '<a href="%s">%s</a>',
            admin_url('admin.php?page=css-animation-builder'),
            __('Settings', 'css-animation-builder')
        );
        
        array_unshift($links, $settings_link);
        
        return $links;
    }

    /**
     * Add plugin meta links
     * 
     * @param array $links Plugin meta links
     * @param string $file Plugin file
     * @return array Modified links
     */
    public function addPluginMeta($links, $file): array
    {
        if ($file === plugin_basename(__FILE__)) {
            $links[] = sprintf(
                '<a href="%s" target="_blank">%s</a>',
                'https://github.com/reia/css-animation-builder',
                __('GitHub', 'css-animation-builder')
            );
            
            $links[] = sprintf(
                '<a href="%s" target="_blank">%s</a>',
                'https://github.com/reia/css-animation-builder/issues',
                __('Support', 'css-animation-builder')
            );
            
            $links[] = sprintf(
                '<a href="%s" target="_blank">%s</a>',
                'https://github.com/reia/css-animation-builder/blob/main/README.md',
                __('Documentation', 'css-animation-builder')
            );
        }
        
        return $links;
    }

    /**
     * Get WordPress plugin instance
     * 
     * @return WordPressPlugin
     */
    public function getPlugin(): WordPressPlugin
    {
        return $this->plugin;
    }

    /**
     * Get plugin version
     * 
     * @return string
     */
    public function getVersion(): string
    {
        return CSS_ANIMATION_BUILDER_VERSION;
    }

    /**
     * Check if plugin is compatible
     * 
     * @return bool
     */
    public function isCompatible(): bool
    {
        return $this->checkWordPressVersion() && version_compare(PHP_VERSION, '7.4', '>=');
    }
}

// Initialize plugin
function css_animation_builder_init() {
    return CSSAnimationBuilderMain::getInstance();
}

// Start the plugin
css_animation_builder_init();

/**
 * Helper function to get the builder instance
 * 
 * @return \Reia\CSSAnimationBuilder\Builder
 */
function css_animation_builder() {
    $main = CSSAnimationBuilderMain::getInstance();
    return $main->getPlugin()->getBuilder();
}

/**
 * Helper function to render the animation builder
 * 
 * @param array $config Configuration options
 * @return string HTML output
 */
function css_animation_builder_render($config = []) {
    $builder = new \Reia\CSSAnimationBuilder\Builder($config);
    return $builder->render();
}

/**
 * Helper function to generate CSS for an animation
 * 
 * @param string $animation Animation type
 * @param array $options Animation options
 * @return string Generated CSS
 */
function css_animation_builder_generate_css($animation, $options = []) {
    $builder = new \Reia\CSSAnimationBuilder\Builder();
    return $builder->generateCSS($animation, $options);
}

/**
 * Helper function to check if the plugin is active and working
 * 
 * @return bool
 */
function css_animation_builder_is_active() {
    return class_exists('CSSAnimationBuilderMain') && 
           CSSAnimationBuilderMain::getInstance()->isCompatible();
}
