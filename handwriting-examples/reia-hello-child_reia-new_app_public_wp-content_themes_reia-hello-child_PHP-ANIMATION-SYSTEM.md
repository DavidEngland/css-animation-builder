# PHP-Driven CSS Animation System for WordPress

## Overview

This document outlines the PHP-based CSS animation system implemented for the REIA Hello Child theme. This approach allows for dynamic, maintainable, and scalable animation generation using PHP to create CSS animations programmatically.

## Why PHP for CSS Animation Generation?

### Benefits

1. **Dynamic Generation**: Create animations based on user settings, theme options, or content
2. **Maintainability**: Centralized animation logic in PHP classes
3. **Consistency**: Standardized naming conventions and utility classes
4. **Scalability**: Easy to add new animation types and presets
5. **WordPress Integration**: Native integration with WordPress hooks and shortcodes
6. **Accessibility**: Built-in support for `prefers-reduced-motion`
7. **Performance**: Generate only the CSS you need

### Use Cases

- Real estate property animations
- Handwriting and typewriter effects
- Content reveal animations
- Interactive UI elements
- Custom animation sets per page/post

## File Structure

```
wp-content/themes/reia-hello-child/
├── inc/
│   ├── class-css-animation-builder.php    # Main animation builder class
│   └── animation-generator-demo.php       # Usage examples and WordPress integration
├── animation-test.php                     # Test script
└── animation-test-output.html            # Generated demo HTML
```

## Core Components

### 1. CSSAnimationBuilder Class

**Location**: `inc/class-css-animation-builder.php`

**Key Features**:
- Configurable animation prefixes and timing
- Built-in animation types (fade, slide, bounce, typewriter, etc.)
- Utility class generation
- CSS custom properties support
- Accessibility features
- Minification support

**Configuration Options**:
```php
$config = [
    'prefix' => 'reia',
    'duration_base' => 1.0,
    'delay_base' => 0.5,
    'easing' => 'cubic-bezier(0.4, 0, 0.2, 1)',
    'accessibility' => true,
    'modern_features' => true
];
```

### 2. Animation Types Available

#### Basic Animations
- **Fade**: `addFade($name, $direction, $distance)`
- **Slide**: `addSlide($name, $direction, $distance)`
- **Bounce**: `addBounce($name, $intensity)`
- **Rotate**: `addRotate($name, $degrees, $direction)`
- **Scale**: `addScale($name, $startScale, $endScale)`
- **Shake**: `addShake($name, $intensity)`
- **Pulse**: `addPulse($name, $maxScale)`
- **Flip**: `addFlip($name, $axis, $degrees)`

#### Specialized Animations
- **Typewriter**: `addTypewriter($name, $steps, $cursor)`
- **Custom**: `addAnimation($name, $keyframes, $properties, $animationProps)`

### 3. Utility Classes

**Duration**: `.prefix-duration-1` through `.prefix-duration-10`
**Delay**: `.prefix-delay-1` through `.prefix-delay-10`
**Easing**: `.prefix-linear`, `.prefix-ease`, `.prefix-bounce`, etc.
**Iteration**: `.prefix-repeat-1`, `.prefix-repeat-infinite`, etc.

## Usage Examples

### Basic Usage

```php
// Create animation builder
$builder = new CSSAnimationBuilder([
    'prefix' => 'reia',
    'accessibility' => true
]);

// Add animations
$builder->addFade('fadeInUp', 'in', '30px')
        ->addTypewriter('typewriter', 40, true)
        ->addBounce('propertyBounce');

// Generate CSS
$css = $builder->generateCSS();

// Save to file
$builder->saveToFile('animations.css');
```

### Real Estate Property Animation

```php
$builder->addAnimation('propertyReveal', [
    '0%' => [
        'opacity' => '0',
        'transform' => 'translateY(40px) scale(0.9)',
        'box-shadow' => '0 0 0 rgba(0,0,0,0)'
    ],
    '100%' => [
        'opacity' => '1',
        'transform' => 'translateY(0) scale(1)',
        'box-shadow' => '0 10px 25px rgba(0,0,0,0.1)'
    ]
]);
```

### Handwriting Effect

```php
$builder->addAnimation('quillWrite', [
    '0%' => [
        'width' => '0',
        'opacity' => '0',
        'border-right' => '3px solid transparent'
    ],
    '1%' => [
        'opacity' => '1',
        'border-right' => '3px solid #8B4513'
    ],
    '100%' => [
        'width' => '100%',
        'opacity' => '1',
        'border-right' => '3px solid transparent'
    ]
], [
    'overflow' => 'hidden',
    'white-space' => 'nowrap',
    'font-family' => "'Dancing Script', cursive"
], [
    'animation-timing-function' => 'steps(40, end)'
]);
```

## WordPress Integration

### 1. Enqueue Generated CSS

```php
add_action('wp_enqueue_scripts', function() {
    $builder = new CSSAnimationBuilder(['prefix' => 'reia']);
    $builder->addFade('fadeIn')->addTypewriter('typewriter');
    
    // Save CSS
    $upload_dir = wp_upload_dir();
    $css_file = $upload_dir['basedir'] . '/reia-animations.css';
    $builder->saveToFile($css_file);
    
    // Enqueue
    wp_enqueue_style(
        'reia-animations',
        $upload_dir['baseurl'] . '/reia-animations.css',
        [],
        '1.0.0'
    );
});
```

### 2. Shortcode Integration

```php
// Animation shortcode
add_shortcode('reia_animate', function($atts, $content = '') {
    $atts = shortcode_atts([
        'type' => 'fadeIn',
        'duration' => '1',
        'delay' => '0',
        'class' => ''
    ], $atts);
    
    $classes = [
        'reia-animated',
        'reia-' . $atts['type'],
        'reia-duration-' . $atts['duration'],
        'reia-delay-' . $atts['delay'],
        $atts['class']
    ];
    
    return sprintf(
        '<div class="%s">%s</div>',
        esc_attr(implode(' ', array_filter($classes))),
        do_shortcode($content)
    );
});

// Handwriting shortcode
add_shortcode('handwrite', function($atts, $content = '') {
    $atts = shortcode_atts([
        'style' => 'quill',
        'duration' => '3',
        'delay' => '0'
    ], $atts);
    
    $animation_map = [
        'quill' => 'quillWrite',
        'fountain' => 'fountainWrite',
        'typewriter' => 'typewriter'
    ];
    
    $animation = $animation_map[$atts['style']] ?? 'quillWrite';
    
    return sprintf(
        '<span class="hw-animated hw-%s hw-duration-%s hw-delay-%s">%s</span>',
        esc_attr($animation),
        esc_attr($atts['duration']),
        esc_attr($atts['delay']),
        esc_html($content)
    );
});
```

## HTML Usage

### Basic Animation Classes

```html
<!-- Fade in animation -->
<div class="reia-animated reia-fadeInUp reia-duration-2">
    <h2>Property Title</h2>
    <p>Property description...</p>
</div>

<!-- Typewriter effect -->
<span class="reia-animated reia-typewriter reia-duration-3">
    Welcome to REIA Properties
</span>

<!-- Delayed property card -->
<div class="reia-animated reia-propertyReveal reia-delay-1 reia-duration-2">
    Property card content
</div>
```

### Shortcode Usage

```html
[reia_animate type="propertyReveal" duration="2" delay="1"]
    <div class="property-card">
        <h3>Beautiful Family Home</h3>
        <p>$450,000</p>
    </div>
[/reia_animate]

[handwrite style="quill" duration="3"]Your handwritten message[/handwrite]
```

## Generated CSS Structure

### CSS Custom Properties
```css
:root {
  --reia-duration: 1s;
  --reia-delay: 0s;
  --reia-easing: cubic-bezier(0.4, 0, 0.2, 1);
  --reia-iteration: 1;
}
```

### Accessibility Support
```css
@media (prefers-reduced-motion: reduce) {
  .reia-animated,
  [class*="reia-"] {
    animation: none !important;
    transition: none !important;
  }
}
```

### Base Animated Class
```css
.reia-animated {
  animation-duration: var(--reia-duration);
  animation-delay: var(--reia-delay);
  animation-timing-function: var(--reia-easing);
  animation-iteration-count: var(--reia-iteration);
  animation-fill-mode: both;
  backface-visibility: hidden;
  transform: translate3d(0, 0, 0);
}
```

## Testing

Run the test script to generate demo animations:

```bash
cd wp-content/themes/reia-hello-child
php animation-test.php > animation-demo.html
```

This generates:
- Complete CSS with all animations
- HTML demo page with examples
- List of available animation classes

## Performance Considerations

1. **Lazy Loading**: Generate CSS only when needed
2. **Caching**: Cache generated CSS files
3. **Conditional Loading**: Load animations only on pages that use them
4. **Minification**: Use `generateCSS(true)` for minified output
5. **Modern Features**: Enable hardware acceleration with `modern_features: true`

## Future Enhancements

1. **Admin Interface**: WordPress admin panel for managing animations
2. **Animation Presets**: Pre-built animation sets for different industries
3. **Visual Builder**: Drag-and-drop animation timeline editor
4. **Performance Analytics**: Track animation usage and performance
5. **Export/Import**: Share animation sets between sites

## Conclusion

The PHP-driven CSS animation system provides a robust, maintainable approach to managing animations in WordPress themes. It combines the flexibility of PHP with the performance of CSS, creating a powerful toolset for dynamic web experiences.

Key advantages:
- ✅ Maintainable and scalable
- ✅ WordPress-native integration
- ✅ Accessibility compliant
- ✅ Performance optimized
- ✅ Developer-friendly
- ✅ Extensible architecture

This system serves as the foundation for all REIA theme animations and can be extended for future animation needs.
