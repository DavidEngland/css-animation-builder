# REIA Hello Child Theme

A modern, maintainable, and extensible WordPress child theme for [Hello Elementor](https://wordpress.org/themes/hello-elementor/), designed for rapid development with Elementor and custom plugins.

**Repository:** [DavidEngland/reia-hello-child](https://github.com/DavidEngland/reia-hello-child)  
**Author:** David England  
**Version:** 2.3.0

## Features

- **Modern CSS & SASS**: Uses CSS variables, `@property`, `@layer`, container queries, and a robust SASS architecture.
- **WordPress Block Theme Support**: Full `theme.json` specification with modern font families and typography scale.
- **Conditional Build System**: Three optimized builds (dev/prod/minimal) to reduce CSS bloat by up to 73%.
- **Elementor Section Styling**: Comprehensive styling for header, footer, and home page sections with primary blue background and white text.
- **Color System**: Enhanced color palette with parchment gold accents (#F4E4BC) and proper contrast ratios.
- **Custom Card & Grid System**: Flexible, responsive layouts for posts, Connections Directory, and custom widgets.
- **Performance Optimized**: From 52KB (full) to 12KB (minimal) builds for faster loading.
- **Content Area Specificity**: Smart CSS targeting ensuring white backgrounds only on post/page content, not site sections.
- **Typography & Accessibility**: Proper styling for `<sup>SM</sup>`, special characters, and accessible color contrasts.
- **Developer Friendly**: Well-documented code, modular SASS partials, and clear variable/mixin usage.
- **WordPress & Elementor Ready**: Seamless integration with Elementor and WordPress block editor.

## Quick Start

### Build System
Choose your build based on needs:

```bash
# Production build (no animations) - ~28KB
./build-theme.sh prod

# Minimal build (core only) - ~14KB  
./build-theme.sh minimal

# Development build (all features) - ~52KB
./build-theme.sh dev
```

### Installation

1. Download or clone this repository.
2. Upload the theme folder to `/wp-content/themes/` in your WordPress installation.
3. In the WordPress admin, go to **Appearance > Themes** and activate **REIA Hello Child**.
4. Ensure the parent [Hello Elementor](https://wordpress.org/themes/hello-elementor/) theme is installed and active.
5. (Optional) Install and activate recommended plugins (e.g., Elementor, Connections Business Directory).

## Design System

### Color Palette
- **Primary Blue**: `#002D5F` - Used for header, footer, and main sections
- **Accent Blue**: `#0073e6` - Links and interactive elements
- **Parchment Gold**: `#F4E4BC` - Accent color for links on dark backgrounds
- **Text Colors**: `#212529` (dark), `#ffffff` (light), `#6c757d` (muted)

### Layout Strategy
- **Content Areas**: White backgrounds with black text for optimal readability
- **Site Sections**: Primary blue backgrounds with white text for headers, footers, home page
- **Smart Targeting**: CSS selectors specifically target content vs. site sections to prevent conflicts

## Usage

- **Build CSS**: Use `./build-theme.sh [type]` for optimized builds
- **Development**: Use `npm run watch` for live SASS compilation
- **Elementor Sections**: Header, footer, and home page sections automatically styled with primary blue theme
- **Content Editing**: Post and page content maintains clean white backgrounds for readability
- Customize styles in `style.scss` and SASS partials under `/sass/`.
- Add or modify PHP shortcodes in `functions.php` or custom plugins.
- Use the card and grid classes in your Elementor or block layouts for consistent design.
- For Connections Directory customizations, see `/connections-templates/cmap/`.

## Development

- **SASS Structure**: All SASS partials are in `/sass/` and compiled to `style.css`.
    - `_variables.scss`, `_mixins.scss`, `_post-card.scss`, `_post-grid.scss`, `_single-post-card.scss`, `_zillow-review.scss`, `home.scss`
- **Build Process**: Use your preferred SASS compiler (e.g., `npm scripts`, `gulp`, or VS Code SASS extension) to compile `style.scss` to `style.css`.
- **Modern CSS**: Leverages CSS custom properties, `@property`, `@layer`, and container queries for maintainability and future-proofing.
- **Documentation**: All custom code and SASS partials are documented with usage examples and best practices.

## Customization

- Edit SASS variables in `_variables.scss` for global theming.
- Extend or override card/grid layouts in the relevant SASS partials.
- Add new shortcodes or extend existing ones in your child theme or custom plugins.
- See `readme.txt` for WordPress-specific details and changelog.

## Resources

- [Hello Elementor Theme Docs](https://developers.elementor.com/docs/hello-elementor-theme/)
- [Elementor Page Builder](https://elementor.com/)
- [Connections Business Directory](https://connections-pro.com/)
- [GitHub Repository](https://github.com/DavidEngland/reia-hello-child)

## License

This theme is licensed under the [GNU GPL v3 or later](https://www.gnu.org/licenses/gpl-3.0.html). See `readme.txt` for third-party attributions.

## Contributing

Issues and pull requests are welcome on [GitHub](https://github.com/DavidEngland/reia-hello-child).
