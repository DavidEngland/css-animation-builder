/**
 * CSS Animation Builder Frontend Scripts
 * Version: 1.4.0
 */

(function($) {
    'use strict';
    
    // Animation controller
    class CSSAnimationController {
        constructor() {
            this.animations = new Map();
            this.init();
        }
        
        init() {
            this.initializeAnimations();
            this.setupIntersectionObserver();
        }
        
        initializeAnimations() {
            $('.css-animation-wrapper').each((index, element) => {
                const $element = $(element);
                const animationType = this.getAnimationType($element);
                
                switch (animationType) {
                    case 'handwriting':
                        this.initHandwriting($element);
                        break;
                    case 'typewriter':
                        this.initTypewriter($element);
                        break;
                }
            });
        }
        
        getAnimationType($element) {
            const classes = $element.attr('class');
            if (classes.includes('handwriting-')) return 'handwriting';
            if (classes.includes('typewriter-')) return 'typewriter';
            return 'handwriting'; // default
        }
        
        initHandwriting($element) {
            const text = $element.data('text') || $element.text();
            const duration = $element.data('duration') || '4s';
            const id = $element.attr('id');
            
            // Create handwriting animation
            $element.empty();
            
            const $textSpan = $('<span>').addClass('handwriting-text').text(text);
            $element.append($textSpan);
            
            // Set animation duration
            $textSpan.css('animation-duration', duration);
            
            this.animations.set(id, {
                element: $element,
                type: 'handwriting',
                started: false
            });
        }
        
        initTypewriter($element) {
            const text = $element.data('text') || $element.text();
            const speed = parseInt($element.data('speed')) || 100;
            const cursor = $element.data('cursor') || '|';
            const id = $element.attr('id');
            
            $element.empty();
            
            const $container = $('<span>').addClass('typewriter-container');
            const $text = $('<span>').addClass('typewriter-text');
            const $cursor = $('<span>').addClass('typewriter-cursor').text(cursor);
            
            $container.append($text, $cursor);
            $element.append($container);
            
            this.animations.set(id, {
                element: $element,
                type: 'typewriter',
                text: text,
                speed: speed,
                started: false
            });
        }
        
        setupIntersectionObserver() {
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.startAnimation(entry.target.id);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '50px'
                });
                
                $('.css-animation-wrapper').each((index, element) => {
                    observer.observe(element);
                });
            } else {
                // Fallback for older browsers
                this.startAllAnimations();
            }
        }
        
        startAnimation(elementId) {
            const animation = this.animations.get(elementId);
            if (!animation || animation.started) return;
            
            animation.started = true;
            
            switch (animation.type) {
                case 'handwriting':
                    this.startHandwritingAnimation(animation);
                    break;
                case 'typewriter':
                    this.startTypewriterAnimation(animation);
                    break;
            }
        }
        
        startHandwritingAnimation(animation) {
            const $element = animation.element;
            const $textSpan = $element.find('.handwriting-text');
            
            // Add animation class to trigger CSS animation
            $textSpan.addClass('animate');
        }
        
        startTypewriterAnimation(animation) {
            const $element = animation.element;
            const $textSpan = $element.find('.typewriter-text');
            const text = animation.text;
            const speed = animation.speed;
            
            let i = 0;
            const typeInterval = setInterval(() => {
                $textSpan.text(text.substring(0, i + 1));
                i++;
                
                if (i >= text.length) {
                    clearInterval(typeInterval);
                    // Optional: stop cursor blinking after completion
                    setTimeout(() => {
                        $element.find('.typewriter-cursor').addClass('finished');
                    }, 1000);
                }
            }, speed);
        }
        
        startAllAnimations() {
            this.animations.forEach((animation, id) => {
                this.startAnimation(id);
            });
        }
    }
    
    // Initialize when DOM is ready
    $(document).ready(() => {
        new CSSAnimationController();
    });
    
    // Expose for manual triggering if needed
    window.CSSAnimationBuilder = {
        triggerAnimation: function(elementId) {
            if (window.cssAnimationController) {
                window.cssAnimationController.startAnimation(elementId);
            }
        }
    };
    
})(jQuery);
