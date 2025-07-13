# WordPress Plugin Testing Guide

## Fixed Plugin File: `css-animation-builder-fixed.php`

The original plugin had several issues that have been resolved:

### Issues Fixed:
1. **Version Mismatches** - Now consistently v1.4.0 throughout
2. **Asset Loading** - Proper WordPress asset enqueueing
3. **Single Plugin File** - Consolidated into one clean file
4. **Shortcode Functionality** - All shortcodes now work properly
5. **Admin Interface** - Clean admin panel with live examples

### Installation Instructions:

1. **Remove old plugin files** (if any exist):
   - Delete any existing CSS Animation Builder plugin files
   - Remove `css-animation-builder-wordpress.php` 

2. **Install the fixed plugin**:
   - Rename `css-animation-builder-fixed.php` to `css-animation-builder.php`
   - Upload to your WordPress plugins directory
   - Activate through WordPress admin

3. **Verify directory structure**:
   ```
   wp-content/plugins/css-animation-builder/
   ├── css-animation-builder.php (main plugin file)
   └── assets/
       ├── css/
       │   ├── admin.css
       │   └── handwriting-animations.css
       └── js/
           ├── admin.js
           └── frontend-animations.js
   ```

## Test Content

Copy and paste this content into a WordPress post or page to test:

### Basic Handwriting Animations

```
<h2>Handwriting Animation Tests</h2>

<h3>Quill Style (Default)</h3>
[css-animation class="handwriting-quill" text="Welcome to our website"]

<h3>Fountain Pen Style</h3>
[css-animation class="handwriting-fountain" text="Elegant and sophisticated"]

<h3>Casual Script</h3>
[css-animation class="handwriting-casual" text="Friendly and approachable"]

<h3>Signature Style</h3>
[css-animation class="handwriting-signature" text="John Doe"]

<h3>Custom Duration</h3>
[css-animation class="handwriting-quill" text="This animation is slower" duration="8s"]
```

### Shortcode Variations

```
<h2>Shortcode Variations</h2>

<h3>Using handwriting shortcode</h3>
[handwriting style="quill" text="This uses the handwriting shortcode"]
[handwriting style="fountain" text="Fountain pen style"]
[handwriting style="casual" text="Casual handwriting"]

<h3>Using typewriter shortcode</h3>
[typewriter text="This text appears with typewriter effect" speed="80"]
[typewriter text="Faster typing" speed="50"]
```

### Full Test Page Content

```html
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    
    <h1>CSS Animation Builder Test Page</h1>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h2>Welcome Message</h2>
        [css-animation class="handwriting-quill" text="Welcome to our beautiful website"]
    </div>
    
    <div style="background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h2>Elegant Greeting</h2>
        [css-animation class="handwriting-fountain" text="Thank you for visiting us today"]
    </div>
    
    <div style="background: #d1ecf1; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h2>Casual Message</h2>
        [css-animation class="handwriting-casual" text="Hope you enjoy your stay!"]
    </div>
    
    <div style="background: #f8d7da; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h2>Signature</h2>
        [css-animation class="handwriting-signature" text="Best regards, The Team"]
    </div>
    
    <div style="background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h2>Typewriter Effect</h2>
        [typewriter text="This message appears letter by letter..." speed="100"]
    </div>
    
</div>
```

## Troubleshooting

### If animations don't appear:

1. **Check browser console** for JavaScript errors
2. **Verify assets are loading**:
   - Go to page source and check if CSS/JS files are included
   - Look for 404 errors in browser network tab

3. **Check WordPress admin**:
   - Go to "CSS Animations" in admin menu
   - Verify settings are correct
   - See if admin panel loads properly

4. **Test with different themes**:
   - Try with a default WordPress theme
   - Some themes may conflict with animations

### Common Issues:

- **Shortcodes show as text**: Plugin not activated properly
- **No animations**: CSS/JS files not loading correctly
- **Console errors**: JavaScript conflicts with theme/other plugins

### Debug Steps:

1. Activate a default WordPress theme
2. Deactivate all other plugins temporarily
3. Test with the provided content above
4. Check browser developer tools for errors

## Plugin Features

### Available Shortcodes:
- `[css-animation]` - Main shortcode with full customization
- `[handwriting]` - Simplified handwriting shortcode
- `[typewriter]` - Typewriter effect shortcode

### Admin Features:
- Settings page with Google Fonts toggle
- Live preview of animations
- Copy-to-clipboard shortcode examples
- Mobile animation controls

### Performance Features:
- Conditional asset loading (only loads when shortcodes are used)
- Intersection Observer for trigger-on-scroll
- Mobile-optimized animations
- Google Fonts optimization

The plugin should now work perfectly! Let me know if you encounter any issues.
