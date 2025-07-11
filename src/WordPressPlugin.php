<?php

namespace Reia\CSSAnimationBuilder;

/**
 * WordPress Plugin Integration
 * 
 * Provides WordPress-specific functionality for the CSS Animation Builder
 * Developed by Real Estate Intelligence Agency (REIA)
 * 
 * @package Reia\CSSAnimationBuilder
 * @version 1.0.0
 * @author David England <DavidEngland@hotmail.com>
 */
class WordPressPlugin
{
    /**
     * Plugin instance
     * 
     * @var WordPressPlugin
     */
    private static $instance = null;

    /**
     * Builder instance
     * 
     * @var Builder
     */
    private $builder;

    /**
     * Plugin configuration
     * 
     * @var array
     */
    private $config;

    /**
     * Get plugin instance
     * 
     * @return WordPressPlugin
     */
    public static function getInstance(): WordPressPlugin
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
        $this->config = [
            'version' => '1.0.0',
            'plugin_dir' => plugin_dir_path(__FILE__),
            'plugin_url' => plugin_dir_url(__FILE__),
            'text_domain' => 'css-animation-builder'
        ];
        
        $this->init();
    }

    /**
     * Initialize plugin
     * 
     * @return void
     */
    private function init()
    {
        add_action('init', [$this, 'registerShortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('wp_ajax_generate_animation_css', [$this, 'ajaxGenerateCSS']);
        add_action('wp_ajax_nopriv_generate_animation_css', [$this, 'ajaxGenerateCSS']);
        
        // Add Gutenberg block
        add_action('init', [$this, 'registerBlock']);
    }

    /**
     * Register shortcode
     * 
     * @return void
     */
    public function registerShortcode()
    {
        add_shortcode('css-animation-builder', [$this, 'renderShortcode']);
    }

    /**
     * Render shortcode
     * 
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function renderShortcode($atts = []): string
    {
        $atts = shortcode_atts([
            'theme' => 'default',
            'show_preview' => 'true',
            'show_code' => 'true',
            'show_presets' => 'true',
            'show_advanced' => 'true',
            'animations' => '',
            'height' => 'auto'
        ], $atts);

        $config = [
            'theme' => $atts['theme'],
            'showPreview' => $atts['show_preview'] === 'true',
            'showCode' => $atts['show_code'] === 'true',
            'showPresets' => $atts['show_presets'] === 'true',
            'showAdvanced' => $atts['show_advanced'] === 'true'
        ];

        if (!empty($atts['animations'])) {
            $config['animations'] = explode(',', $atts['animations']);
        }

        $this->builder = new Builder($config);
        return $this->builder->render();
    }

    /**
     * Enqueue assets
     * 
     * @return void
     */
    public function enqueueAssets()
    {
        wp_enqueue_script(
            'css-animation-builder',
            $this->config['plugin_url'] . 'assets/js/animation-builder.js',
            ['jquery'],
            $this->config['version'],
            true
        );

        wp_enqueue_style(
            'css-animation-builder',
            $this->config['plugin_url'] . 'assets/css/animation-builder.css',
            [],
            $this->config['version']
        );

        wp_localize_script('css-animation-builder', 'cssAnimationBuilder', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('css_animation_builder_nonce'),
            'textDomain' => $this->config['text_domain']
        ]);
    }

    /**
     * Add admin menu
     * 
     * @return void
     */
    public function addAdminMenu()
    {
        add_menu_page(
            __('CSS Animation Builder', $this->config['text_domain']),
            __('Animation Builder', $this->config['text_domain']),
            'manage_options',
            'css-animation-builder',
            [$this, 'renderAdminPage'],
            'dashicons-format-video',
            30
        );
    }

    /**
     * Render admin page
     * 
     * @return void
     */
    public function renderAdminPage()
    {
        $this->builder = new Builder([
            'theme' => 'admin',
            'showPreview' => true,
            'showCode' => true,
            'showPresets' => true,
            'showAdvanced' => true
        ]);

        echo '<div class="wrap">';
        echo '<h1>' . __('CSS Animation Builder', $this->config['text_domain']) . '</h1>';
        echo '<div class="css-animation-builder-admin">';
        echo $this->builder->render();
        echo '</div>';
        echo '</div>';
    }

    /**
     * AJAX handler for generating CSS
     * 
     * @return void
     */
    public function ajaxGenerateCSS()
    {
        check_ajax_referer('css_animation_builder_nonce', 'nonce');

        $animation = sanitize_text_field($_POST['animation'] ?? 'fadeIn');
        $options = [
            'duration' => floatval($_POST['duration'] ?? 1.0),
            'delay' => floatval($_POST['delay'] ?? 0.0),
            'timingFunction' => sanitize_text_field($_POST['timingFunction'] ?? 'ease'),
            'iterationCount' => sanitize_text_field($_POST['iterationCount'] ?? '1'),
            'direction' => sanitize_text_field($_POST['direction'] ?? 'normal'),
            'fillMode' => sanitize_text_field($_POST['fillMode'] ?? 'none'),
            'transformOrigin' => sanitize_text_field($_POST['transformOrigin'] ?? 'center')
        ];

        $this->builder = new Builder();
        $css = $this->builder->generateCSS($animation, $options);
        $html = $this->builder->generateHTML($animation, $options);

        wp_send_json_success([
            'css' => $css,
            'html' => $html,
            'className' => 'animated-' . strtolower($animation)
        ]);
    }

    /**
     * Register Gutenberg block
     * 
     * @return void
     */
    public function registerBlock()
    {
        if (function_exists('register_block_type')) {
            register_block_type('css-animation-builder/animation-builder', [
                'editor_script' => 'css-animation-builder-block',
                'editor_style' => 'css-animation-builder-block-editor',
                'style' => 'css-animation-builder',
                'render_callback' => [$this, 'renderBlock']
            ]);

            wp_register_script(
                'css-animation-builder-block',
                $this->config['plugin_url'] . 'assets/js/block.js',
                ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-components'],
                $this->config['version']
            );

            wp_register_style(
                'css-animation-builder-block-editor',
                $this->config['plugin_url'] . 'assets/css/block-editor.css',
                ['wp-edit-blocks'],
                $this->config['version']
            );
        }
    }

    /**
     * Render Gutenberg block
     * 
     * @param array $attributes Block attributes
     * @return string HTML output
     */
    public function renderBlock($attributes): string
    {
        $config = [
            'theme' => $attributes['theme'] ?? 'default',
            'showPreview' => $attributes['showPreview'] ?? true,
            'showCode' => $attributes['showCode'] ?? true,
            'showPresets' => $attributes['showPresets'] ?? true,
            'showAdvanced' => $attributes['showAdvanced'] ?? true
        ];

        if (!empty($attributes['animations'])) {
            $config['animations'] = $attributes['animations'];
        }

        $this->builder = new Builder($config);
        return $this->builder->render();
    }

    /**
     * Get builder instance
     * 
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        if (!$this->builder) {
            $this->builder = new Builder();
        }
        return $this->builder;
    }
}
