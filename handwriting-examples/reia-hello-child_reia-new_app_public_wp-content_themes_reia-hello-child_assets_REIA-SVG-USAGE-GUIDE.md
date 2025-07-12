# REIA SVG Icon System

A comprehensive WordPress integration for all your SVG icons with animation, styling, and easy template usage.

## 🚀 Features

- **Multiple Collections**: Properticons, Custom Real Estate icons, and REIA Logos
- **Easy Integration**: Simple functions and shortcodes
- **Animation Support**: Pulse, bounce, rotate, fade, and more
- **Responsive Design**: Built-in responsive sizing
- **Accessibility**: Proper ARIA labels and descriptions
- **Performance**: Caching and optimized loading
- **Customizable**: Fill, stroke, size, and color options

## 📁 Icon Collections

### 1. Properticons (21 icons)
**Location**: `assets/fonts/properticons/source/svg/extracted-php-fixed/`
**Icons**: mailbox, home, search, building, beds, baths, phone, mail, etc.

### 2. Custom Real Estate (12+ icons)
**Location**: `assets/fonts/properticons/source/svg/`
**Icons**: apartment, villa, commercial, residential, waterfront, etc.

### 3. REIA Logos (10+ files)
**Location**: `assets/svgs/`
**Icons**: Various REIA logo variations and branding elements

## 🔧 Usage

### In PHP Templates

```php
// Basic icon
echo reia_icon('mailbox');

// With options
echo reia_icon('home', [
    'size' => '32',
    'class' => 'my-custom-class',
    'animation' => 'pulse',
    'fill' => '#007cba'
]);

// From different collection
echo reia_icon('apartment', [
    'collection' => 'custom-real-estate',
    'size' => '48',
    'animation' => 'float'
]);

// Direct output (no return)
reia_the_icon('search', ['size' => '24', 'class' => 'search-icon']);
```

### With Shortcodes

```
[reia_icon icon="mailbox" size="24" animation="pulse"]

[reia_icon icon="apartment" collection="custom-real-estate" size="32" fill="#28a745"]

[reia_icon icon="home" size="48" class="feature-icon" animation="bounce"]
```

### Advanced Options

```php
echo reia_icon('building', [
    'collection' => 'properticons',          // Icon collection
    'size' => '32',                          // Size in pixels or CSS unit
    'class' => 'featured-property',          // Additional CSS classes
    'fill' => '#007cba',                     // Fill color
    'stroke' => '#333',                      // Stroke color
    'stroke_width' => '2',                   // Stroke width
    'animation' => 'pulse',                  // Animation name
    'title' => 'Property Building',         // Accessibility title
    'description' => 'Multi-story building', // Accessibility description
    'wrapper' => true,                       // Include wrapper span
    'attributes' => [                        // Custom attributes
        'data-property-id' => '123',
        'role' => 'img'
    ]
]);
```

## 🎨 Styling & Animation

### Size Classes
```html
<span class="reia-icon reia-icon-xs">...</span>    <!-- 12px -->
<span class="reia-icon reia-icon-sm">...</span>    <!-- 16px -->
<span class="reia-icon reia-icon-md">...</span>    <!-- 24px -->
<span class="reia-icon reia-icon-lg">...</span>    <!-- 32px -->
<span class="reia-icon reia-icon-xl">...</span>    <!-- 48px -->
<span class="reia-icon reia-icon-2xl">...</span>   <!-- 64px -->
<span class="reia-icon reia-icon-3xl">...</span>   <!-- 96px -->
```

### Color Classes
```html
<span class="reia-icon reia-icon-primary">...</span>
<span class="reia-icon reia-icon-success">...</span>
<span class="reia-icon reia-icon-property">...</span>
<span class="reia-icon reia-icon-listing">...</span>
```

### Animation Classes
```html
<span class="reia-icon reia-icon-pulse">...</span>
<span class="reia-icon reia-icon-bounce">...</span>
<span class="reia-icon reia-icon-rotate">...</span>
<span class="reia-icon reia-icon-float">...</span>
<span class="reia-icon reia-icon-hover">...</span>
```

### Background & Border Styles
```html
<span class="reia-icon reia-icon-bg-circle">...</span>
<span class="reia-icon reia-icon-border-circle">...</span>
<span class="reia-icon reia-icon-shadow">...</span>
```

## 📋 Example Templates

### Feature Section
```php
<div class="reia-feature-box">
    <?php reia_the_icon('home', ['size' => '48', 'class' => 'reia-icon-primary reia-icon-pulse']); ?>
    <h3>Residential Properties</h3>
    <p>Find your dream home with our extensive residential listings.</p>
</div>
```

### Property Features List
```php
<ul class="reia-icon-list">
    <li>
        <?php reia_the_icon('beds', ['size' => '20', 'class' => 'reia-icon-feature']); ?>
        3 Bedrooms
    </li>
    <li>
        <?php reia_the_icon('baths', ['size' => '20', 'class' => 'reia-icon-feature']); ?>
        2 Bathrooms
    </li>
    <li>
        <?php reia_the_icon('building', ['size' => '20', 'class' => 'reia-icon-feature']); ?>
        2-Story Building
    </li>
</ul>
```

### Contact Information
```php
<div class="contact-info">
    <p>
        <?php reia_the_icon('phone', ['size' => '16', 'class' => 'reia-icon-contact']); ?>
        <a href="tel:+1234567890">(123) 456-7890</a>
    </p>
    <p>
        <?php reia_the_icon('mail', ['size' => '16', 'class' => 'reia-icon-contact']); ?>
        <a href="mailto:info@reia.com">info@reia.com</a>
    </p>
</div>
```

### Property Type Navigation
```php
<nav class="property-types">
    <a href="/residential" class="property-type-link">
        <?php reia_the_icon('home', ['size' => '24', 'animation' => 'hover']); ?>
        Residential
    </a>
    <a href="/commercial" class="property-type-link">
        <?php reia_the_icon('building', ['size' => '24', 'animation' => 'hover']); ?>
        Commercial
    </a>
    <a href="/waterfront" class="property-type-link">
        <?php reia_the_icon('waterfront', ['collection' => 'custom-real-estate', 'size' => '24', 'animation' => 'hover']); ?>
        Waterfront
    </a>
</nav>
```

## 🔍 Available Icons

### Properticons Collection
- `beds` - Bedroom icon
- `baths` - Bathroom icon
- `building` - Multi-story building
- `home` - House icon
- `search` - Search/magnifying glass
- `phone` - Phone icon
- `mail` - Email icon
- `mailbox` - Mailbox icon
- `key` - Key icon
- `map-marker` - Map location marker
- `map-marker-home` - Map marker with house
- `mobile` - Mobile phone
- `message` - Message/chat bubble
- `question` - Question mark
- `pushpin` - Push pin
- `graph-line` - Line chart
- `graph-pie` - Pie chart
- `graph-bar` - Bar chart
- `logo-eho` - Equal Housing Opportunity
- `logo-realtor` - Realtor logo
- `logo-idx` - IDX logo

### Custom Real Estate Collection
- `apartment` - Apartment building
- `villa` - Villa/luxury home
- `commercial` - Commercial building
- `residential` - Residential area
- `waterfront` - Waterfront property
- `land` - Land/vacant lot
- `office` - Office building
- `garage` - Garage
- `loft` - Loft space
- `income` - Income property
- `vacant_land` - Vacant land

### REIA Logos Collection
- `Real-Estate-Intelligence-Agency-Logo-512` - Main REIA logo
- `reia-logo-colors` - Colored version

- Various circle logo variations

## 🛠️ Custom CSS Variables

The system includes CSS custom properties for easy theming:

```css
:root {
    --reia-primary-color: #007cba;
    --reia-secondary-color: #6c757d;
    --reia-property-color: #2c5aa0;
    --reia-listing-color: #28a745;
    --reia-contact-color: #17a2b8;
    --reia-feature-color: #fd7e14;
    /* ... and more */
}
```

## 📱 Responsive Usage

```php
// Responsive icon that adapts to screen size
echo reia_icon('home', ['class' => 'reia-icon-responsive']);

// Manual responsive classes
echo reia_icon('search', ['class' => 'reia-icon-sm d-md-none']); // Small on mobile
echo reia_icon('search', ['class' => 'reia-icon-lg d-none d-md-inline']); // Large on desktop
```

## ⚡ Performance Tips

1. **Caching**: Icons are automatically cached in memory
2. **CSS Loading**: Styles are enqueued once and cached by browser
3. **Inline SVG**: Icons are inlined for optimal performance
4. **Responsive Images**: Use responsive classes instead of multiple sizes

## 🔧 Developer Functions

```php
// Get all available icons from a collection
$icons = reia_get_available_icons('properticons');

// Get icon collections info
$collections = reia_svg_icons()->get_collections();

// Render icon picker (for admin interfaces)
reia_svg_icons()->render_icon_picker($selected_icon);
```

## 🎯 Use Cases

- **Property Listings**: Feature icons for beds, baths, square footage
- **Navigation Menus**: Property type navigation with icons
- **Contact Forms**: Phone, email, location icons
- **Feature Boxes**: Highlight services with animated icons
- **Social Proof**: Display certifications and logos
- **Call-to-Actions**: Enhance buttons with relevant icons
- **Property Search**: Search, filter, and map icons
- **Agent Profiles**: Contact and social media icons

This system provides everything you need to effectively use SVG icons throughout your REIA WordPress theme!
