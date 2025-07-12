# HTML Template with Block Patterns - REIA Theme

## Overview

This theme supports creating HTML templates that reference block patterns for modular, maintainable design. This approach allows you to:

- Keep templates minimal and focused
- Reuse patterns across multiple templates
- Maintain consistency while allowing customization
- Take advantage of WordPress FSE architecture

## Basic Usage

### Simple Pattern Reference
The simplest approach is to create an HTML template that references a single pattern:

```html
<!-- wp:pattern {"slug":"reia/template-page-search"} /-->
```

This approach works well for:
- Complete page templates that don't need customization
- Standardized layouts (search results, 404 pages, etc.)
- Rapid prototyping

### Multiple Pattern Composition
For more complex layouts, compose multiple patterns:

```html
<!-- wp:template-part {"slug":"reia/header","area":"header"} /-->

<!-- wp:pattern {"slug":"reia/hero-section"} /-->

<!-- wp:pattern {"slug":"reia/services-grid"} /-->

<!-- wp:pattern {"slug":"reia/testimonial-section"} /-->

<!-- wp:pattern {"slug":"reia/contact-cta"} /-->

<!-- wp:template-part {"slug":"reia/footer","area":"footer"} /-->
```

## Available Patterns

### Page Templates
- `reia/template-page-search` - Complete search results page
- `reia/template-page-general` - Flexible general page template
- `reia/template-page-404` - Complete 404 error page with search and navigation
- `reia/template-page-404` - Standard 404 error page

### Content Sections
- `reia/hero-section` - Primary hero with CTA
- `reia/services-grid` - Service cards in grid layout
- `reia/testimonial-section` - Client testimonial display
- `reia/contact-cta` - Call-to-action section

### Content Cards
- `reia/post-card` - Standard post card for archives
- `reia/post-card-search` - Enhanced search result card
- `reia/no-results` - No results found display

## Template Examples

### search.html (Current Implementation)
```html
<!-- wp:template-part {"slug":"reia/header","area":"header"} /-->

<!-- wp:group {"tagName":"main","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained","contentSize":"1200px"}} -->
<main class="wp-block-group search" style="padding-top:4rem;padding-bottom:4rem">
    <!-- Enhanced search interface with query display -->
    <!-- wp:query with reia/post-card-search pattern -->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"reia/footer","area":"footer"} /-->
```

### search-pattern.html (Pattern Reference Approach)
```html
<!-- wp:pattern {"slug":"reia/template-page-search"} /-->
```

### Custom Service Page Example
```html
<!-- wp:template-part {"slug":"reia/header","area":"header"} /-->

<!-- wp:pattern {"slug":"reia/hero-section"} /-->

<!-- wp:group {"tagName":"main","layout":{"type":"constrained"}} -->
<main class="wp-block-group">
    <!-- wp:post-title {"level":1} /-->
    <!-- wp:post-content /-->
    
    <!-- wp:pattern {"slug":"reia/services-grid"} /-->
    
    <!-- wp:pattern {"slug":"reia/contact-cta"} /-->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"reia/footer","area":"footer"} /-->
```

### 404.html (Pattern Reference Approach)
```html
<!-- wp:pattern {"slug":"reia/template-page-404"} /-->
```

### 404-custom.html (Mixed Approach)
```html
<!-- wp:template-part {"slug":"reia/header","area":"header"} /-->

<!-- Custom 404 content block -->
<main class="wp-block-group error-404">
    <!-- Custom 404 message and search -->
</main>

<!-- wp:pattern {"slug":"reia/contact-cta"} /-->
<!-- wp:template-part {"slug":"reia/footer","area":"footer"} /-->
```

## Benefits

### 1. Modularity
- Patterns can be updated once and affect all templates using them
- Easy to maintain consistent styling and structure
- Rapid iteration on design changes

### 2. Performance
- Native WordPress blocks with optimized CSS
- No JavaScript framework overhead
- Efficient rendering through block patterns

### 3. Editor Integration
- Patterns appear in Site Editor for easy customization
- Users can override patterns on specific pages
- Full visual editing capabilities

### 4. Developer Experience
- Clear separation of concerns
- Easy to understand and maintain
- Version control friendly

## Customization

### Template-Specific Styling
Add classes to wrapping groups for template-specific styling:

```html
<!-- wp:group {"className":"search-template"} -->
<div class="wp-block-group search-template">
    <!-- wp:pattern {"slug":"reia/template-page-search"} /-->
</div>
<!-- /wp:group -->
```

### Pattern Variations
Create pattern variations for different contexts:

```html
<!-- For homepage -->
<!-- wp:pattern {"slug":"reia/hero-section"} /-->

<!-- For about page -->
<!-- wp:pattern {"slug":"reia/hero-section-about"} /-->

<!-- For services page -->
<!-- wp:pattern {"slug":"reia/hero-section-services"} /-->
```

## Best Practices

1. **Keep Templates Simple**: Use patterns for complex structures
2. **Consistent Naming**: Follow the `reia/template-*` convention for full page patterns
3. **Document Patterns**: Include descriptions in pattern registration
4. **Test in Site Editor**: Verify patterns work correctly in the WordPress editor
5. **Mobile-First**: Ensure patterns are responsive and accessible

## Migration Strategy

1. **Start with Simple Templates**: Convert simpler pages first (search, 404, archive)
2. **Create Pattern Libraries**: Build reusable patterns for common sections
3. **Test Thoroughly**: Verify functionality in both front-end and Site Editor
4. **Gradual Migration**: Move from Elementor to patterns page by page
5. **User Training**: Document pattern usage for content editors

This approach provides the foundation for a modern, maintainable WordPress theme that leverages the full power of Full Site Editing while maintaining the visual impact and professional appearance of the REIA brand.
