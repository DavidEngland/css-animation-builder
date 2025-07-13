# WordPress Plugin Fix Prompts - CSS Animation Builder

## 🔧 **Critical Missing Files Prompt**

**Prompt:** "I have a WordPress plugin for CSS Animation Builder that's partially working. The shortcodes are registered but the JavaScript and CSS files are missing. I need you to create the complete asset files for:

1. **typewriter.js** - TypewriterAnimation class with character-by-character typing
2. **handwriting.js** - HandwritingAnimation class with handwriting effects
3. **animation-builder.js** - Main animation builder interface
4. **frontend.js** - Frontend utilities and initialization
5. **admin.js** - WordPress admin interface functionality
6. **typewriter.css** - Typewriter animation styles with cursor blink
7. **handwriting.css** - Handwriting styles with font variations
8. **animation-builder.css** - Animation builder UI styles
9. **frontend.css** - General frontend styles
10. **admin.css** - WordPress admin styles

The plugin shortcodes are: `[typewriter]`, `[handwriting]`, and `[css-animation-builder]`. Each shortcode generates unique IDs and data attributes for JavaScript initialization."

## 🎨 **Animation Enhancement Prompt**

**Prompt:** "I want to enhance my WordPress CSS Animation Builder plugin with advanced typewriter and handwriting effects. Currently I have basic character-by-character typing. I need:

**Typewriter Enhancements:**
- Realistic typing speed variations (fast/slow/pauses)
- Backspace/delete/correction animations
- Multiple typing cursors (|, _, █, ▌)
- Sound effects integration (optional)
- Code syntax highlighting while typing
- Multi-line typing with proper line breaks

**Handwriting Enhancements:**
- SVG path-based writing animation
- Different pen types (fountain pen, ballpoint, marker, pencil)
- Ink flow effects and paper texture
- Pressure-sensitive line thickness
- Realistic writing speed and pauses
- Cursive connection between letters
- Signature-style animations

Create modern, performant JavaScript classes that work with WordPress shortcodes."

## 🔨 **WordPress Integration Prompt**

**Prompt:** "I need to fix WordPress integration issues in my CSS Animation Builder plugin. Current problems:

1. **Shortcode conflicts** - Multiple shortcodes on same page interfere
2. **Asset loading** - CSS/JS files not loading properly in WordPress
3. **Admin interface** - Need proper WordPress admin page with live preview
4. **Security** - Need proper nonce verification and sanitization
5. **Performance** - Assets loading on every page instead of only when needed
6. **Mobile compatibility** - Animations not working on mobile devices

The plugin structure is:
```
css-animation-builder/
├── css-animation-builder.php (main file)
├── assets/
│   ├── js/ (JavaScript files)
│   └── css/ (CSS files)
└── languages/
```

Fix these issues with proper WordPress best practices, conditional loading, and mobile optimization."

## 🚀 **Production Ready Prompt**

**Prompt:** "I want to make my CSS Animation Builder WordPress plugin production-ready for WordPress.org submission. Current status: basic functionality works but needs professional polish.

**Requirements:**
1. **Code Standards** - WordPress coding standards compliance
2. **Security** - Input sanitization, nonce verification, capability checks
3. **Performance** - Minified assets, conditional loading, caching
4. **Accessibility** - WCAG compliance, keyboard navigation, screen readers
5. **Internationalization** - Translation-ready strings
6. **Documentation** - Inline documentation, README.txt for WordPress.org
7. **Testing** - Unit tests, compatibility testing
8. **Settings Page** - Professional admin interface with options
9. **Uninstall** - Clean uninstall process
10. **Version Control** - Proper version bumping and changelog

Create a professional WordPress plugin that follows all WordPress.org guidelines and best practices."

## 🎯 **Specific Fix Prompts**

### **Asset Loading Fix**
**Prompt:** "My WordPress plugin CSS Animation Builder has asset loading issues. The shortcodes generate HTML but JavaScript files aren't loading properly. I need conditional asset loading that only loads scripts when shortcodes are actually used on a page. Show me how to implement proper WordPress asset enqueueing with dependency management."

### **Shortcode Conflict Fix**
**Prompt:** "Multiple instances of my animation shortcodes on the same WordPress page are conflicting. Each shortcode generates a unique ID but JavaScript initialization is interfering. I need isolated shortcode instances that don't conflict with each other. Show me how to create truly independent shortcode instances."

### **Admin Interface Fix**
**Prompt:** "I need a professional WordPress admin interface for my CSS Animation Builder plugin. Currently I have a basic admin page but need:
- Live animation preview
- Settings for default options
- Import/export functionality
- Animation library management
- User capability integration
- Help documentation
Create a modern WordPress admin interface following WP admin design patterns."

### **Mobile Compatibility Fix**
**Prompt:** "My CSS Animation Builder WordPress plugin animations don't work properly on mobile devices. Touch events aren't handled, animations are too fast/slow, and some effects are broken on mobile browsers. Fix mobile compatibility with proper touch handling and responsive design."

### **Security Audit Prompt**
**Prompt:** "Audit my CSS Animation Builder WordPress plugin for security vulnerabilities. Check for:
- XSS vulnerabilities in generated HTML
- SQL injection in database queries
- CSRF protection with nonces
- Input sanitization and validation
- Capability checks for admin functions
- File inclusion vulnerabilities
Provide fixes for any security issues found."

## 📋 **Quick Reference Commands**

### **Plugin Structure Check:**
```bash
# Check if all required files exist
ls -la /Users/davidengland/Local\ Sites/reia-new/app/public/wp-content/plugins/css-animation-builder/assets/
```

### **WordPress Error Logs:**
```bash
# Check WordPress error logs
tail -f /Users/davidengland/Local\ Sites/reia-new/app/public/wp-content/debug.log
```

### **Asset Verification:**
```bash
# Verify assets are accessible
curl -I http://reia-new.local/wp-content/plugins/css-animation-builder/assets/js/typewriter.js
```

## 🎨 **Development Priority Order**

1. **Fix missing asset files** (typewriter.js, handwriting.js, CSS files)
2. **Resolve shortcode conflicts** (unique instances)
3. **Improve asset loading** (conditional enqueueing)
4. **Enhance admin interface** (live preview, settings)
5. **Add mobile compatibility** (touch events, responsive)
6. **Security audit** (sanitization, nonces)
7. **Performance optimization** (minification, caching)
8. **WordPress.org preparation** (documentation, standards)

## 🔗 **Related File Locations**

- **Main Plugin:** `/Users/davidengland/Local Sites/reia-new/app/public/wp-content/plugins/css-animation-builder/`
- **Development Version:** `/Users/davidengland/Local Sites/_organized_projects/css-animation-builder-standalone/`
- **WordPress Site:** `http://reia-new.local`
- **Docker Container:** `reia-new` in Local by Flywheel

Use these prompts when you return to fix the WordPress plugin issues! Each prompt is designed to tackle specific problems you're encountering.