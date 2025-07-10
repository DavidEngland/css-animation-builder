# CSS Animation Builder

A standalone, framework-agnostic CSS Animation Builder library that provides an interactive interface for creating beautiful CSS animations. Works as a Composer package, WordPress plugin, or standalone HTML/JS application.

## Features

- 🎨 **Interactive Animation Builder** - Visual interface for creating animations
- 🎭 **14+ Animation Types** - Fade, slide, zoom, bounce, rotate, and more
- ⚡ **Live Preview** - Real-time animation preview with controls
- 📋 **Code Generation** - Generate clean CSS and HTML code
- 🎯 **Framework Agnostic** - Works with any web framework or vanilla HTML
- 📱 **Mobile Responsive** - Touch-friendly interface
- 🔧 **Highly Configurable** - Extensive customization options
- 🎪 **Animation Presets** - Quick-start templates for common use cases

## Installation

### Via Composer

```bash
composer require reia/css-animation-builder
```

### Via WordPress Plugin

1. Download the plugin files
2. Upload to `/wp-content/plugins/css-animation-builder/`
3. Activate the plugin
4. Use the shortcode `[css-animation-builder]` or the provided template

### Standalone Usage

1. Download the release files
2. Include the CSS and JS files in your HTML
3. Initialize the builder on your page

## Quick Start

### PHP/Composer Usage

```php
use Reia\CSSAnimationBuilder\Builder;

$builder = new Builder();
$html = $builder->render();
echo $html;
```

### WordPress Shortcode

```php
[css-animation-builder]
```

### Standalone HTML

```html
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="dist/css-animation-builder.css">
</head>
<body>
    <div id="animation-builder"></div>
    <script src="dist/css-animation-builder.js"></script>
    <script>
        const builder = new CSSAnimationBuilder({
            container: '#animation-builder'
        });
        builder.init();
    </script>
</body>
</html>
```

## Configuration

### Basic Configuration

```javascript
const builder = new CSSAnimationBuilder({
    container: '#animation-builder',
    theme: 'default',
    showPreview: true,
    showCode: true,
    animations: [
        'fadeIn', 'slideInLeft', 'bounceIn', 'zoomIn'
    ]
});
```

### Advanced Configuration

```javascript
const builder = new CSSAnimationBuilder({
    container: '#animation-builder',
    theme: 'dark',
    customAnimations: {
        'customBounce': {
            name: 'Custom Bounce',
            keyframes: `
                0% { transform: scale(0.3); opacity: 0; }
                50% { transform: scale(1.05); opacity: 0.8; }
                100% { transform: scale(1); opacity: 1; }
            `
        }
    },
    defaults: {
        duration: 1.0,
        delay: 0.0,
        timingFunction: 'ease',
        iterationCount: 1
    },
    callbacks: {
        onAnimationChange: (animation) => console.log('Animation changed:', animation),
        onCodeGenerated: (code) => console.log('Code generated:', code)
    }
});
```

## Animation Types

### Entrance Animations
- `fadeIn` - Fade in with opacity
- `slideInLeft` - Slide in from left
- `slideInRight` - Slide in from right
- `slideInUp` - Slide in from bottom
- `slideInDown` - Slide in from top
- `zoomIn` - Zoom in effect
- `bounceIn` - Bouncy entrance
- `rotateIn` - Rotate in effect

### Exit Animations
- `fadeOut` - Fade out
- `slideOutLeft` - Slide out to left
- `slideOutRight` - Slide out to right
- `zoomOut` - Zoom out effect

### Attention Animations
- `pulse` - Pulsing effect
- `shake` - Shaking effect
- `wobble` - Wobbling effect
- `swing` - Swinging effect

## API Reference

### Builder Class

```php
use Reia\CSSAnimationBuilder\Builder;

$builder = new Builder($config);
```

#### Methods

- `render()` - Render the complete HTML interface
- `getAnimations()` - Get list of available animations
- `generateCSS($animation, $options)` - Generate CSS for specific animation
- `setTheme($theme)` - Set the UI theme
- `addCustomAnimation($name, $keyframes)` - Add custom animation

### JavaScript API

```javascript
const builder = new CSSAnimationBuilder(config);
```

#### Methods

- `init()` - Initialize the builder
- `destroy()` - Destroy the builder instance
- `getAnimation()` - Get current animation settings
- `setAnimation(settings)` - Set animation settings
- `generateCSS()` - Generate CSS code
- `preview()` - Preview animation
- `reset()` - Reset to defaults

#### Events

- `animationChange` - Fired when animation settings change
- `codeGenerated` - Fired when CSS code is generated
- `previewStarted` - Fired when preview starts
- `previewStopped` - Fired when preview stops

## Customization

### Custom Themes

```css
/* Custom theme example */
.css-animation-builder.theme-custom {
    --primary-color: #your-color;
    --secondary-color: #your-color;
    --background-color: #your-color;
    --text-color: #your-color;
    --border-color: #your-color;
}
```

### Custom Animations

```javascript
builder.addCustomAnimation('myAnimation', {
    name: 'My Custom Animation',
    keyframes: `
        0% { transform: translateX(0); }
        50% { transform: translateX(100px); }
        100% { transform: translateX(0); }
    `,
    defaultDuration: 2.0
});
```

## WordPress Integration

### Shortcode Attributes

```php
[css-animation-builder theme="dark" show-presets="true" show-advanced="false"]
```

### Theme Integration

```php
// In your theme's functions.php
function my_theme_animation_builder() {
    if (class_exists('Reia\CSSAnimationBuilder\Builder')) {
        $builder = new Reia\CSSAnimationBuilder\Builder([
            'theme' => 'my-theme',
            'animations' => ['fadeIn', 'slideInLeft', 'bounceIn']
        ]);
        return $builder->render();
    }
    return '';
}
```

## Development

### Building from Source

```bash
# Install dependencies
composer install
npm install

# Build assets
npm run build

# Run tests
composer test

# Generate documentation
npm run docs
```

### Testing

```bash
# Run PHP tests
composer test

# Run JavaScript tests
npm test

# Run all tests
npm run test:all
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass
6. Submit a pull request

## License

MIT License - see LICENSE file for details

## Support

- **Documentation**: [Full documentation](https://docs.example.com)
- **Issues**: [GitHub Issues](https://github.com/reia/css-animation-builder/issues)
- **Discussions**: [GitHub Discussions](https://github.com/reia/css-animation-builder/discussions)

## Changelog

### 1.0.0
- Initial release
- Core animation builder functionality
- WordPress plugin support
- Composer package support
- Standalone HTML/JS support
