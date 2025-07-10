# CSS Animation Builder - Standalone Usage Guide

## Overview
The CSS Animation Builder is a framework-agnostic tool for creating CSS animations with an interactive interface. It can be used as a standalone HTML page, integrated into any web application, or used as a WordPress plugin.

## Files Structure
```
css-animation-builder-standalone/
├── README.md                    # This file
├── composer.json               # Composer package configuration
├── css-animation-builder.php   # WordPress plugin entry point
├── example.html               # Basic standalone demo
├── example-enhanced.html      # Enhanced standalone demo (recommended)
├── src/
│   ├── Builder.php           # Core PHP builder class
│   └── WordPressPlugin.php   # WordPress plugin wrapper
```

## Usage Options

### 1. Standalone HTML Page
Simply open `example-enhanced.html` in any web browser to use the animation builder immediately.

**Features:**
- Live animation preview
- Interactive controls (duration, delay, timing functions, etc.)
- Animation presets (attention, bounce, elegant, slide, zoom, rotate)
- Generated CSS, HTML, and keyframes code
- Copy-to-clipboard functionality
- Responsive design

### 2. Integration into Web Applications
Copy the HTML structure, CSS, and JavaScript from `example-enhanced.html` into your existing web application.

**Integration Steps:**
1. Copy the CSS animation keyframes into your stylesheet
2. Copy the HTML structure where you want the builder
3. Copy the JavaScript `CSSAnimationBuilder` class
4. Initialize the builder: `new CSSAnimationBuilder()`

### 3. WordPress Plugin
Copy the entire `css-animation-builder-standalone` folder to your WordPress `wp-content/plugins/` directory and activate it.

**WordPress Features:**
- Shortcode: `[css_animation_builder]`
- Admin page: Tools → CSS Animation Builder
- Block editor support (planned)
- AJAX-powered interface

### 4. Composer Package
Install via Composer for PHP applications:

```bash
# If published to Packagist (future)
composer require reia/css-animation-builder

# Or add to composer.json
{
    "repositories": [
        {
            "type": "path",
            "url": "./path/to/css-animation-builder-standalone"
        }
    ],
    "require": {
        "reia/css-animation-builder": "*"
    }
}
```

## PHP Usage Example
```php
<?php
use Reia\CSSAnimationBuilder\Builder;

// Create builder instance
$builder = new Builder([
    'showPresets' => true,
    'showAdvanced' => true,
    'theme' => 'default'
]);

// Generate HTML interface
echo $builder->renderHTML();

// Generate CSS for specific animation
$css = $builder->generateCSS('fadeIn', [
    'duration' => 1.5,
    'delay' => 0.3,
    'timingFunction' => 'ease-out'
]);

// Generate keyframes
$keyframes = $builder->generateKeyframes('fadeIn');
?>
```

## JavaScript Usage Example
```javascript
// Initialize the builder
const builder = new CSSAnimationBuilder();

// Apply custom preset
builder.addPreset('customFade', {
    type: 'fadeIn',
    duration: 2.5,
    delay: 1,
    timingFunction: 'ease-in-out'
});

// Generate CSS programmatically
const settings = {
    type: 'slideInLeft',
    duration: 1.2,
    delay: 0.5,
    timingFunction: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
    iterationCount: 1,
    direction: 'normal',
    fillMode: 'both',
    transformOrigin: 'center'
};

const css = builder.generateCSSCode(settings);
```

## Available Animations
- **Fade:** fadeIn, fadeOut
- **Slide:** slideInLeft, slideInRight, slideInUp, slideInDown
- **Zoom:** zoomIn, zoomOut
- **Bounce:** bounceIn
- **Rotate:** rotateIn
- **Attention:** pulse, shake, wobble, swing

## Animation Presets
- **Attention:** Infinite pulse animation
- **Bounce:** Bouncy entrance with cubic-bezier timing
- **Elegant:** Slow fade-in with delay
- **Slide:** Quick slide-in from left
- **Zoom:** Smooth zoom-in entrance
- **Rotate:** Rotating entrance effect

## Customization

### Adding Custom Animations
```php
// PHP
$builder->addCustomAnimation('myCustomAnimation', [
    'name' => 'My Custom Animation',
    'keyframes' => '@keyframes myCustomAnimation { ... }',
    'defaultDuration' => 1.5,
    'defaultTiming' => 'ease-in-out'
]);
```

```javascript
// JavaScript
builder.addCustomAnimation('myCustomAnimation', {
    name: 'My Custom Animation',
    keyframes: '@keyframes myCustomAnimation { ... }',
    defaultDuration: 1.5,
    defaultTiming: 'ease-in-out'
});
```

### Styling Customization
The builder uses CSS custom properties (variables) for easy theming:

```css
:root {
    --primary-color: #007cba;
    --secondary-color: #00a0d2;
    --background-color: #f5f5f5;
    --text-color: #333;
    --border-radius: 8px;
}
```

## Browser Support
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+
- Internet Explorer 11 (partial support)

## Performance Considerations
- Animations use CSS transforms and opacity for better performance
- GPU acceleration is enabled for smooth animations
- Minimal JavaScript footprint (~15KB uncompressed)
- CSS animations are more performant than JavaScript animations

## Accessibility
- Respects `prefers-reduced-motion` media query
- Keyboard navigation support
- Screen reader friendly labels
- High contrast mode support

## License
MIT License - Feel free to use in personal and commercial projects.

## Contributing
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Support
For issues and feature requests, please create an issue in the project repository.
