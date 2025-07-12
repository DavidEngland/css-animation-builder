# Hello Elementor Child Theme (REIA Ollie Child)

A modern, maintainable, and extensible WordPress child theme for [Hello Elementor](https://wordpress.org/themes/hello-elementor/), designed for rapid development with Elementor and custom plugins.

## Features

- **Modern CSS & SASS**: Uses CSS variables, `@property`, `@layer`, container queries, and a robust SASS architecture.
- **Custom Card & Grid System**: Flexible, responsive layouts for posts, Connections Directory, and custom widgets.
- **Optimized for Performance**: Minimalist, fast-loading, and built for extensibility.
- **Developer Friendly**: Well-documented code, modular SASS partials, and clear variable/mixin usage.
- **Extensible Shortcodes**: Improved PHP shortcodes for Connections plugin (cardfooter, cardlink, cardparts).
- **WordPress & Elementor Ready**: Seamless integration with Elementor and WordPress block editor.

## Installation

1. Download or clone this repository.
2. Upload the theme folder to `/wp-content/themes/` in your WordPress installation.
3. In the WordPress admin, go to **Appearance > Themes** and activate **Hello Elementor Child**.
4. Ensure the parent [Hello Elementor](https://wordpress.org/themes/hello-elementor/) theme is installed and active.
5. (Optional) Install and activate recommended plugins (e.g., Elementor, Connections Business Directory).

## Usage

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

## License

This theme is licensed under the [GNU GPL v3 or later](https://www.gnu.org/licenses/gpl-3.0.html). See `readme.txt` for third-party attributions.
