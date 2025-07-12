# Elementor to FSE Migration Utilities

## Quick Reference: Elementor → Native Block Conversions

### Common Elementor Widgets → Core Blocks

| Elementor Widget | WordPress Block | Notes |
|-----------------|-----------------|-------|
| Heading | `core/heading` | Same functionality, better performance |
| Text Editor | `core/paragraph` | Native paragraph block |
| Button | `core/button` | Enhanced with your button styles |
| Image | `core/image` | Built-in responsive features |
| Video | `core/video` | Native video embedding |
| Spacer | `core/spacer` | Built-in spacing control |
| Divider | `core/separator` | Simple divider block |
| Icon List | `core/list` | Use custom CSS for icons |
| Testimonial | `core/quote` | Enhanced with testimonial CSS |
| Call to Action | `core/group` + `core/buttons` | Combine blocks in group |
| Icon Box | `core/group` + `core/heading` + `core/paragraph` | Use your service grid pattern |

### Elementor Sections → Block Patterns

| Elementor Section | Block Pattern | File |
|------------------|---------------|------|
| Hero Section | `reia/hero-section` | Uses cover block |
| Services Grid | `reia/services-grid` | Uses columns + groups |
| Testimonials | `reia/testimonial-section` | Uses quote block |
| Contact CTA | `reia/contact-cta` | Uses group + buttons |

## Migration Checklist

### Phase 1: Prepare (Current)
- [x] Enhanced theme.json with color system
- [x] Created block patterns for common layouts
- [x] Added FSE theme support
- [x] Created FSE-specific SCSS styles
- [ ] Test block patterns in editor
- [ ] Verify color inheritance from theme.json

### Phase 2: Header/Footer (Next Steps)
- [ ] Create FSE header template (`parts/header.html`)
- [ ] Create FSE footer template (`parts/footer.html`)
- [ ] Convert navigation to `core/navigation` block
- [ ] Test responsiveness without Elementor

### Phase 3: Content Pages (Later)
- [ ] Replace home page Elementor sections with block patterns
- [ ] Convert About Us page testimonials to quote blocks
- [ ] Replace image galleries with native gallery blocks
- [ ] Test all functionality without Elementor active

## Code Snippets for Common Migrations

### Hero Section (Elementor → Block Pattern)
```php
// Use the reia/hero-section pattern or create manually:
<!-- wp:cover {"url":"","hasParallax":true,"customOverlayColor":"#002D5F"} -->
<!-- Content here -->
<!-- /wp:cover -->
```

### Service Cards (Elementor → Columns)
```php
// Use the reia/services-grid pattern or:
<!-- wp:columns -->
<!-- wp:column -->
<!-- wp:group {"backgroundColor":"card-bg"} -->
<!-- Service content -->
<!-- /wp:group -->
<!-- /wp:column -->
<!-- /wp:columns -->
```

### Testimonial (Elementor → Quote)
```php
// Enhanced quote block with testimonial styling:
<!-- wp:quote {"className":"reia-testimonial-section"} -->
<blockquote class="wp-block-quote reia-testimonial-section">
<p>"Testimonial text here"</p>
<cite>Client Name</cite>
</blockquote>
<!-- /wp:quote -->
```

## CSS Classes for Enhanced Blocks

### Available CSS Classes
- `.reia-hero-section` - Hero section styling
- `.reia-section-primary` - Primary blue background sections
- `.reia-service-grid` - Service grid with hover effects
- `.reia-testimonial-section` - Enhanced testimonial styling

### Custom Button Classes (from your existing system)
- `.btn-primary` - Primary button style
- `.btn-secondary` - Secondary button style
- `.btn-large` - Large button
- `.btn-ghost` - Ghost/outline button

## Performance Benefits

### Before (Elementor)
- Elementor CSS: ~400KB
- Elementor JS: ~300KB
- Additional HTTP requests: 8-12
- Total bloat: ~700KB+

### After (Native Blocks + Your CSS)
- Theme CSS: ~27KB (production build)
- No additional JS
- HTTP requests: 1-2
- Total size: ~27KB

**Performance improvement: ~96% reduction in page weight**

## Testing Strategy

### 1. Parallel Development
- Keep Elementor active initially
- Create new pages with block patterns
- Compare visual results side-by-side

### 2. A/B Testing
- Use different pages for testing
- Measure Core Web Vitals improvements
- Verify mobile responsiveness

### 3. Content Migration
- Export Elementor content as reference
- Recreate with native blocks + patterns
- Ensure feature parity

## Rollback Plan

### If Issues Arise
1. Keep Elementor content as backup
2. Theme.json and block patterns are additive
3. Can disable block patterns if needed
4. Existing CSS won't conflict

### Safety Measures
- Version control all changes
- Database backups before major changes
- Staging environment for testing
- Gradual migration approach

---

*This migration maintains your "lean and mean" approach while preserving the visual impact through modern CSS and WordPress native features.*
