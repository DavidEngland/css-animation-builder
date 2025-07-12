# WordPress Plugin Installation Instructions

## Quick Setup for Testing in reia-new Local Site

### 1. Copy Plugin Files
Copy the entire `css-animation-builder-standalone` folder to your WordPress plugins directory:
```
/path/to/reia-new/wp-content/plugins/css-animation-builder/
```

### 2. Main Plugin File
Rename `css-animation-builder-wordpress.php` to `css-animation-builder.php` in the plugin directory.

### 3. Required Directory Structure
```
wp-content/plugins/css-animation-builder/
├── css-animation-builder.php (main plugin file)
├── src/
│   ├── Builder.php
│   └── WordPressPlugin.php
├── assets/
│   ├── js/
│   │   ├── typewriter-animation.js
│   │   ├── handwriting-animation.js
│   │   └── animation-builder.js
│   └── css/
│       ├── text-animations.css
│       └── animation-builder.css
└── README.md
```

### 4. Activate Plugin
1. Go to WordPress Admin → Plugins
2. Find "CSS Animation Builder" 
3. Click "Activate"

### 5. Quick Test Shortcodes

#### Typewriter Animation
```
[typewriter speed="100" theme="default" text="Hello from REIA!"]
```

#### Handwriting Animation (Old English Script)
```
[handwriting speed="50" style="old-english" color="#2c3e50" text="David England"]
```

#### Advanced Typewriter with Multiple Sequences
```
[css-animation-builder theme="default" show_preview="true" animations="typewriter,handwriting"]
```

### 6. Admin Interface
- Navigate to **Animation Builder** in WordPress admin menu
- Full interface with preview, code generation, and preset management
- Real-time preview of animations

### 7. Gutenberg Block (if available)
- Add "CSS Animation Builder" block in Gutenberg editor
- Configure animations directly in the block editor

### 8. Troubleshooting
- Check browser console for JavaScript errors
- Ensure all asset files are properly uploaded
- Verify file permissions (755 for directories, 644 for files)

## Advanced Features Available

### Typewriter Animations
- Human-like typing variations
- Typing mistakes simulation
- Multiple text sequences
- Sound effects integration
- Customizable cursors and themes

### Handwriting Animations
- SVG-based realistic writing
- Multiple pen types (fountain, quill, ballpoint)
- Old English Script styling
- Signature effects
- Animated pen cursor

### Themes
- Default, Terminal, Retro
- Old English Script for signatures
- Customizable colors and fonts

## Support
- **Developer**: David England <DavidEngland@hotmail.com>
- **Company**: Real Estate Intelligence Agency (REIA)
- **CEO & Chief Broker**: Mikko P. Jetsu
- **Version**: 1.1.0
