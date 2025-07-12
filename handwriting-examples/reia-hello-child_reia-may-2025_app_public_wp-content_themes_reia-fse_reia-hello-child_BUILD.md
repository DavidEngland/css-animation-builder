# Build System Documentation v2.4.1

## Overview

This theme includes a conditional build system that allows you to include or exclude features to optimize file size and performance. The system uses SCSS feature flags to conditionally compile CSS modules.

**New in v2.4.1:**
- ✨ **Basic Animations**: Performance-optimized animation system fully integrated
- 🎨 **WordPress Preset Classes**: Full theme.json color/typography support
- 📐 **CSS Columns**: Modern masonry and column layouts
- 🚀 **Enhanced Build Process**: Better feedback and automatic version management
- 🔧 **Improved Developer Experience**: Clearer output and error handling

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

| Feature | Description | Size Impact | Dev | Prod | Min |
|---------|-------------|-------------|-----|------|-----|
| `$include-basic-animations` | Performance-optimized animations | ~25KB | ✅ | ✅ | ❌ |
| `$include-wordpress-presets` | Theme.json color/typography classes | ~8KB | ✅ | ✅ | ✅ |
| `$include-columns` | CSS masonry and column layouts | ~6KB | ✅ | ✅ | ❌ |
| `$include-animations` | Full animate.css library | ~60KB | ✅ | ❌ | ❌ |
| `$include-slogans` | Custom slogan styling | ~5KB | ✅ | ✅ | ❌ |
| `$include-advanced-buttons` | Enhanced button styles | ~8KB | ✅ | ✅ | ✅ |
| `$include-zillow-review` | Zillow review widget | ~3KB | ✅ | ✅ | ❌ |
| `$include-post-grid` | Post grid layout system | ~4KB | ✅ | ✅ | ✅ |
| `$include-details-styling` | Enhanced details/summary | ~2KB | ✅ | ✅ | ❌ |
| `$include-hfe-menus` | Elementor menu improvements | ~3KB | ✅ | ✅ | ❌ |

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
