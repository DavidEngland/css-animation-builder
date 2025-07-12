# Keyframes Refactoring - File-based Architecture

## Overview
The CSS Animation Builder has been successfully refactored to use a file-based keyframes architecture instead of large associative arrays. This improves maintainability, scalability, and organization.

## Changes Made

### 1. Directory Structure
```
src/
├── Builder.php (updated)
├── Keyframes/ (new)
│   ├── fadeIn.css
│   ├── fadeOut.css
│   ├── slideInLeft.css
│   ├── slideInRight.css
│   ├── slideInUp.css
│   ├── slideInDown.css
│   ├── zoomIn.css
│   ├── zoomOut.css
│   ├── bounceIn.css
│   ├── rotateIn.css
│   ├── pulse.css
│   ├── shake.css
│   ├── wobble.css
│   ├── swing.css
│   ├── typewriter.css
│   ├── handwriting.css
│   ├── drawLine.css
│   ├── writeText.css
│   └── signatureDraw.css
└── keyframes.js (auto-generated)
```

### 2. PHP Implementation
- **Old Method**: Large associative array with hardcoded keyframes
- **New Method**: File-based loading using `file_get_contents()`

```php
// New getKeyframes method
private function getKeyframes(string $animation): string
{
    $keyframeFile = __DIR__ . "/Keyframes/{$animation}.css";
    
    if (file_exists($keyframeFile)) {
        $keyframeContent = file_get_contents($keyframeFile);
        $keyframeContent = str_replace("\n", "\n    ", trim($keyframeContent));
        return "@keyframes {$animation} {\n    {$keyframeContent}\n}";
    }
    
    // Fallback for unknown animations
    return "@keyframes {$animation} {\n    0% { opacity: 0; }\n    100% { opacity: 1; }\n}";
}
```

### 3. JavaScript Integration
- **Auto-generated**: `src/keyframes.js` file created from CSS files
- **Build Process**: `build-keyframes.php` script generates JavaScript from CSS
- **Updated Method**: JavaScript `getKeyframes()` now uses generated keyframes

### 4. Individual Keyframe Files
Each animation has its own `.css` file containing only the keyframe definitions:

**Example - fadeIn.css**:
```css
0% { opacity: 0; }
100% { opacity: 1; }
```

**Example - bounceIn.css**:
```css
0% { transform: scale(0.3); opacity: 0; }
50% { transform: scale(1.05); opacity: 1; }
70% { transform: scale(0.9); opacity: 1; }
100% { transform: scale(1); opacity: 1; }
```

## Benefits

### 1. **Maintainability**
- Each animation is in its own file
- Easy to modify individual animations
- Clear separation of concerns

### 2. **Scalability**
- Easy to add new animations
- No need to modify core PHP code for new keyframes
- Modular architecture

### 3. **Organization**
- Clean file structure
- Logical grouping of related files
- Better version control tracking

### 4. **Development Workflow**
- CSS files can be edited independently
- Build process synchronizes JavaScript
- Easy to test individual animations

## Usage

### Adding New Animations
1. Create new `.css` file in `src/Keyframes/`
2. Add keyframe definitions (without `@keyframes` wrapper)
3. Run `php build-keyframes.php` to update JavaScript
4. Animation is automatically available

### Build Process
```bash
# Generate JavaScript keyframes from CSS files
php build-keyframes.php
```

### Testing
```bash
# Test the file-based system
php test-keyframes.php

# Or start development server
php -S localhost:8000 test-keyframes.php
```

## File Sizes

### Before Refactoring
- `Builder.php`: ~1,288 lines
- Large keyframes array: ~50 lines of hardcoded keyframes

### After Refactoring
- `Builder.php`: ~1,250 lines (cleaner `getKeyframes` method)
- 19 individual keyframe files: ~2-10 lines each
- Auto-generated `keyframes.js`: ~25 lines
- Better organization and maintainability

## Compatibility
- ✅ All existing functionality preserved
- ✅ PHP and JavaScript implementations synchronized
- ✅ Backward compatible with existing API
- ✅ Automatic fallback for unknown animations

## Next Steps
1. Consider adding animation categories/subdirectories
2. Implement keyframe validation
3. Add CSS minification for production builds
4. Create animation preview thumbnails from keyframes

This refactoring successfully transforms the CSS Animation Builder from a monolithic keyframes approach to a modular, file-based architecture that's easier to maintain and extend.
