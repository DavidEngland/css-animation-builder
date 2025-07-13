# WordPress Plugin Testing Guide

## 🎯 Setup Instructions

### 1. Install the Plugin

1. **Upload Plugin Files:**
   - Copy `css-animation-builder-wordpress.php` to `/wp-content/plugins/`
   - Copy `css/handwriting-animations.css` to `/wp-content/plugins/css-animation-builder/css/`
   - Copy `src/` folder to `/wp-content/plugins/css-animation-builder/src/`

2. **Activate Plugin:**
   - Go to WordPress Admin > Plugins
   - Find "CSS Animation Builder"
   - Click "Activate"

### 2. Verify Installation

Check that Google Fonts are loaded:
- View page source
- Look for: `fonts.googleapis.com/css2?family=Dancing+Script`
- CSS file should be enqueued: `handwriting-animations.css`

## 🧪 Testing Scenarios

### Test 1: Basic Shortcode
```
[css-animation class="handwriting-quill" text="Hello World"]
```
**Expected:** Brown quill-style handwriting animation

### Test 2: Custom Duration
```
[css-animation class="handwriting-fountain" text="Shakespeare" duration="5s"]
```
**Expected:** Blue fountain pen animation lasting 5 seconds

### Test 3: Multiple Animations
```
[css-animation class="handwriting-quill" text="Coca-Cola"]
[css-animation class="handwriting-fountain" text="Shakespeare"]
[css-animation class="handwriting-casual" text="Modern Design"]
```
**Expected:** Three different handwriting styles

### Test 4: Long Text
```
[css-animation class="handwriting-formal" text="The quick brown fox jumps over the lazy dog"]
```
**Expected:** Formal handwriting with proper timing for long text

### Test 5: Custom Styling
```
[css-animation class="handwriting-signature" text="Your Name" style="color: #e74c3c; font-size: 3rem;"]
```
**Expected:** Signature style with custom color and size

## 📝 Test Content Templates

### Blog Post Template
```
Title: Welcome to Our Blog

Content:
Hello and welcome to our blog! 

[css-animation class="handwriting-quill" text="Where stories come to life"]

We're excited to share our journey with you through beautifully crafted posts and engaging content.

[css-animation class="handwriting-casual" text="Stay tuned for more!"]
```

### About Page Template
```
Title: About Us

Content:
# Our Story

[css-animation class="handwriting-fountain" text="Founded with passion"]

We believe in creating exceptional experiences through innovative design and heartfelt service.

[css-animation class="handwriting-formal" text="Excellence in every detail"]

## Our Team

Meet the people behind the magic:

[css-animation class="handwriting-signature" text="John & Jane Smith"]
```

### Contact Page Template
```
Title: Get in Touch

Content:
We'd love to hear from you!

[css-animation class="handwriting-quill" text="Send us a message"]

[Contact Form]

[css-animation class="handwriting-casual" text="We'll respond within 24 hours"]
```

## 🎨 Theme Integration Tests

### Test with Popular Themes

1. **Twenty Twenty-Three**
   - Test in full-site editing
   - Check block editor compatibility
   - Verify mobile responsiveness

2. **Astra**
   - Test with various layouts
   - Check custom font compatibility
   - Verify color scheme integration

3. **GeneratePress**
   - Test with page builders
   - Check performance impact
   - Verify accessibility features

### Visual Regression Testing

Create screenshots of:
- Desktop view (1920x1080)
- Tablet view (768x1024)
- Mobile view (375x667)
- Dark mode (if theme supports)

## 🔧 Technical Tests

### Performance Testing
```bash
# Test page load time
curl -w "@curl-format.txt" -o /dev/null -s "https://yoursite.com/test-page"

# Check CSS file size
ls -la wp-content/plugins/css-animation-builder/css/handwriting-animations.css

# Test with GTmetrix or PageSpeed Insights
```

### Browser Compatibility
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

### Accessibility Testing
- Screen reader compatibility
- Keyboard navigation
- Color contrast ratios
- Animation preferences respect

## 📊 Test Results Template

### Functionality Tests
- [ ] Shortcode renders correctly
- [ ] Google Fonts load properly
- [ ] CSS animations work
- [ ] Custom duration works
- [ ] Multiple animations on same page
- [ ] Long text handling
- [ ] Custom styling applies

### Performance Tests
- [ ] Page load time < 3 seconds
- [ ] CSS file size < 50KB
- [ ] No JavaScript errors
- [ ] No console warnings
- [ ] Mobile performance acceptable

### Compatibility Tests
- [ ] Works with current WordPress version
- [ ] Works with popular themes
- [ ] Works with page builders
- [ ] Works on mobile devices
- [ ] Works across browsers

### Accessibility Tests
- [ ] Screen reader friendly
- [ ] Keyboard accessible
- [ ] Respects motion preferences
- [ ] Proper contrast ratios
- [ ] Semantic HTML structure

## 🚀 Deployment Checklist

### Pre-Launch
- [ ] All tests passing
- [ ] Code reviewed and optimized
- [ ] Documentation updated
- [ ] Screenshots captured
- [ ] Video demos created

### Launch
- [ ] Plugin uploaded to WordPress.org
- [ ] Installation guide published
- [ ] Support documentation ready
- [ ] User feedback system in place

## 🎯 Common Issues & Solutions

### Issue: Animations not showing
**Solution:** Check if CSS file is enqueued properly

### Issue: Google Fonts not loading
**Solution:** Verify font URLs in plugin file

### Issue: Animations too fast/slow
**Solution:** Adjust duration parameter or CSS timing

### Issue: Mobile responsiveness
**Solution:** Test and adjust CSS media queries

### Issue: Theme conflicts
**Solution:** Add CSS specificity or theme-specific styles

## 📞 Support & Troubleshooting

### Debug Mode
Add to `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

### Check Error Logs
- Server error logs
- WordPress debug logs
- Browser console errors
- Network tab for failed requests

### Performance Monitoring
- Use Query Monitor plugin
- Check for slow queries
- Monitor memory usage
- Track loading times

---

**Ready to test your WordPress plugin!** 🚀
