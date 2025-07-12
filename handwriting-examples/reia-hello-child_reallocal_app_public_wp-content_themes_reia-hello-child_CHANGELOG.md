# Changelog

All notable changes to the REIA Hello Child Theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.3.0] - 2025-06-19

### Added
- **theme.json Support**: Added WordPress Block Theme specification file
  - Modern font families (Inter, Merriweather, Poppins, Roboto)
  - Enhanced typography scale with improved font sizes
  - Block-level styling for post content, headings, and paragraphs
  - Color palette definitions for WordPress editor integration
- **Elementor Section Styling**: Comprehensive styling for header, footer, and home page sections
  - Primary blue background (#002D5F) with white text for all Elementor sections
  - Parchment gold accent color (#F4E4BC) for links and highlights
  - Proper contrast and accessibility compliance
- **Color System Enhancement**: New color variables and CSS custom properties
  - `$parchment: #F4E4BC` for yellowish gold accents
  - `$color-text-light: #ffffff` for text on dark backgrounds
  - Enhanced color palette for better design consistency
- **Footer-specific Exclusions**: Targeted CSS to prevent white backgrounds in footer areas
  - `.footer-width-fixer` selectors to override content styling in footer context
  - Proper inheritance chain for Elementor widget containers
- **Content Area Specificity**: Enhanced selectors for post and page content styling
  - More specific targeting to avoid affecting header/footer areas
  - Improved scoping for WordPress blocks and Elementor widgets

### Changed
- **Content Background Strategy**: Refined white background application
  - White backgrounds now only apply to actual post/page content areas
  - Excludes header, footer, and home page sections from white background treatment
  - Better inheritance handling for Elementor widget containers
- **CSS Selector Specificity**: Improved targeting of content elements
  - More precise selectors for `.elementor-widget-text-editor` and related elements
  - Context-aware styling based on page type and section location
- **Build System**: Updated SCSS compilation to handle new color variables
  - Fixed `@use` statement placement issues in SCSS files
  - Resolved deprecation warnings for mixed declarations

### Fixed
- **SCSS Compilation Errors**: Resolved `@use` rules placement issues
  - Fixed `@use 'variables' as *;` statement positioning in `_hfe.scss`
  - Eliminated build errors while preserving deprecation warnings for non-critical issues
- **Background Inheritance**: Corrected Elementor widget container background handling
  - Fixed unwanted white backgrounds in footer sections
  - Ensured proper inheritance of primary blue backgrounds in Elementor sections
- **Color Conflicts**: Resolved styling conflicts between content areas and site sections
  - Prevented content styling from overriding header/footer design
  - Maintained design integrity across different page sections

## [2.2.17] - 2025-06-18

### Added
- Superscript and special character styling improvements
- Custom HTML block container improvements for company slogans
- Typography enhancements for `<sup>SM</sup>` display
- Support for HTML entities (&trade;, &copy;, &#174;, &#8482;)
- Modern conditional building system with feature flags

### Changed
- Updated theme header information with new repository URLs
- Improved documentation structure and README
- Enhanced build process for production optimization

### Fixed
- Superscript elements now display correctly without affecting line height
- Special HTML characters render properly across browsers
- SCSS compilation issues with modern module system

## [1.0.1] - 2025-06-13

### Changed

- Refactored all SCSS partials to use `@use` for dependency management (`variables` and `mixins`), replacing legacy `@import` usage.
- Added `_index.scss` with `@forward` for all partials to enable a single entry point and modern SCSS structure.
- Updated documentation in partials to reflect new SCSS module system.

### Fixed

- Ensured all partials are modular, maintainable, and compatible with latest SASS best practices.

## [1.0.0] - 2025-06-13

### Added

- Initial modernized, refactored, and documented version of the Hello Elementor Child (REIA Ollie Child) theme.
- Migrated and refactored all custom CSS and SASS for cards, grids, home page layouts, and navigation.
- Added modern CSS features: variables, clamp, @property, @layer, container queries.
- Created and improved plugin documentation (README.md, readme.txt).
- Refactored and improved HTML content for use in WordPress blocks.
- Added a modern card/grid system and robust utility classes.
- Provided minimal, accessible overrides for Elementor HFE/UAE menus.
- Added shell scripts for SASS build process and .gitignore for WP/SASS/Node/VS Code/OS artifacts.

### Changed

- Improved SASS/SCSS partials for cards, grids, single post cards, and Zillow review widget.
- Updated and documented all SASS partials and the main style.scss entry point.
- Enhanced accessibility and maintainability throughout theme and plugins.

### Fixed

- Fixed submenu and sub-arrow visibility in footer navigation for accessibility and clarity.
- Fixed various minor CSS and PHP issues for consistency and best practices.

## Performance Metrics

| Version | CSS Size (Dev) | CSS Size (Prod) | CSS Size (Min) | Reduction | Key Features |
|---------|----------------|-----------------|----------------|-----------|--------------|
| 2.2.17  | 44KB          | 24KB           | 12KB          | 73%       | Conditional builds |
| 1.0.1   | ~85KB         | ~85KB          | ~85KB         | 0%        | All features included |

## Migration Guide

### To 2.2.17 (Latest)

1. **New Build System**: Use `./build-theme.sh prod` for production builds
2. **Repository Update**: Update any references to `DavidEngland/reia-hello-child`
3. **Dependencies**: Run `npm install` if using Node.js workflow
4. **Performance**: Choose appropriate build type for your use case

---

For detailed build instructions, see [BUILD.md](BUILD.md).  
For older changes or migration notes, see commit history.
