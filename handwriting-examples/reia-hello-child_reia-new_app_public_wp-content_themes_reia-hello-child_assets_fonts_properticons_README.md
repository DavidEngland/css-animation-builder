# Properticons

A modern, real estate–focused icon font for WordPress, Elementor, and block themes.

## Features
- 20+ real estate icons (beds, baths, home, building, phone, map, etc.)
- Easy to use in any theme, Elementor widget, or block editor
- Supports legacy browsers (EOT, TTF, SVG) and modern web (WOFF)
- Utility classes for size and color
- GPLv2+ with font exception

## Quick Start
1. **Enqueue the CSS in your theme:**
   - In `functions.php`:
     ```php
     wp_enqueue_style('properticons', get_stylesheet_directory_uri() . '/assets/fonts/properticons/css/properticons.css', [], null);
     ```
   - Or import in your main CSS:
     ```css
     @import url('assets/fonts/properticons/css/properticons.css');
     ```
2. **Add an icon anywhere:**
   ```html
   <span class="properticons properticons-home" aria-hidden="true"></span>
   <span class="properticons properticons-beds properticons--lg" style="color:#0073e6" aria-label="3 beds"></span>
   ```
3. **Elementor:**
   - Add a class (e.g. `properticons properticons-home`) to any widget’s Advanced > CSS Classes field.
   - Or use in an HTML widget.

## Utility Classes
- `.properticons--sm` — 24px
- `.properticons--md` — 32px
- `.properticons--lg` — 48px
- `.properticons--color` — Inherit parent color (or use inline style)

## Accessibility
- Use `aria-hidden="true"` for decorative icons.
- Use `aria-label` for icons with meaning (e.g. `<span class="properticons properticons-beds" aria-label="3 beds"></span>`)

## License
GPLv2+ with font exception. See original: http://www.agentevolution.com

---
