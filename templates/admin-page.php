<?php
/**
 * Admin Page Template
 * 
 * @package CSSAnimationBuilderPro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

$current_settings = get_option('cab_settings', array());
?>

<div class="wrap cab-admin-wrap">
    <h1 class="cab-admin-title">
        <span class="dashicons dashicons-art"></span>
        <?php _e('CSS Animation Builder Pro', 'css-animation-builder'); ?>
        <span class="cab-version">v<?php echo CAB_VERSION; ?></span>
    </h1>
    
    <div class="cab-admin-container">
        
        <!-- Live Preview Section -->
        <div class="cab-section cab-preview-section">
            <h2><?php _e('Live Animation Preview', 'css-animation-builder'); ?></h2>
            <p class="description"><?php _e('Test animations in real-time. Changes will appear instantly below.', 'css-animation-builder'); ?></p>
            
            <div class="cab-preview-controls">
                <div class="cab-control-group">
                    <label for="preview-type"><?php _e('Animation Type:', 'css-animation-builder'); ?></label>
                    <select id="preview-type" class="cab-select">
                        <option value="handwriting"><?php _e('Handwriting', 'css-animation-builder'); ?></option>
                        <option value="typewriter"><?php _e('Typewriter', 'css-animation-builder'); ?></option>
                    </select>
                </div>
                
                <div class="cab-control-group">
                    <label for="preview-style"><?php _e('Style:', 'css-animation-builder'); ?></label>
                    <select id="preview-style" class="cab-select">
                        <option value="quill"><?php _e('Quill Pen', 'css-animation-builder'); ?></option>
                        <option value="fountain"><?php _e('Fountain Pen', 'css-animation-builder'); ?></option>
                        <option value="casual"><?php _e('Casual Script', 'css-animation-builder'); ?></option>
                        <option value="formal"><?php _e('Formal Script', 'css-animation-builder'); ?></option>
                        <option value="signature"><?php _e('Signature', 'css-animation-builder'); ?></option>
                    </select>
                </div>
                
                <div class="cab-control-group">
                    <label for="preview-text"><?php _e('Preview Text:', 'css-animation-builder'); ?></label>
                    <input type="text" id="preview-text" class="cab-input" value="Beautiful animations for WordPress" maxlength="100">
                </div>
                
                <button id="preview-animate" class="button button-primary">
                    <?php _e('Preview Animation', 'css-animation-builder'); ?>
                </button>
                
                <button id="preview-reset" class="button">
                    <?php _e('Reset', 'css-animation-builder'); ?>
                </button>
            </div>
            
            <div class="cab-preview-area">
                <div id="animation-preview" class="cab-preview-container">
                    <div class="cab-animation-wrapper cab-handwriting cab-handwriting-quill" data-text="Beautiful animations for WordPress">
                        <span class="cab-text">Beautiful animations for WordPress</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Shortcode Generator Section -->
        <div class="cab-section cab-shortcode-section">
            <h2><?php _e('Shortcode Generator', 'css-animation-builder'); ?></h2>
            <p class="description"><?php _e('Copy and paste these shortcodes into your posts, pages, or widgets.', 'css-animation-builder'); ?></p>
            
            <div class="cab-shortcode-tabs">
                <div class="cab-tab-nav">
                    <button class="cab-tab-button active" data-tab="handwriting"><?php _e('Handwriting', 'css-animation-builder'); ?></button>
                    <button class="cab-tab-button" data-tab="typewriter"><?php _e('Typewriter', 'css-animation-builder'); ?></button>
                    <button class="cab-tab-button" data-tab="advanced"><?php _e('Advanced', 'css-animation-builder'); ?></button>
                </div>
                
                <div class="cab-tab-content active" id="handwriting-tab">
                    <h3><?php _e('Handwriting Animations', 'css-animation-builder'); ?></h3>
                    
                    <div class="cab-shortcode-examples">
                        <div class="cab-example">
                            <h4><?php _e('Quill Pen Style', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[handwriting style="quill" text="Your elegant message here"]</code>
                            <div class="cab-live-example">
                                <div class="cab-animation-wrapper cab-handwriting cab-handwriting-quill" data-text="Your elegant message here">
                                    <span class="cab-text">Your elegant message here</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cab-example">
                            <h4><?php _e('Fountain Pen Style', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[handwriting style="fountain" text="Professional and refined"]</code>
                            <div class="cab-live-example">
                                <div class="cab-animation-wrapper cab-handwriting cab-handwriting-fountain" data-text="Professional and refined">
                                    <span class="cab-text">Professional and refined</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cab-example">
                            <h4><?php _e('Casual Script', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[handwriting style="casual" text="Friendly and approachable"]</code>
                            <div class="cab-live-example">
                                <div class="cab-animation-wrapper cab-handwriting cab-handwriting-casual" data-text="Friendly and approachable">
                                    <span class="cab-text">Friendly and approachable</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cab-example">
                            <h4><?php _e('Signature Style', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[handwriting style="signature" text="Best regards, John Doe"]</code>
                            <div class="cab-live-example">
                                <div class="cab-animation-wrapper cab-handwriting cab-handwriting-signature" data-text="Best regards, John Doe">
                                    <span class="cab-text">Best regards, John Doe</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="cab-tab-content" id="typewriter-tab">
                    <h3><?php _e('Typewriter Animations', 'css-animation-builder'); ?></h3>
                    
                    <div class="cab-shortcode-examples">
                        <div class="cab-example">
                            <h4><?php _e('Basic Typewriter', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[typewriter text="This text appears letter by letter"]</code>
                            <div class="cab-live-example">
                                <div class="cab-animation-wrapper cab-typewriter" data-text="This text appears letter by letter" data-speed="100">
                                    <span class="cab-text">This text appears letter by letter</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cab-example">
                            <h4><?php _e('Fast Typewriter', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[typewriter text="Quick typing effect" speed="50"]</code>
                            <div class="cab-live-example">
                                <div class="cab-animation-wrapper cab-typewriter" data-text="Quick typing effect" data-speed="50">
                                    <span class="cab-text">Quick typing effect</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cab-example">
                            <h4><?php _e('Custom Cursor', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[typewriter text="Custom cursor style" cursor="█"]</code>
                            <div class="cab-live-example">
                                <div class="cab-animation-wrapper cab-typewriter" data-text="Custom cursor style" data-cursor="█">
                                    <span class="cab-text">Custom cursor style</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="cab-tab-content" id="advanced-tab">
                    <h3><?php _e('Advanced Options', 'css-animation-builder'); ?></h3>
                    
                    <div class="cab-shortcode-examples">
                        <div class="cab-example">
                            <h4><?php _e('Custom Duration', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[css-animation-builder type="handwriting" style="quill" text="Slow animation" duration="8s"]</code>
                        </div>
                        
                        <div class="cab-example">
                            <h4><?php _e('Delayed Animation', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[css-animation-builder type="handwriting" style="fountain" text="Appears after 2 seconds" delay="2s"]</code>
                        </div>
                        
                        <div class="cab-example">
                            <h4><?php _e('Custom Color & Size', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[css-animation-builder type="handwriting" style="casual" text="Custom styled text" color="#e74c3c" size="24px"]</code>
                        </div>
                        
                        <div class="cab-example">
                            <h4><?php _e('Looping Animation', 'css-animation-builder'); ?></h4>
                            <code class="cab-shortcode">[css-animation-builder type="typewriter" text="This loops forever" loop="true"]</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Settings Section -->
        <div class="cab-section cab-quick-settings">
            <h2><?php _e('Quick Settings', 'css-animation-builder'); ?></h2>
            <p class="description"><?php _e('Essential settings for optimal performance.', 'css-animation-builder'); ?></p>
            
            <form method="post" action="options.php" class="cab-quick-form">
                <?php settings_fields('cab_settings_group'); ?>
                
                <div class="cab-setting-row">
                    <label class="cab-toggle">
                        <input type="checkbox" name="cab_settings[load_google_fonts]" value="1" <?php checked(!empty($current_settings['load_google_fonts'])); ?>>
                        <span class="cab-toggle-slider"></span>
                        <span class="cab-toggle-label"><?php _e('Load Google Fonts', 'css-animation-builder'); ?></span>
                    </label>
                    <p class="description"><?php _e('Automatically load handwriting fonts from Google Fonts', 'css-animation-builder'); ?></p>
                </div>
                
                <div class="cab-setting-row">
                    <label class="cab-toggle">
                        <input type="checkbox" name="cab_settings[enable_mobile_animations]" value="1" <?php checked(!empty($current_settings['enable_mobile_animations'])); ?>>
                        <span class="cab-toggle-slider"></span>
                        <span class="cab-toggle-label"><?php _e('Enable Mobile Animations', 'css-animation-builder'); ?></span>
                    </label>
                    <p class="description"><?php _e('Show animations on mobile devices (may impact performance)', 'css-animation-builder'); ?></p>
                </div>
                
                <div class="cab-setting-row">
                    <label for="animation_trigger"><?php _e('Animation Trigger:', 'css-animation-builder'); ?></label>
                    <select name="cab_settings[animation_trigger]" id="animation_trigger" class="cab-select">
                        <option value="viewport" <?php selected($current_settings['animation_trigger'], 'viewport'); ?>><?php _e('When in viewport', 'css-animation-builder'); ?></option>
                        <option value="click" <?php selected($current_settings['animation_trigger'], 'click'); ?>><?php _e('On click', 'css-animation-builder'); ?></option>
                        <option value="hover" <?php selected($current_settings['animation_trigger'], 'hover'); ?>><?php _e('On hover', 'css-animation-builder'); ?></option>
                    </select>
                </div>
                
                <?php submit_button(__('Save Settings', 'css-animation-builder'), 'primary', 'submit', true, array('class' => 'button-primary cab-save-btn')); ?>
            </form>
        </div>
        
        <!-- Documentation Section -->
        <div class="cab-section cab-docs-section">
            <h2><?php _e('Documentation & Support', 'css-animation-builder'); ?></h2>
            
            <div class="cab-docs-grid">
                <div class="cab-doc-item">
                    <h3><?php _e('Getting Started', 'css-animation-builder'); ?></h3>
                    <p><?php _e('Learn the basics of creating beautiful animations with shortcodes.', 'css-animation-builder'); ?></p>
                    <a href="#" class="button"><?php _e('View Guide', 'css-animation-builder'); ?></a>
                </div>
                
                <div class="cab-doc-item">
                    <h3><?php _e('Animation Styles', 'css-animation-builder'); ?></h3>
                    <p><?php _e('Explore all available handwriting and typewriter styles.', 'css-animation-builder'); ?></p>
                    <a href="#" class="button"><?php _e('View Styles', 'css-animation-builder'); ?></a>
                </div>
                
                <div class="cab-doc-item">
                    <h3><?php _e('Custom CSS', 'css-animation-builder'); ?></h3>
                    <p><?php _e('Advanced customization with CSS classes and variables.', 'css-animation-builder'); ?></p>
                    <a href="#" class="button"><?php _e('View Examples', 'css-animation-builder'); ?></a>
                </div>
                
                <div class="cab-doc-item">
                    <h3><?php _e('Performance Tips', 'css-animation-builder'); ?></h3>
                    <p><?php _e('Optimize animations for fast loading and smooth performance.', 'css-animation-builder'); ?></p>
                    <a href="#" class="button"><?php _e('Learn More', 'css-animation-builder'); ?></a>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Initialize the admin interface
    if (window.CSSAnimationBuilder && window.CSSAnimationBuilder.initAdmin) {
        window.CSSAnimationBuilder.initAdmin();
    }
    
    // Trigger initial animation for examples
    setTimeout(function() {
        $('.cab-live-example .cab-animation-wrapper').each(function() {
            if (window.CSSAnimationBuilder && window.CSSAnimationBuilder.triggerAnimation) {
                window.CSSAnimationBuilder.triggerAnimation(this);
            }
        });
    }, 1000);
});
</script>
