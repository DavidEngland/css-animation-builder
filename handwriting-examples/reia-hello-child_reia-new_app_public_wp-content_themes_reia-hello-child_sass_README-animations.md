# REIA Animation System Documentation

## Overview

The REIA Animation System is a comprehensive, modular CSS animation library designed specifically for the REIA real estate theme. It provides a robust set of animations optimized for performance, accessibility, and modern browsers.

## Key Features

- **Modular Architecture**: Enable/disable animation modules for build optimization
- **Accessibility First**: Respects `prefers-reduced-motion` settings
- **Performance Optimized**: Hardware acceleration and efficient transforms
- **Real Estate Focused**: Animations designed for property showcases and listings
- **Developer Friendly**: Comprehensive SASS mixins and utilities
- **Mobile Optimized**: Responsive controls for different screen sizes

## Quick Start

### Basic Usage

```html
<!-- Simple fade in -->
<div class="reia-anim-fade-in">Property content</div>

<!-- Bounce in with delay -->
<div class="reia-anim-bounce-in reia-anim-delay-medium">Featured property</div>

<!-- Slide in from left -->
<div class="reia-anim-slide-in-left">Property card</div>
```

### SASS Mixins

```scss
// Fade animation
.my-element {
    @include reia-fade('in', 0.5s);
}

// Slide animation
.property-card {
    @include reia-slide('up', 0.8s);
}

// Attention animation
.cta-button {
    @include reia-attention('pulse', 2s);
}

// Staggered animations
.property-grid .property-card {
    @include reia-stagger(6, 0.1s);
    @include reia-fade('in');
}
```

## Animation Modules

### 1. Entrance Animations

Perfect for property cards, listings, and content sections.

| Class | Description | Use Case |
|-------|-------------|----------|
| `reia-anim-fade-in` | Elegant fade with upward movement | Text content, descriptions |
| `reia-anim-fade-in-up` | Fade in from below | Footer content, forms |
| `reia-anim-fade-in-down` | Fade in from above | Hero sections, headers |
| `reia-anim-bounce-in` | Bouncy entrance effect | Featured properties, offers |
| `reia-anim-slide-in-left` | Slide from left | Property cards in grid |
| `reia-anim-slide-in-right` | Slide from right | Alternating content |
| `reia-anim-slide-in-up` | Slide from bottom | Bottom sections |
| `reia-anim-slide-in-down` | Slide from top | Top sections |
| `reia-anim-zoom-in` | Dramatic zoom entrance | Featured content |
| `reia-anim-scale-in` | Smooth scaling entrance | Icons, badges |
| `reia-anim-rotate-in` | Rotating entrance | Special elements |
| `reia-anim-flip-in-x` | 3D flip (vertical) | Interactive cards |
| `reia-anim-flip-in-y` | 3D flip (horizontal) | Interactive cards |

### 2. Attention Animations

For call-to-action elements and notifications.

| Class | Description | Use Case |
|-------|-------------|----------|
| `reia-anim-pulse` | Subtle breathing effect | CTA buttons |
| `reia-anim-bounce` | Bouncing animation | Important elements |
| `reia-anim-shake` | Shake animation | Error states, alerts |
| `reia-anim-wobble` | Wobbling effect | Featured properties |
| `reia-anim-flash` | Flashing animation | Urgent notifications |

### 3. Exit Animations

For elements leaving the viewport or modal closures.

| Class | Description | Use Case |
|-------|-------------|----------|
| `reia-anim-fade-out` | Smooth disappearance | General exit |
| `reia-anim-scale-out` | Shrinking exit | Modal closures |
| `reia-anim-slide-out-left` | Slide out to left | Sidebar collapse |
| `reia-anim-slide-out-right` | Slide out to right | Panel dismissal |

### 4. Hover Animations

For interactive elements providing immediate feedback.

| Class | Description | Use Case |
|-------|-------------|----------|
| `reia-anim-hover-lift` | Subtle elevation | Property cards |
| `reia-anim-hover-scale` | Grow on hover | Buttons, images |
| `reia-anim-hover-glow` | Soft glow effect | Primary buttons |
| `reia-anim-hover-rotate` | Subtle rotation | Icons |
| `reia-anim-hover-slide` | Slide overlay | Image galleries |

### 5. Scroll Animations

For viewport-based animations (requires JavaScript).

| Class | Description | Use Case |
|-------|-------------|----------|
| `reia-anim-scroll-reveal` | Basic scroll reveal | General content |
| `reia-anim-scroll-reveal-left` | Reveal from left | Side content |
| `reia-anim-scroll-reveal-right` | Reveal from right | Side content |
| `reia-anim-scroll-reveal-scale` | Scale reveal | Featured elements |

## Utility Classes

### Duration Modifiers

```html
<div class="reia-anim-fade-in reia-anim-duration-fast">Quick fade</div>
<div class="reia-anim-bounce-in reia-anim-duration-slow">Slow bounce</div>
```

### Delay Modifiers

```html
<div class="reia-anim-slide-in-left reia-anim-delay-short">Short delay</div>
<div class="reia-anim-fade-in reia-anim-delay-long">Long delay</div>
```

### Animation Control

```html
<div class="reia-anim-pulse reia-anim-infinite">Infinite pulse</div>
<div class="reia-anim-bounce-in reia-anim-paused">Paused animation</div>
```

## Configuration

### Feature Flags

Control which animation modules are included in your build:

```scss
// Disable exit animations for smaller build
$reia-enable-exit-animations: false;

// Disable hover animations for touch devices
$reia-enable-hover-animations: false;

@import 'basic_animations';
```

### Custom Variables

```scss
// Custom timing
$reia-duration-normal: 0.8s;
$reia-delay-short: 0.2s;

// Custom easing
$reia-ease-smooth: cubic-bezier(0.25, 0.46, 0.45, 0.94);

// Custom distances
$reia-distance-medium: 30px;
```

## Best Practices

### 1. Performance

- Use hardware-accelerated properties (`transform`, `opacity`)
- Avoid animating layout properties (`width`, `height`, `margin`)
- Use `will-change` sparingly and remove after animation

### 2. Accessibility

- Always test with `prefers-reduced-motion: reduce`
- Provide alternative visual feedback for reduced motion users
- Keep animation durations reasonable (< 2s for most cases)

### 3. User Experience

- Use entrance animations for content that appears
- Use attention animations sparingly for important elements
- Provide hover feedback for interactive elements
- Consider staggered animations for lists and grids

### 4. Real Estate Context

- Use subtle animations for property listings
- Reserve dramatic animations for featured properties
- Ensure animations don't interfere with property images
- Test animations with real estate content

## JavaScript Integration

For scroll-based animations:

```javascript
// Simple intersection observer setup
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('reia-anim-revealed');
        }
    });
}, observerOptions);

// Observe all scroll reveal elements
document.querySelectorAll('.reia-anim-scroll-reveal').forEach(el => {
    observer.observe(el);
});
```

## Browser Support

- **Modern browsers**: Full support with hardware acceleration
- **IE11**: Graceful degradation with basic animations
- **Mobile**: Optimized for touch devices with reduced animations

## Troubleshooting

### Common Issues

1. **Animation not playing**: Check that the element is visible and not hidden
2. **Jerky animations**: Ensure hardware acceleration is enabled
3. **Accessibility issues**: Test with reduced motion preferences
4. **Performance issues**: Reduce animation complexity on mobile

### Debug Mode

```scss
// Enable debug mode for development
$reia-debug-mode: true;

// This will add borders to animated elements
@if $reia-debug-mode {
    .reia-anim-* {
        border: 2px solid red !important;
    }
}
```

## Contributing

When adding new animations:

1. Follow the naming convention: `reia-anim-[type]-[direction]`
2. Include appropriate documentation
3. Test with reduced motion preferences
4. Ensure mobile compatibility
5. Add to the appropriate module section

## Version History

- **v3.0.0**: Major refactor with modular architecture
- **v2.0.0**: Added accessibility features and hover animations
- **v1.0.0**: Initial release with basic animations
