/**
 * CSS Animation Builder Pro - Frontend JavaScript
 * Version: 1.4.0
 * 
 * Handles all frontend animation logic including:
 * - Handwriting animations with realistic pen effects
 * - Typewriter animations with customizable speeds
 * - Intersection Observer for viewport triggers
 * - Mobile optimization
 */

(function($) {
    'use strict';
    
    // Main Animation Controller
    window.CSSAnimationBuilder = {
        
        // Configuration
        config: {
            mobile: false,
            settings: {},
            intersectionObserver: null,
            animations: new Map(),
            initialized: false
        },
        
        // Initialize the animation system
        init: function() {
            if (this.config.initialized) return;
            
            this.config.mobile = window.innerWidth <= 768 || /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            this.config.settings = window.cabSettings || {};
            
            // Skip mobile animations if disabled
            if (this.config.mobile && !this.config.settings.enable_mobile_animations) {
                return;
            }
            
            this.setupIntersectionObserver();
            this.findAndInitAnimations();
            this.config.initialized = true;
            
            console.log('CSS Animation Builder initialized');
        },
        
        // Setup Intersection Observer for viewport triggers
        setupIntersectionObserver: function() {
            if (!('IntersectionObserver' in window)) {
                // Fallback for older browsers
                this.triggerAllAnimations();
                return;
            }
            
            const options = {
                root: null,
                rootMargin: '50px 0px',
                threshold: 0.1
            };
            
            this.config.intersectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.triggerAnimation(entry.target);
                        this.config.intersectionObserver.unobserve(entry.target);
                    }
                });
            }, options);
        },
        
        // Find and initialize all animations on the page
        findAndInitAnimations: function() {
            $('.cab-animation-wrapper').each((index, element) => {
                this.initializeAnimation(element);
            });
        },
        
        // Initialize a single animation element
        initializeAnimation: function(element) {
            const $element = $(element);
            const id = element.id || 'cab-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
            
            if (!element.id) {
                element.id = id;
            }
            
            const animationType = this.getAnimationType($element);
            const text = $element.data('text') || $element.find('.cab-text').text();
            
            // Store animation data
            const animationData = {
                element: $element,
                type: animationType,
                text: text,
                triggered: false,
                config: this.parseAnimationConfig($element)
            };
            
            this.config.animations.set(id, animationData);
            
            // Prepare the element
            this.prepareElement($element, animationData);
            
            // Setup trigger method
            const trigger = animationData.config.trigger || 'viewport';
            this.setupTrigger($element, trigger);
        },
        
        // Determine animation type from element classes
        getAnimationType: function($element) {
            const classes = $element.attr('class') || '';
            
            if (classes.includes('cab-handwriting')) return 'handwriting';
            if (classes.includes('cab-typewriter')) return 'typewriter';
            
            return 'handwriting'; // default
        },
        
        // Parse animation configuration from data attributes
        parseAnimationConfig: function($element) {
            return {
                speed: $element.data('speed') || 'normal',
                delay: $element.data('delay') || '0',
                duration: $element.data('duration') || '4s',
                trigger: $element.data('trigger') || 'viewport',
                loop: $element.data('loop') === 'true' || $element.data('loop') === true,
                cursor: $element.data('cursor') || '|',
                sound: $element.data('sound') === 'true',
                backspace: $element.data('backspace') === 'true',
                pen: $element.data('pen') || 'fountain'
            };
        },
        
        // Prepare element for animation
        prepareElement: function($element, animationData) {
            const type = animationData.type;
            const text = animationData.text;
            
            // Clear existing content
            $element.empty();
            
            if (type === 'handwriting') {
                this.prepareHandwritingElement($element, animationData);
            } else if (type === 'typewriter') {
                this.prepareTypewriterElement($element, animationData);
            }
            
            // Add loading state
            $element.addClass('cab-loading');
        },
        
        // Prepare handwriting animation element
        prepareHandwritingElement: function($element, animationData) {
            const text = animationData.text;
            const duration = animationData.config.duration;
            
            // Create text container with animation properties
            const $textContainer = $('<div>')
                .addClass('cab-handwriting-text')
                .text(text)
                .css({
                    'animation-duration': duration,
                    'animation-fill-mode': 'both'
                });
            
            $element.append($textContainer);
            
            // Add writing cursor/pen effect
            const $cursor = $('<span>')
                .addClass('cab-writing-cursor')
                .html('✒️');
            
            $element.append($cursor);
        },
        
        // Prepare typewriter animation element
        prepareTypewriterElement: function($element, animationData) {
            const cursor = animationData.config.cursor;
            
            // Create typewriter container
            const $container = $('<div>').addClass('cab-typewriter-container');
            const $textSpan = $('<span>').addClass('cab-typewriter-text');
            const $cursorSpan = $('<span>')
                .addClass('cab-typewriter-cursor')
                .text(cursor);
            
            $container.append($textSpan, $cursorSpan);
            $element.append($container);
        },
        
        // Setup animation trigger
        setupTrigger: function($element, trigger) {
            switch (trigger) {
                case 'viewport':
                    if (this.config.intersectionObserver) {
                        this.config.intersectionObserver.observe($element[0]);
                    }
                    break;
                    
                case 'click':
                    $element.css('cursor', 'pointer').on('click', () => {
                        this.triggerAnimation($element[0]);
                    });
                    break;
                    
                case 'hover':
                    $element.on('mouseenter', () => {
                        this.triggerAnimation($element[0]);
                    });
                    break;
                    
                default:
                    // Auto-trigger after delay
                    setTimeout(() => {
                        this.triggerAnimation($element[0]);
                    }, 100);
            }
        },
        
        // Trigger a specific animation
        triggerAnimation: function(element) {
            const $element = $(element);
            const id = element.id;
            const animationData = this.config.animations.get(id);
            
            if (!animationData || animationData.triggered) {
                return;
            }
            
            animationData.triggered = true;
            $element.removeClass('cab-loading').addClass('cab-animating');
            
            // Apply delay if specified
            const delay = parseFloat(animationData.config.delay.replace('s', '')) * 1000;
            
            setTimeout(() => {
                this.executeAnimation(animationData);
            }, delay);
        },
        
        // Execute the animation
        executeAnimation: function(animationData) {
            const type = animationData.type;
            
            if (type === 'handwriting') {
                this.executeHandwritingAnimation(animationData);
            } else if (type === 'typewriter') {
                this.executeTypewriterAnimation(animationData);
            }
        },
        
        // Execute handwriting animation
        executeHandwritingAnimation: function(animationData) {
            const $element = animationData.element;
            const $textContainer = $element.find('.cab-handwriting-text');
            const $cursor = $element.find('.cab-writing-cursor');
            
            // Start the CSS animation
            $textContainer.addClass('cab-animate');
            
            // Animate the writing cursor
            if ($cursor.length) {
                this.animateWritingCursor($cursor, animationData);
            }
            
            // Handle loop
            if (animationData.config.loop) {
                const duration = parseFloat(animationData.config.duration.replace('s', '')) * 1000;
                setTimeout(() => {
                    $textContainer.removeClass('cab-animate');
                    setTimeout(() => {
                        this.executeHandwritingAnimation(animationData);
                    }, 100);
                }, duration);
            }
        },
        
        // Animate writing cursor/pen
        animateWritingCursor: function($cursor, animationData) {
            const duration = parseFloat(animationData.config.duration.replace('s', '')) * 1000;
            const text = animationData.text;
            const textLength = text.length;
            
            $cursor.css({
                'position': 'absolute',
                'opacity': '0.7',
                'font-size': '16px',
                'z-index': '10'
            });
            
            // Animate cursor movement across text
            let position = 0;
            const interval = duration / textLength;
            
            const moveInterval = setInterval(() => {
                const progress = position / textLength;
                const leftPos = progress * 100;
                
                $cursor.css({
                    'left': leftPos + '%',
                    'transform': `translateX(-${leftPos}%)`
                });
                
                position++;
                
                if (position > textLength) {
                    clearInterval(moveInterval);
                    $cursor.fadeOut(500);
                }
            }, interval);
        },
        
        // Execute typewriter animation
        executeTypewriterAnimation: function(animationData) {
            const $element = animationData.element;
            const $textSpan = $element.find('.cab-typewriter-text');
            const $cursor = $element.find('.cab-typewriter-cursor');
            const text = animationData.text;
            const speed = this.getTypewriterSpeed(animationData.config.speed);
            
            let currentIndex = 0;
            let isDeleting = false;
            
            const typeInterval = setInterval(() => {
                if (!isDeleting) {
                    // Typing forward
                    $textSpan.text(text.substring(0, currentIndex + 1));
                    currentIndex++;
                    
                    if (currentIndex >= text.length) {
                        if (animationData.config.backspace) {
                            setTimeout(() => {
                                isDeleting = true;
                            }, 1000);
                        } else if (animationData.config.loop) {
                            setTimeout(() => {
                                currentIndex = 0;
                                $textSpan.text('');
                            }, 2000);
                        } else {
                            clearInterval(typeInterval);
                            $cursor.addClass('cab-finished');
                        }
                    }
                } else {
                    // Deleting backward
                    currentIndex--;
                    $textSpan.text(text.substring(0, currentIndex));
                    
                    if (currentIndex <= 0) {
                        isDeleting = false;
                        if (animationData.config.loop) {
                            // Continue loop
                        } else {
                            clearInterval(typeInterval);
                        }
                    }
                }
            }, speed + Math.random() * 50); // Add slight randomness
        },
        
        // Get typewriter speed based on setting
        getTypewriterSpeed: function(speedSetting) {
            const speeds = {
                'slow': 150,
                'normal': 100,
                'fast': 50,
                'very-fast': 25
            };
            
            // If it's a number, use it directly
            if (!isNaN(speedSetting)) {
                return parseInt(speedSetting);
            }
            
            return speeds[speedSetting] || speeds['normal'];
        },
        
        // Trigger all animations (fallback)
        triggerAllAnimations: function() {
            this.config.animations.forEach((animationData, id) => {
                const element = document.getElementById(id);
                if (element) {
                    this.triggerAnimation(element);
                }
            });
        },
        
        // Public method to manually trigger an animation
        triggerAnimationById: function(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                this.triggerAnimation(element);
            }
        },
        
        // Reset an animation
        resetAnimation: function(elementId) {
            const animationData = this.config.animations.get(elementId);
            if (animationData) {
                animationData.triggered = false;
                const $element = animationData.element;
                
                $element.removeClass('cab-animating cab-finished')
                       .addClass('cab-loading');
                
                // Re-prepare the element
                this.prepareElement($element, animationData);
            }
        },
        
        // Admin-specific functionality
        initAdmin: function() {
            this.setupAdminControls();
            this.setupTabSwitching();
            this.setupShortcodeCopy();
            this.setupLivePreview();
        },
        
        // Setup admin control handlers
        setupAdminControls: function() {
            $('#preview-animate').on('click', () => {
                this.updateLivePreview();
            });
            
            $('#preview-reset').on('click', () => {
                this.resetLivePreview();
            });
        },
        
        // Setup tab switching
        setupTabSwitching: function() {
            $('.cab-tab-button').on('click', function() {
                const tab = $(this).data('tab');
                
                $('.cab-tab-button').removeClass('active');
                $('.cab-tab-content').removeClass('active');
                
                $(this).addClass('active');
                $('#' + tab + '-tab').addClass('active');
            });
        },
        
        // Setup shortcode copy functionality
        setupShortcodeCopy: function() {
            $('.cab-shortcode').on('click', function() {
                const text = $(this).text();
                
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.showNotification('Shortcode copied to clipboard!');
                    });
                } else {
                    // Fallback
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    this.showNotification('Shortcode copied to clipboard!');
                }
            });
        },
        
        // Setup live preview functionality
        setupLivePreview: function() {
            $('#preview-type, #preview-style, #preview-text').on('change input', () => {
                this.updateLivePreview();
            });
        },
        
        // Update live preview
        updateLivePreview: function() {
            const type = $('#preview-type').val();
            const style = $('#preview-style').val();
            const text = $('#preview-text').val() || 'Sample text';
            
            const $preview = $('#animation-preview .cab-animation-wrapper');
            
            // Reset animation
            const id = $preview.attr('id') || 'preview-animation';
            this.resetAnimation(id);
            
            // Update classes and data
            $preview.attr('class', `cab-animation-wrapper cab-${type} cab-${type}-${style}`)
                   .attr('data-text', text)
                   .attr('id', id);
            
            // Re-initialize
            this.initializeAnimation($preview[0]);
            
            // Trigger animation
            setTimeout(() => {
                this.triggerAnimation($preview[0]);
            }, 100);
        },
        
        // Reset live preview
        resetLivePreview: function() {
            const $preview = $('#animation-preview .cab-animation-wrapper');
            const id = $preview.attr('id');
            
            if (id) {
                this.resetAnimation(id);
                setTimeout(() => {
                    this.triggerAnimation($preview[0]);
                }, 100);
            }
        },
        
        // Show notification
        showNotification: function(message) {
            const $notification = $('<div>')
                .addClass('notice notice-success is-dismissible')
                .html('<p>' + message + '</p>')
                .css({
                    position: 'fixed',
                    top: '32px',
                    right: '20px',
                    zIndex: 99999,
                    minWidth: '300px'
                });
            
            $('body').append($notification);
            
            setTimeout(() => {
                $notification.fadeOut(() => $notification.remove());
            }, 3000);
        }
    };
    
    // Auto-initialize when DOM is ready
    $(document).ready(() => {
        // Small delay to ensure all elements are rendered
        setTimeout(() => {
            window.CSSAnimationBuilder.init();
        }, 100);
    });
    
    // Re-initialize on AJAX content load (for dynamic content)
    $(document).ajaxComplete(() => {
        setTimeout(() => {
            window.CSSAnimationBuilder.findAndInitAnimations();
        }, 200);
    });
    
})(jQuery);
