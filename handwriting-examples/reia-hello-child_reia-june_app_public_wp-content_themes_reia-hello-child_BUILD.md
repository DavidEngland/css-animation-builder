# Build System Documentation

## Overview

This theme includes a conditional build system that allows you to include or exclude features to optimize file size and performance. The system uses SCSS feature flags to conditionally compile CSS modules.

## Quick Start

### Option 1: Using the Build Script (Recommended)

```bash
# Development build (all features)
./build-theme.sh dev

# Production build (optimized, no animations)
./build-theme.sh prod

# Minimal build (core features only)
./build-theme.sh minimal
```

### Option 2: Using npm Scripts

```bash
# Install dependencies
npm install

# Development build with file watching
npm run watch

# Production builds
npm run build:dev    # All features
npm run build:prod   # Optimized for production
npm run build:minimal # Minimal features
```

## Available Features

| Feature | Description | Size Impact | Default |
|---------|-------------|-------------|---------|
| `$include-animations` | Full animate.css library | ~60KB | `false` (prod) |
| `$include-slogans` | Custom slogan styling | ~5KB | `true` |
| `$include-advanced-buttons` | Enhanced button styles | ~8KB | `true` |
| `$include-zillow-review` | Zillow review widget | ~3KB | `true` |
| `$include-post-grid` | Post grid layout system | ~4KB | `true` |
| `$include-details-styling` | Enhanced details/summary | ~2KB | `true` |
| `$include-hfe-menus` | Elementor menu improvements | ~3KB | `true` |

## Build Configurations

### Development Build
- **All features enabled**
- **File size:** ~95KB (uncompressed)
- **Use case:** Local development and testing

### Production Build
- **Animations disabled** (major size reduction)
- **All other features enabled**
- **File size:** ~35KB (compressed)
- **Use case:** Live websites prioritizing performance

### Minimal Build
- **Only core features**
- **File size:** ~20KB (compressed)
- **Use case:** Landing pages, minimal sites

## Manual Configuration

Edit `sass/_config.scss` to customize which features are included:

```scss
// Set to false to exclude features
$include-animations: false;      // Disable animations
$include-slogans: true;          // Keep slogan styling
$include-advanced-buttons: true; // Keep button styles
// ... etc
```

Then compile with:
```bash
sass style.scss style.css --style=compressed
```

## Performance Recommendations

- **Production sites:** Use production build (`./build-theme.sh prod`)
- **Landing pages:** Use minimal build (`./build-theme.sh minimal`)
- **Development:** Use development build with watch mode (`npm run watch`)

## File Structure

```
sass/
├── _config.scss          # Feature flags configuration
├── _index.scss           # Conditional module loader
├── _variables.scss       # Core variables
├── _animations.scss      # Animation utilities (conditional)
├── _slogans.scss         # Slogan styling (conditional)
├── _buttons.scss         # Advanced buttons (conditional)
└── ...                   # Other modules
```

## Troubleshooting

### Sass Command Not Found
```bash
npm install -g sass
# or visit: https://sass-lang.com/install
```

### Permission Denied (Build Script)
```bash
chmod +x build-theme.sh
```

### Module Not Found Errors
Ensure all SCSS files exist in the `sass/` directory and are properly named.
