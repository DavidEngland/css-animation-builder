# REIA Theme Animation Enhancement System
## Complete Integration Guide

### **Validation System Audit**

The CSSAnimationBuilder class includes comprehensive validation methods that ensure robust handling of animation parameters, especially for per-animation overrides.

#### **Core Validation Methods**

1. **`validateOverrideValue($key, $value)`**
   - Validates per-animation overrides (duration, delay, easing, direction, iteration, transform_origin)
   - Handles all CSS time formats: numeric (1.5), strings with units ("2s", "500ms")
   - Validates easing functions including cubic-bezier and steps
   - Supports all CSS animation directions and iteration counts

2. **`validateTransformOrigin($origin)`**
   - Supports keyword values: center, top, bottom, left, right, combinations
   - Validates coordinate formats: "50% 25%", "10px 20px"
   - Handles mixed formats: "left top", "center bottom"

3. **`validateDistance($distance)`**
   - Supports all CSS units: px, %, em, rem, vh, vw, vmin, vmax, ch, ex, cm, mm, in, pt, pc
   - Handles decimal values: ".5px", "10.5%", "2.5rem"
   - Auto-converts numeric values to px

4. **`validateAnimationName($name)`**
   - Ensures valid CSS identifiers
   - Prevents reserved CSS keywords
   - Enforces naming conventions

#### **Override Configuration Examples**

```php
// Valid override configurations
$overrides = [
    'duration' => '2s',           // String with unit
    'delay' => 0.5,               // Numeric (auto-converts to seconds)
    'easing' => 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
    'direction' => 'alternate',
    'iteration' => 'infinite',
    'transform_origin' => 'center bottom'
];

// Usage in animations
$builder->addFade('fadeInDown', 'in', '30px', $overrides);
$builder->addSlide('slideLeft', 'left', '100%', [
    'duration' => '1.5s',
    'easing' => 'ease-out'
]);
```

### **Theme Integration Architecture**

The system provides multiple integration layers:

1. **Theme Enhancement Class** (`REIA_Theme_Animation_Enhancement`)
2. **Template Parts** (property cards, hero sections, testimonials)
3. **Helper Functions** (for direct template use)
4. **WordPress Hooks** (automatic animation injection)
5. **CSS Generation** (complete stylesheet output)

### **Real Estate Animation Library**

#### **Property Animations**
- `propertyRevealEnhanced` - Card reveal with stagger
- `propertyImageParallax` - Image zoom on hover
- `propertyPriceHighlight` - Price emphasis
- `propertyStatusPulse` - Status badge animation

#### **Hero Section Animations**
- `heroTitleSweep` - Text reveal animation
- `heroBackgroundShift` - Subtle background movement
- `heroCtaFloat` - Call-to-action hover effect
- `heroStatsCounter` - Number counting animation

#### **Interactive Animations**
- `buttonRipple` - Modern button feedback
- `formFieldFocus` - Input field highlighting
- `modalSlideIn` - Modal appearance
- `tooltipFadeIn` - Tooltip reveal

### **Accessibility Features**

All animations respect user preferences:

```css
@media (prefers-reduced-motion: reduce) {
    .reia-animated * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
```

### **Performance Optimizations**

1. **CSS Custom Properties** - Dynamic animation control
2. **Transform-based Animations** - Hardware acceleration
3. **Intersection Observer** - Trigger animations on view
4. **Staggered Loading** - Prevent animation overload

### **Template Integration Examples**

#### **Property Cards**
```php
// In template files
<?php reia_animate_element('property-card', ['animation' => 'propertyRevealEnhanced']); ?>
<div class="property-card reia-animate" data-animation="propertyRevealEnhanced">
    <!-- Property content -->
</div>
```

#### **Hero Sections**
```php
// Automatic injection via hooks
do_action('reia_before_hero_section');
?>
<section class="hero-section reia-animate" data-animation="heroTitleSweep">
    <!-- Hero content -->
</section>
```

### **CSS Output Management**

The system generates complete CSS including:

1. **CSS Custom Properties** - Theme-wide animation variables
2. **Base Classes** - `.reia-animated`, utility classes
3. **Keyframe Definitions** - All animation @keyframes
4. **Accessibility Rules** - Reduced motion support
5. **Utility Classes** - Duration, delay, easing variations

### **JavaScript Integration**

Automatic animation triggering:

```javascript
// Intersection Observer for scroll-triggered animations
const animatedElements = document.querySelectorAll('.reia-animate');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('reia-in-view');
        }
    });
});

animatedElements.forEach(el => observer.observe(el));
```

### **Best Practices**

1. **Stagger Animations** - Use delays for sequential elements
2. **Context-Aware** - Different animations for different page types
3. **Performance First** - Transform-based animations only
4. **Accessible** - Always include reduced motion support
5. **Semantic** - Animation names reflect purpose

### **Advanced Usage**

#### **Custom Animation Creation**
```php
$builder = new CSSAnimationBuilder();
$builder->addKeyframes('customSlide', [
    '0%' => ['transform' => 'translateX(-100%)', 'opacity' => '0'],
    '50%' => ['transform' => 'translateX(10px)', 'opacity' => '0.8'],
    '100%' => ['transform' => 'translateX(0)', 'opacity' => '1']
]);
```

#### **Conditional Animation Loading**
```php
// Only load animations on specific pages
if (is_front_page() || is_page_template('page-properties.php')) {
    REIA_Theme_Animation_Enhancement::init();
}
```

This system provides a complete foundation for creating engaging, accessible, and performance-optimized animations throughout your real estate WordPress theme.
