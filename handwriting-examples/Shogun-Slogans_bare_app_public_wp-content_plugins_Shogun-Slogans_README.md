# Shogun Slogans WordPress Plugin

A powerful WordPress plugin for creating animated slogans and typewriter text effects. Perfect for adding dynamic, eye-catching text to your website.

## ⚠️ IMPORTANT NOTES

**TODO: Advanced SVG Animator Issue**
- The Advanced SVG Animator plugin became unstable after recent modifications
- Activation error occurs - needs debugging when time allows  
- This Shogun Slogans plugin is independent and works standalone
- Do not rely on Advanced SVG Animator until fixed
- Use this plugin as the primary typewriter solution for now

## Features

- **Typewriter Effect**: Character-by-character typing animation
- **Customizable Speed**: Control typing speed from fast to slow
- **Custom Cursors**: Use different cursor characters (|, _, ▌, █, etc.)
- **Loop Control**: Choose between continuous looping or single play
- **Delay Options**: Add delays before animation starts
- **Responsive Design**: Works perfectly on all devices
- **Accessibility**: Respects reduced motion preferences
- **SEO Friendly**: Proper semantic markup
- **Easy Integration**: Simple shortcodes for quick implementation

## Installation

1. Upload the plugin files to `/wp-content/plugins/shogun-slogans/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use shortcodes in your posts, pages, or widgets

## Quick Start

### Basic Typewriter
```
[typewriter_text text="Hello World!"]
```

### Fast Typing
```
[typewriter_text text="Fast typing!" speed="50"]
```

### Custom Cursor
```
[typewriter_text text="Custom cursor" cursor="▌"]
```

## Shortcodes

### typewriter_text
Creates a typewriter effect that types out text character by character.

**Parameters:**
- `text` - The text to display (required)
- `speed` - Typing speed in milliseconds (default: 100)
- `cursor` - Cursor character (default: |)
- `loop` - Loop animation true/false (default: true)
- `delay` - Start delay in milliseconds (default: 0)
- `class` - Additional CSS class
- `id` - HTML ID attribute

### shogun_slogan
Displays text with animation effects.

**Parameters:**
- `text` - The slogan text (required)
- `style` - Animation style: fade, slide, typewriter (default: fade)
- `class` - Additional CSS class
- `id` - HTML ID attribute

## Examples

### Marketing Headlines
```
[typewriter_text text="Welcome to our amazing website!" speed="80"]
```

### Code Demonstrations
```
[typewriter_text text="console.log('Hello, World!');" speed="60" cursor="█"]
```

### Quotes
```
[typewriter_text text="The only way to do great work is to love what you do." speed="70"]
```

### No Loop (Type Once)
```
[typewriter_text text="This appears once only" loop="false"]
```

## PHP Functions

For theme developers:

```php
// Display typewriter text
echo shogun_typewriter('Your text here', 100, '|');

// Display slogan
echo shogun_slogan('Your slogan', 'fade');
```

## Styling

### CSS Classes
Add custom classes for styling:

```
[typewriter_text text="Styled text" class="my-custom-style"]
```

### Built-in Variations
- `.fast` - Faster typing
- `.slow` - Slower typing
- `.dramatic` - Very slow with spacing

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- IE11+ (limited features)

## Performance

- Uses Intersection Observer for efficient animations
- Only animates visible elements
- Pauses when page is not visible
- Optimized for mobile devices

## Accessibility

- ARIA live regions for screen readers
- Respects `prefers-reduced-motion` setting
- Keyboard accessible
- Semantic HTML markup

## Files Structure

```
shogun-slogans/
├── shogun-slogans.php          # Main plugin file
├── assets/
│   ├── css/
│   │   ├── slogans.css         # Frontend styles
│   │   └── admin.css           # Admin styles
│   └── js/
│       └── slogans.js          # Frontend JavaScript
├── README.md                   # This file
├── USAGE.md                   # Detailed usage guide
├── shortcode-reference.md     # Quick reference
└── test-showcase.html         # Live demo
```

## Support

For support, feature requests, or bug reports, please contact the plugin developer.

## License

GPL v2 or later

## Changelog

### Version 2.0.0
- Complete rewrite with improved performance
- Added Intersection Observer for better performance
- Enhanced accessibility features
- Mobile-responsive design
- Added admin dashboard
- Improved shortcode system
- Added PHP helper functions

---

**Made with ❤️ for WordPress**