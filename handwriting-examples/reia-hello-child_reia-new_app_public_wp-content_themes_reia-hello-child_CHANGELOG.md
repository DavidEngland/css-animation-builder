# Changelog

All notable changes to this theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

- Performance optimizations and additional slogan style variants
- Enhanced accessibility features and WCAG AA compliance improvements

## [2.3.1] - 2025-06-18

### Added

- **Comprehensive Slogan System**: 15+ professional slogan styles with CSS animations and effects
  - Gradient animated text with smooth color transitions
  - Handwritten script style for personal touch
  - Premium combination style with multiple effects
  - 3D text effect with shadow depth
  - Highlighted box with shimmer animation
  - Modern card style with elevated presentation
  - Typewriter animation effect
  - Emphasis style with keyword highlighting
- **Professional Blockquote Citations**: Multiple citation formats with Mikko P. Jetsu attribution
  - Executive statement cards
  - Professional letterhead styling
  - Pull quote formats for articles
  - Speech bubble presentations
  - Award/achievement styling
  - Compact citation formats
  - Testimonial-style with photo space
  - Video/media caption styling
- **Implementation Documentation**:
  - `gutenberg-slogan-blocks.html` - Copy-paste ready HTML blocks for Gutenberg
  - `CUSTOM-HTML-BLOCKS.html` - Additional HTML block variations
  - `SLOGAN-IMPLEMENTATION.md` - Complete implementation guide
  - `SLOGAN-PLACEMENT-STRATEGY.md` - Strategic placement recommendations
- **CSS Enhancements**:
  - Custom CSS classes for all slogan styles
  - Responsive typography with clamp() functions
  - Accessibility-compliant color contrasts
  - Smooth animations and transitions
  - Mobile-optimized layouts
- **Brand Integration**:
  - Proper "Smart Move<sup>SM</sup>" service mark implementation
  - Non-breaking spaces to prevent text orphans
  - Professional email contact integration
  - CEO attribution with full credentials

### Changed

- Updated README.md with comprehensive feature documentation
- Enhanced theme description to reflect real estate focus
- Improved documentation structure with better navigation
- Updated live demo link to test.realestate-huntsville.com

### Fixed

- Consistent typography scaling across all slogan styles
- Proper semantic markup for accessibility compliance
- Cross-browser compatibility for CSS animations
- Mobile responsiveness for all slogan formats

## [2.1.0] - 2025-06-16

### Added

- Accessibility markup (<title>, <desc>, ARIA, metadata) to SVG logo for SEO and screen readers.
- theme.json: Roboto for body, improved color palette (#002d5f, #fbde4f, #ac3033, #111, #fff), heading contrast, and block overrides for headings on dark backgrounds.
- Block-level heading color/contrast improvements for accessibility.

### Changed

- Improved documentation and readme.txt to reflect new features and accessibility.

## [2.0.0] - 2025-06-13

### Added

- Major refactor: modern SASS, theme.json, utility classes, and block support.
- See previous entries for details.

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

---

For older changes or migration notes, see project README.md or commit history.
