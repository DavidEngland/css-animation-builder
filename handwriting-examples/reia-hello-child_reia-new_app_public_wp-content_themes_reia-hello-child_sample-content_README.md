# Sample WordPress Page Content - Implementation Guide

This directory contains sample WordPress page templates that demonstrate the complete implementation of the REIA animation system. Each template showcases different aspects of the animation framework and provides real-world usage examples.

## Available Sample Pages

### 1. Hero Section Showcase (`page-hero-showcase.php`)
**Template Name:** Hero Section Showcase

Demonstrates the animated hero section with:
- Full-screen hero with property search
- Market statistics with counter animations
- Feature cards with staggered animations
- Call-to-action sections
- Responsive design patterns

**Key Animation Features:**
- Hero content fade-in sequence
- Counter-up animations for statistics
- Staggered card animations
- Hover effects and transitions

### 2. Properties Showcase (`page-properties-showcase.php`)
**Template Name:** Properties Showcase

Features the animated property cards with:
- Property filtering and search functionality
- Interactive property cards
- Market insights section
- Newsletter signup
- Advanced filtering system

**Key Animation Features:**
- Property card hover animations
- Filter transition effects
- Search result animations
- Loading state animations
- Interactive form feedback

### 3. Testimonials Showcase (`page-testimonials-showcase.php`)
**Template Name:** Testimonials Showcase

Showcases the testimonials section with:
- Customer testimonials carousel
- Video testimonials
- Statistics and achievements
- Trust indicators
- Social proof elements

**Key Animation Features:**
- Testimonial card animations
- Carousel transition effects
- Statistics counter animations
- Video thumbnail hover effects
- Trust badge animations

### 4. Complete Animation Demo (`page-animation-demo.php`)
**Template Name:** Complete Animation Demo

Comprehensive demonstration featuring:
- All animated template parts
- Animation type showcases
- Interactive animation builder
- Performance and accessibility info
- Live animation controls

**Key Animation Features:**
- Complete animation library showcase
- Interactive animation testing
- Real-time animation controls
- Performance optimization examples
- Accessibility feature demonstrations

## How to Use These Templates

### 1. Installation
Copy the desired template files to your theme's root directory or a `sample-content` folder.

### 2. Creating Pages in WordPress Admin
1. Go to **Pages > Add New**
2. Set the page title (e.g., "Hero Showcase")
3. In the **Page Attributes** meta box, select the corresponding template from the dropdown
4. Publish the page

### 3. Customization
Each template includes:
- **Inline CSS** for template-specific styling
- **JavaScript** for interactive functionality
- **Sample Data** that can be replaced with real content
- **Responsive Design** patterns

### 4. Integration with Real Data
Replace the sample data arrays with:
- WordPress custom fields
- Post meta data
- Custom post types
- Database queries
- API integrations

## Template Structure

Each template follows this structure:

```php
<?php
/**
 * Template Name: [Template Name]
 * Description and purpose
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <!-- Template part includes -->
        <?php get_template_part('template-parts/[component]'); ?>
        
        <!-- Additional sections -->
        
    </main>
</div>

<style>
/* Template-specific styles */
</style>

<script>
// Template-specific JavaScript
</script>

<?php get_footer(); ?>
```

## Animation Implementation Examples

### Basic Animation Usage
```php
<div class="reia-animate" data-animation="fadeInUp">
    Content that will animate
</div>
```

### Staggered Animations
```php
<div data-stagger-group data-stagger-delay="200">
    <div class="reia-animate" data-animation="fadeInLeft">Item 1</div>
    <div class="reia-animate" data-animation="fadeInLeft">Item 2</div>
    <div class="reia-animate" data-animation="fadeInLeft">Item 3</div>
</div>
```

### Animation with Overrides
```php
<div class="reia-animate" 
     data-animation="scaleIn" 
     data-animation-duration="1200"
     data-animation-delay="500">
    Custom timing content
</div>
```

## Best Practices

### 1. Performance
- Use `data-stagger-group` for grouped animations
- Implement proper loading states
- Respect `prefers-reduced-motion`
- Use hardware-accelerated animations

### 2. Accessibility
- Provide fallback content
- Test with screen readers
- Ensure keyboard navigation works
- Respect user motion preferences

### 3. Responsive Design
- Test animations on mobile devices
- Adjust animation timing for smaller screens
- Consider touch interactions
- Optimize for different viewport sizes

### 4. Content Strategy
- Use animations to enhance, not distract
- Maintain consistent timing
- Group related animations
- Provide meaningful feedback

## Customization Examples

### Adding Custom Animation Data
```php
// In your template
$animation_data = [
    'type' => 'fadeInUp',
    'duration' => 800,
    'delay' => 200,
    'easing' => 'ease-out'
];

// Pass to template part
set_query_var('animation_config', $animation_data);
get_template_part('template-parts/custom-component');
```

### Dynamic Animation Attributes
```php
// Generate animation attributes dynamically
$animation_attrs = reia_get_animation_attributes([
    'animation' => 'slideInLeft',
    'duration' => 1000,
    'stagger' => true
]);

echo '<div ' . $animation_attrs . '>Dynamic content</div>';
```

## Testing and Debugging

### Animation Performance
- Use browser dev tools
- Monitor frame rates
- Test on various devices
- Check memory usage

### Accessibility Testing
- Test with screen readers
- Verify keyboard navigation
- Check color contrast
- Validate HTML semantics

### Cross-browser Compatibility
- Test in modern browsers
- Check fallback behavior
- Validate CSS transforms
- Verify JavaScript functionality

## Next Steps

1. **Choose a template** that matches your needs
2. **Create the WordPress page** using the template
3. **Customize the content** with your real data
4. **Test thoroughly** across devices and browsers
5. **Optimize performance** based on your requirements

For more detailed implementation guidance, see the main documentation files:
- `docs/ANIMATION_SYSTEM_GUIDE.md`
- `docs/COMPLETE_IMPLEMENTATION_SUMMARY.md`
