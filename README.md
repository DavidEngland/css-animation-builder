# CSS Animation Builder 🎨

[![Version](https://img.shields.io/badge/version-1.0.1-blue.svg)](https://github.com/DavidEngland/css-animation-builder)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Build Status](https://github.com/DavidEngland/css-animation-builder/workflows/CI/badge.svg)](https://github.com/DavidEngland/css-animation-builder/actions)

A standalone, framework-agnostic CSS Animation Builder library that provides an interactive interface for creating beautiful CSS animations. Works as a Composer package, WordPress plugin, or standalone HTML/JS application.

![CSS Animation Builder Demo](https://via.placeholder.com/800x400/007cba/ffffff?text=CSS+Animation+Builder+Demo)

## ✨ Features

- 🎨 **Interactive Animation Builder** - Visual interface for creating animations
- 🎭 **18+ Animation Types** - Fade, slide, zoom, bounce, rotate, shake, and more
- ⚡ **Live Preview** - Real-time animation preview with controls
- 📋 **Code Generation** - Generate clean CSS and HTML code
- 🎯 **Framework Agnostic** - Works with any web framework or vanilla HTML
- 📱 **Mobile Responsive** - Touch-friendly interface
- 🔧 **Highly Configurable** - Extensive customization options
- 🎪 **Animation Presets** - Quick-start templates for common use cases
- 🌙 **Multiple Themes** - Default, dark, and minimal themes
- ♿ **Accessibility** - ARIA attributes, high contrast, reduced motion support

## 🚀 Quick Start

### Via npm

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

### Via CDN

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

### Via Composer (PHP)

```bash
composer require reia/css-animation-builder
```

```php
use Reia\CSSAnimationBuilder\Builder;

$builder = new Builder();
echo $builder->render();
```

## 📦 Installation Options

### 1. NPM Package (Available Soon)

The NPM package will be published by a collaborator. For now, you can:

```bash
# Clone and build locally
git clone https://github.com/DavidEngland/css-animation-builder.git
cd css-animation-builder
npm install
npm run build
```

### 2. Composer Package (Coming Soon)

Will be available on Packagist:

```bash
# This will be available soon
composer require davidengland/css-animation-builder
```

### 3. Standalone Usage

Download the latest release files and include them in your HTML:

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

### 2. WordPress Plugin

1. Download the plugin files
2. Upload to `/wp-content/plugins/css-animation-builder/`
3. Activate the plugin
4. Use the shortcode `[css-animation-builder]`

### 3. Development Setup

```bash
# Clone the repository
git clone https://github.com/DavidEngland/css-animation-builder.git
cd css-animation-builder

# Install dependencies
npm install
composer install

# Build the project
npm run build

# Run tests
npm test
composer test

# Start development
npm run dev
```

## 🎯 Animation Types

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

## ⚙️ Configuration

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

## 📚 API Reference

### JavaScript API

#### Constructor Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `container` | string | `'#animation-builder'` | CSS selector for container element |
| `theme` | string | `'default'` | Theme name (`default`, `dark`, `minimal`) |
| `showPreview` | boolean | `true` | Show live preview area |
| `showCode` | boolean | `true` | Show generated code output |
| `animations` | array | `[...]` | Available animation types |
| `customAnimations` | object | `{}` | Custom animation definitions |
| `callbacks` | object | `{}` | Event callbacks |

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

### PHP API

#### Builder Class

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

## 🎨 Customization

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

## 🔧 WordPress Integration

### Shortcode Usage

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

## 🛠️ Development

### Project Structure

```
css-animation-builder/
├── .github/workflows/       # GitHub Actions workflows
├── assets/                  # Frontend source code
│   ├── js/                 # JavaScript source files
│   ├── css/                # CSS files
│   └── scss/               # SCSS source files
├── dist/                   # Built files (generated)
├── src/                    # PHP source files
├── tests/                  # Test files
├── examples/               # Usage examples
└── docs/                   # Documentation
```

### Building from Source

```bash
# Install dependencies
npm install
composer install

# Build assets
npm run build

# Run tests
npm test
composer test

# Generate documentation
npm run docs

# Start development server
npm run dev
```

### Testing

```bash
# Run JavaScript tests
npm test

# Run PHP tests
composer test

# Run tests with coverage
npm run test:coverage
```

## 🤝 About REIA

This project is developed by the **Real Estate Intelligence Agency (REIA)** full stack development team.

### Team
- **Senior Lead Developer**: [David England](https://github.com/DavidEngland) - DavidEngland@hotmail.com
- **CEO & Chief Broker**: Mikko P. Jetsu - Mikko@RealEstate-Huntsville.com

### Organization
- **Website**: realestateintelligenceagency.com *(coming soon)*
- **GitHub**: [github.com/DavidEngland/css-animation-builder](https://github.com/DavidEngland/css-animation-builder)

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass
6. Commit your changes (`git commit -m 'Add amazing feature'`)
7. Push to the branch (`git push origin feature/amazing-feature`)
8. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🔗 Links

- **Documentation**: [Full Documentation](https://davidengland.github.io/css-animation-builder/)
- **NPM Package**: [@reia/css-animation-builder](https://www.npmjs.com/package/@reia/css-animation-builder)
- **Packagist**: [reia/css-animation-builder](https://packagist.org/packages/reia/css-animation-builder)
- **Issues**: [GitHub Issues](https://github.com/DavidEngland/css-animation-builder/issues)
- **Discussions**: [GitHub Discussions](https://github.com/DavidEngland/css-animation-builder/discussions)

## 📈 Changelog

See [CHANGELOG.md](CHANGELOG.md) for a list of changes and releases.

## 🙏 Acknowledgments

- Inspired by modern animation libraries
- Built with modern web standards
- Community-driven development

---

<p align="center">
  <strong>Made with ❤️ by <a href="https://github.com/DavidEngland">David England</a></strong>
</p>

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
