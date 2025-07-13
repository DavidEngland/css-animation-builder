# CSS Animation Builder 🎨

[![Version](https://img.shields.io/badge/version-1.6.0-blue.svg)](https://github.com/DavidEngland/css-animation-builder)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Build Status](https://github.com/DavidEngland/css-animation-builder/workflows/CI/badge.svg)](https://github.com/DavidEngland/css-animation-builder/actions)

A standalone, framework-agnostic CSS Animation Builder library that provides an interactive interface for creating beautiful CSS animations. Works as a Composer package, WordPress plugin, or standalone HTML/JS application.

![CSS Animation Builder Demo](https://via.placeholder.com/800x400/007cba/ffffff?text=CSS+Animation+Builder+Demo)

## ✨ Features

- 🎨 **Interactive Animation Builder** - Visual interface for creating animations
- 🎭 **29+ Animation Types** - From basic fades to complex handwriting effects
- ⚡ **Live Preview** - Real-time animation preview with controls
- 📋 **Code Generation** - Generate clean CSS and HTML code
- 🎯 **Framework Agnostic** - Works with any web framework or vanilla HTML
- 📱 **Mobile Responsive** - Touch-friendly interface
- 🔧 **Highly Configurable** - Extensive customization options
- 🎪 **Animation Presets** - Quick-start templates for common use cases
- ♿ **Accessibility** - ARIA attributes, high contrast, reduced motion support

## � Quick Start

### Basic Animations (Start Here!)

The CSS Animation Builder includes these fundamental animations that work great for most projects:

**Entrance Effects:**
- `fadeIn` - Smooth fade in effect
- `slideInLeft`, `slideInRight` - Slide from sides
- `slideInUp`, `slideInDown` - Slide from top/bottom
- `zoomIn` - Scale up entrance
- `bounceIn` - Bouncy entrance

**Exit Effects:**
- `fadeOut` - Smooth fade out
- `slideOutLeft`, `slideOutRight` - Slide to sides
- `zoomOut` - Scale down exit

**Attention Effects:**
- `pulse` - Gentle pulsing
- `shake` - Attention shake
- `wobble` - Playful wobble

### Advanced Animation Suites

**🍂 DangleFall Physics Suite** - Realistic falling effects:
- `dangleFall` - Natural falling motion
- `dangleFallSpiral` - Spiral descent
- `cascadeFall` - Waterfall effect
- Seasonal variants (maple leaves, snowflakes, petals)

**✍️ Handwriting Collection** - Professional typewriter effects:
- `quillWriting` - Ink trail effects
- `fountainPen` - Enhanced shadows
- `calligraphy` - Letter-spacing animation
- `handwritingReveal` - Blur-to-sharp transition

[View Handwriting Demo](handwriting-integration-demo.html) | [View Seasonal Demo](dangleFall-demo.html)

## 📦 Installation

### NPM Package

```bash
npm install @reia/css-animation-builder
```

```javascript
import CSSAnimationBuilder from '@reia/css-animation-builder';

const builder = new CSSAnimationBuilder({
    container: '#animation-builder'
});
builder.init();
```

### CDN (Quick Setup)

```html
<link rel="stylesheet" href="https://unpkg.com/@reia/css-animation-builder/dist/css-animation-builder.css">
<script src="https://unpkg.com/@reia/css-animation-builder/dist/css-animation-builder.min.js"></script>

<div id="animation-builder"></div>
<script>
    const builder = new CSSAnimationBuilder({
        container: '#animation-builder'
    });
    builder.init();
</script>
```

### Composer (PHP)

```bash
composer require reia/css-animation-builder
```

```php
use Reia\CSSAnimationBuilder\Builder;

$builder = new Builder();
echo $builder->render();
```

### WordPress Plugin

1. Download the plugin files
2. Upload to `/wp-content/plugins/css-animation-builder/`
3. Activate the plugin
4. Use shortcode: `[css-animation-builder]`

### Development Setup

```bash
git clone https://github.com/DavidEngland/css-animation-builder.git
cd css-animation-builder
npm install && composer install
npm run build
```

## ⚙️ Configuration

### Basic Setup

```javascript
const builder = new CSSAnimationBuilder({
    container: '#animation-builder',
    theme: 'default',
    showPreview: true,
    animations: ['fadeIn', 'slideInLeft', 'bounceIn']
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
                100% { transform: scale(1); opacity: 1; }
            `
        }
    },
    callbacks: {
        onAnimationChange: (animation) => console.log('Animation changed:', animation)
    }
});
```

## 📚 API Reference

### JavaScript API

```javascript
const builder = new CSSAnimationBuilder(options);

// Methods
builder.init()                    // Initialize builder
builder.destroy()                 // Cleanup
builder.getAnimation()            // Get current settings
builder.setAnimation(settings)    // Set animation
builder.generateCSS()             // Generate CSS code
builder.preview()                 // Preview animation
```

### PHP API

```php
use Reia\CSSAnimationBuilder\Builder;

$builder = new Builder($config);
echo $builder->render();          // Render HTML
$builder->generateCSS($animation, $options);  // Generate CSS
```

## 📈 Changelog

### v1.6.0 (Current)
- ✨ Enhanced seasonal animations with 11 new effects
- 🎨 Interactive seasonal theme controls
- 🍂 Comprehensive dangleFall demo showcase
- 📝 Complete animation possibilities documentation

### v1.5.0 
- ✍️ Professional handwriting animations integration
- 🎯 Superior 15° cursor positioning 
- 🖋️ 5 handwriting styles (Quill, Fountain Pen, Calligraphy, etc.)
- 📊 Library expanded from 18+ to 29+ animations

### v1.4.0
- 🍂 DangleFall physics-based animation suite
- 🌟 5 realistic falling animation variants
- ⚙️ Enhanced animation builder interface

[View Complete Changelog](CHANGELOG.md)

## 🏗️ Architecture

Modern **file-based keyframes architecture** for maximum maintainability:

```
src/
├── Builder.php              # Main animation builder class
├── Keyframes/               # Individual keyframe files
│   ├── fadeIn.css
│   ├── slideInLeft.css
│   └── ... (29+ animations)
└── WordPressPlugin.php      # WordPress integration
```

**Benefits:**
- **Modular Design**: Each animation in its own file
- **Easy Maintenance**: Modify animations without touching core code
- **Scalable**: Add new animations by creating new files

## 🎨 Customization

### Custom Themes

```css
.css-animation-builder.theme-custom {
    --primary-color: #your-color;
    --background-color: #your-color;
    --text-color: #your-color;
}
```

### Custom Animations

```javascript
builder.addCustomAnimation('myAnimation', {
    name: 'My Custom Animation',
    keyframes: `
        0% { transform: translateX(0); }
        100% { transform: translateX(100px); }
    `
});
```

## 🛠️ Development

### Project Structure

```
css-animation-builder/
├── assets/                  # Frontend source
├── src/                     # PHP source files
├── tests/                   # Test files
├── examples/                # Usage examples
└── docs/                    # Documentation
```

### Building from Source

```bash
npm install && composer install
npm run build
npm test && composer test
```

## 🤝 About REIA

Developed by **Real Estate Intelligence Agency (REIA)** full stack development team.

**Team:**
- **Senior Lead Developer**: [David England](https://github.com/DavidEngland)
- **CEO & Chief Broker**: Mikko P. Jetsu

**Organization:**
- **Website**: realestateintelligenceagency.com *(coming soon)*
- **GitHub**: [github.com/DavidEngland/css-animation-builder](https://github.com/DavidEngland/css-animation-builder)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes and add tests
4. Commit changes (`git commit -m 'Add amazing feature'`)
5. Push to branch (`git push origin feature/amazing-feature`)
6. Open a Pull Request

## 📄 License

MIT License - see [LICENSE](LICENSE) file for details.

## 🔗 Links

- **Documentation**: [Full Documentation](https://davidengland.github.io/css-animation-builder/)
- **NPM Package**: [@reia/css-animation-builder](https://www.npmjs.com/package/@reia/css-animation-builder)
- **Issues**: [GitHub Issues](https://github.com/DavidEngland/css-animation-builder/issues)
- **Discussions**: [GitHub Discussions](https://github.com/DavidEngland/css-animation-builder/discussions)

---

**Made with ❤️ by [David England](https://github.com/DavidEngland)**
