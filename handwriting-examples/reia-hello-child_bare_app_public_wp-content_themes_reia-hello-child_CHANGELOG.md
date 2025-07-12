# Changelog

All notable changes to this theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

- Ongoing refinements and improvements as new requirements or plugin/theme updates arise.

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
