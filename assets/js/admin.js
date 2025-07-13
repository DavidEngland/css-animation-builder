/**
 * CSS Animation Builder Pro - Admin JavaScript
 * Version: 1.4.0
 * 
 * Handles all admin interface functionality including:
 * - Live preview controls
 * - Shortcode copying
 * - Tab switching
 * - Settings management
 */

(function($) {
    'use strict';
    
    // Admin Controller
    const CSSAnimationBuilderAdmin = {
        
        // Initialize admin interface
        init: function() {
            this.setupEventListeners();
            this.initializeComponents();
            this.setupLivePreview();
            console.log('CSS Animation Builder Admin initialized');
        },
        
        // Setup all event listeners
        setupEventListeners: function() {
            // Tab switching
            $('.cab-tab-button').on('click', this.handleTabSwitch);
            
            // Shortcode copying
            $('.cab-shortcode').on('click', this.handleShortcodeCopy.bind(this));
            
            // Preview controls
            $('#preview-animate').on('click', this.handlePreviewAnimate.bind(this));
            $('#preview-reset').on('click', this.handlePreviewReset.bind(this));
            
            // Live preview updates
            $('#preview-type, #preview-style, #preview-text').on('change input', 
                this.debounce(this.updateLivePreview.bind(this), 500));
            
            // Settings form
            $('.cab-quick-form').on('submit', this.handleSettingsSave.bind(this));
            
            // Toggle switches
            $('.cab-toggle input[type="checkbox"]').on('change', this.handleToggleChange);
        },
        
        // Initialize components
        initializeComponents: function() {
            // Setup tooltips
            this.setupTooltips();
            
            // Initialize color pickers if available
            if ($.fn.wpColorPicker) {
                $('.color-picker').wpColorPicker();
            }
            
            // Setup accessibility
            this.setupAccessibility();
        },
        
        // Setup live preview functionality
        setupLivePreview: function() {
            // Trigger initial preview
            setTimeout(() => {
                this.updateLivePreview();
            }, 500);
            
            // Setup style updates for preview area
            $('#preview-style').on('change', () => {
                this.updateStyleOptions();
            });
        },
        
        // Handle tab switching
        handleTabSwitch: function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const tab = $button.data('tab');
            
            // Update button states
            $('.cab-tab-button').removeClass('active');
            $button.addClass('active');
            
            // Update content visibility
            $('.cab-tab-content').removeClass('active');
            $('#' + tab + '-tab').addClass('active');
            
            // Trigger animations in newly visible tab
            setTimeout(() => {
                $('#' + tab + '-tab .cab-live-example .cab-animation-wrapper').each(function() {
                    if (window.CSSAnimationBuilder && window.CSSAnimationBuilder.triggerAnimation) {
                        window.CSSAnimationBuilder.resetAnimation(this.id || 'example-' + Math.random());
                        setTimeout(() => {
                            window.CSSAnimationBuilder.triggerAnimation(this);
                        }, 100);
                    }
                });
            }, 200);
        },
        
        // Handle shortcode copying
        handleShortcodeCopy: function(e) {
            e.preventDefault();
            
            const $shortcode = $(e.target);
            const text = $shortcode.text().trim();
            
            this.copyToClipboard(text).then(() => {
                this.showNotification('Shortcode copied to clipboard!', 'success');
                this.highlightElement($shortcode);
            }).catch(() => {
                this.showNotification('Failed to copy shortcode. Please copy manually.', 'error');
            });
        },
        
        // Copy text to clipboard
        copyToClipboard: function(text) {
            return new Promise((resolve, reject) => {
                if (navigator.clipboard && window.isSecureContext) {
                    // Modern clipboard API
                    navigator.clipboard.writeText(text).then(resolve).catch(reject);
                } else {
                    // Fallback for older browsers
                    try {
                        const textArea = document.createElement('textarea');
                        textArea.value = text;
                        textArea.style.position = 'fixed';
                        textArea.style.left = '-999999px';
                        textArea.style.top = '-999999px';
                        document.body.appendChild(textArea);
                        textArea.focus();
                        textArea.select();
                        
                        const result = document.execCommand('copy');
                        document.body.removeChild(textArea);
                        
                        if (result) {
                            resolve();
                        } else {
                            reject(new Error('Copy command failed'));
                        }
                    } catch (error) {
                        reject(error);
                    }
                }
            });
        },
        
        // Highlight element briefly
        highlightElement: function($element) {
            const originalBg = $element.css('background-color');
            
            $element.css('background-color', '#d4edda')
                   .animate({ backgroundColor: originalBg }, 1000);
        },
        
        // Handle preview animation
        handlePreviewAnimate: function(e) {
            e.preventDefault();
            this.triggerPreviewAnimation();
        },
        
        // Handle preview reset
        handlePreviewReset: function(e) {
            e.preventDefault();
            this.resetPreviewAnimation();
        },
        
        // Update live preview
        updateLivePreview: function() {
            const type = $('#preview-type').val();
            const style = $('#preview-style').val();
            const text = $('#preview-text').val() || 'Beautiful animations for WordPress';
            
            const $preview = $('#animation-preview .cab-animation-wrapper');
            
            if (!$preview.length) return;
            
            // Update preview element
            this.updatePreviewElement($preview, type, style, text);
            
            // Trigger animation
            setTimeout(() => {
                this.triggerPreviewAnimation();
            }, 100);
        },
        
        // Update preview element attributes and classes
        updatePreviewElement: function($preview, type, style, text) {
            const newClasses = `cab-animation-wrapper cab-${type} cab-${type}-${style}`;
            
            $preview.attr('class', newClasses)
                   .attr('data-text', text)
                   .attr('data-trigger', 'manual')
                   .empty();
            
            // Re-initialize the element
            if (window.CSSAnimationBuilder && window.CSSAnimationBuilder.initializeAnimation) {
                window.CSSAnimationBuilder.initializeAnimation($preview[0]);
            }
        },
        
        // Trigger preview animation
        triggerPreviewAnimation: function() {
            const $preview = $('#animation-preview .cab-animation-wrapper');
            
            if (!$preview.length) return;
            
            // Reset first
            this.resetPreviewAnimation();
            
            // Trigger after brief delay
            setTimeout(() => {
                if (window.CSSAnimationBuilder && window.CSSAnimationBuilder.triggerAnimation) {
                    window.CSSAnimationBuilder.triggerAnimation($preview[0]);
                }
            }, 200);
        },
        
        // Reset preview animation
        resetPreviewAnimation: function() {
            const $preview = $('#animation-preview .cab-animation-wrapper');
            
            if (!$preview.length) return;
            
            const id = $preview.attr('id') || 'preview-animation';
            $preview.attr('id', id);
            
            if (window.CSSAnimationBuilder && window.CSSAnimationBuilder.resetAnimation) {
                window.CSSAnimationBuilder.resetAnimation(id);
            }
        },
        
        // Update style options based on type
        updateStyleOptions: function() {
            const type = $('#preview-type').val();
            const $styleSelect = $('#preview-style');
            
            // Clear existing options
            $styleSelect.empty();
            
            // Add options based on type
            if (type === 'handwriting') {
                $styleSelect.append([
                    '<option value="quill">Quill Pen</option>',
                    '<option value="fountain">Fountain Pen</option>',
                    '<option value="casual">Casual Script</option>',
                    '<option value="formal">Formal Script</option>',
                    '<option value="signature">Signature</option>'
                ].join(''));
            } else if (type === 'typewriter') {
                $styleSelect.append([
                    '<option value="classic">Classic</option>',
                    '<option value="vintage">Vintage</option>',
                    '<option value="modern">Modern</option>',
                    '<option value="terminal">Terminal</option>'
                ].join(''));
            }
        },
        
        // Handle settings save
        handleSettingsSave: function(e) {
            const $form = $(e.target);
            const $button = $form.find('.cab-save-btn');
            
            // Show loading state
            this.setButtonLoading($button, true);
            
            // Allow form to submit normally, then show success
            setTimeout(() => {
                this.setButtonLoading($button, false);
                this.showNotification('Settings saved successfully!', 'success');
            }, 1000);
        },
        
        // Handle toggle change
        handleToggleChange: function() {
            const $toggle = $(this);
            const $label = $toggle.closest('.cab-toggle').find('.cab-toggle-label');
            
            // Add visual feedback
            $label.css('opacity', '0.7').animate({ opacity: 1 }, 200);
        },
        
        // Set button loading state
        setButtonLoading: function($button, loading) {
            if (loading) {
                $button.prop('disabled', true)
                      .addClass('cab-loading')
                      .data('original-text', $button.text())
                      .text('Saving...');
            } else {
                $button.prop('disabled', false)
                      .removeClass('cab-loading')
                      .text($button.data('original-text') || 'Save Settings');
            }
        },
        
        // Setup tooltips
        setupTooltips: function() {
            // Add hover titles to shortcodes
            $('.cab-shortcode').attr('title', 'Click to copy shortcode to clipboard');
            
            // Add titles to controls
            $('#preview-animate').attr('title', 'Trigger animation preview');
            $('#preview-reset').attr('title', 'Reset and replay animation');
        },
        
        // Setup accessibility
        setupAccessibility: function() {
            // Add ARIA labels
            $('.cab-tab-button').attr('role', 'tab');
            $('.cab-tab-content').attr('role', 'tabpanel');
            
            // Add keyboard navigation for tabs
            $('.cab-tab-button').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });
            
            // Add keyboard navigation for shortcodes
            $('.cab-shortcode').attr('tabindex', '0').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });
        },
        
        // Show notification
        showNotification: function(message, type = 'success') {
            const typeClass = type === 'error' ? 'notice-error' : 'notice-success';
            
            const $notification = $('<div>')
                .addClass(`notice ${typeClass} is-dismissible cab-notification`)
                .html(`<p>${message}</p>`)
                .css({
                    position: 'fixed',
                    top: '32px',
                    right: '20px',
                    zIndex: 999999,
                    minWidth: '300px',
                    maxWidth: '500px'
                });
            
            // Add dismiss button
            const $dismissButton = $('<button type="button" class="notice-dismiss">')
                .html('<span class="screen-reader-text">Dismiss this notice.</span>')
                .on('click', () => $notification.remove());
            
            $notification.append($dismissButton);
            $('body').append($notification);
            
            // Auto-remove after 4 seconds
            setTimeout(() => {
                $notification.fadeOut(300, () => $notification.remove());
            }, 4000);
        },
        
        // Debounce function
        debounce: function(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },
        
        // Setup example animations
        setupExampleAnimations: function() {
            // Initialize all example animations
            $('.cab-live-example .cab-animation-wrapper').each(function(index) {
                const $element = $(this);
                const id = 'example-' + index;
                $element.attr('id', id);
                
                if (window.CSSAnimationBuilder && window.CSSAnimationBuilder.initializeAnimation) {
                    window.CSSAnimationBuilder.initializeAnimation(this);
                }
            });
            
            // Trigger animations with staggered delays
            setTimeout(() => {
                $('.cab-live-example .cab-animation-wrapper').each(function(index) {
                    setTimeout(() => {
                        if (window.CSSAnimationBuilder && window.CSSAnimationBuilder.triggerAnimation) {
                            window.CSSAnimationBuilder.triggerAnimation(this);
                        }
                    }, index * 500);
                });
            }, 1000);
        }
    };
    
    // Extend CSSAnimationBuilder with admin methods
    if (window.CSSAnimationBuilder) {
        window.CSSAnimationBuilder.initAdmin = function() {
            CSSAnimationBuilderAdmin.init();
            CSSAnimationBuilderAdmin.setupExampleAnimations();
        };
    }
    
    // Initialize when DOM is ready
    $(document).ready(() => {
        CSSAnimationBuilderAdmin.init();
        
        // Setup example animations after a delay
        setTimeout(() => {
            CSSAnimationBuilderAdmin.setupExampleAnimations();
        }, 1500);
    });
    
})(jQuery);
