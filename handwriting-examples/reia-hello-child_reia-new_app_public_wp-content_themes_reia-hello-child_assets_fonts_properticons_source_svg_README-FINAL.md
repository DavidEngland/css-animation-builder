# Properticons SVG Extraction

This directory contains scripts and extracted SVG icons from the Properticons font used in the REIA Hello Elementor Child theme.

## ✅ Final Solution: PHP Script

The **recommended approach** is to use the PHP script `extract-simple.php`, which successfully extracts all 21 icons from the font file.

### Usage

```bash
cd source/svg
php extract-simple.php
```

This will:
- Extract all 21 SVG icons to the `extracted-php/` directory
- Create an HTML preview file at `extracted-php/index.html`
- Use proper coordinate transformations to ensure icons display correctly

### Extracted Icons

The following icons are extracted with their corresponding unicode values:

- **e001** → beds.svg
- **e002** → building.svg  
- **e003** → message.svg
- **e004** → search.svg
- **e005** → home.svg
- **e006** → map-marker-home.svg
- **e007** → mobile.svg
- **e008** → key.svg
- **e009** → graph-line.svg
- **e010** → mail.svg
- **e011** → mailbox.svg (the requested icon)
- **e012** → phone.svg
- **e013** → graph-pie.svg
- **e014** → map-marker.svg
- **e015** → question.svg
- **e016** → baths.svg
- **e017** → pushpin.svg
- **e018** → graph-bar.svg
- **e019** → logo-eho.svg
- **e020** → logo-realtor.svg
- **e021** → logo-idx.svg

### Icon Structure

Each extracted SVG includes:
- Proper XML declaration
- Standard SVG namespace
- 1024x1024 viewBox for scalability
- Coordinate transformation to handle font-to-SVG conversion
- `currentColor` fill for easy theming
- Descriptive title element

### Technical Details

The PHP script:
1. Reads the icon mapping from the main `index.html` file
2. Uses regex to parse glyph definitions from `fonts/properticons.svg`
3. Converts unicode values (e.g., `&#xe011;`) to hex codes (e.g., `e011`)
4. Applies coordinate transformation to flip Y-axis (font coordinates vs SVG coordinates)
5. Generates clean, standalone SVG files

### Previous Attempts

This directory also contains earlier Python-based attempts (`extract-*.py`) that had issues with coordinate transformations and icon distortion. The PHP solution is simpler and more reliable.

## 📁 Directory Structure

```
source/svg/
├── extract-simple.php       # ✅ RECOMMENDED: PHP extraction script
├── extracted-php/           # ✅ Final extracted SVG icons
│   ├── index.html           # Visual preview of all icons
│   ├── mailbox.svg          # Target icon (e011)
│   └── *.svg               # All 21 extracted icons
├── extract-*.py            # Previous Python attempts
├── extracted/              # Earlier extraction attempts
├── extracted-simple/       # Earlier extraction attempts
└── README.md               # This documentation
```

## 🔧 File Usage

The extracted SVG files can be used directly in:

**HTML:**
```html
<img src="mailbox.svg" alt="Mailbox" width="24" height="24">
```

**CSS:**
```css
.icon-mailbox {
    background-image: url('mailbox.svg');
    width: 24px;
    height: 24px;
}
```

**Inline SVG:**
```html
<!-- Copy the SVG content directly -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" width="24" height="24">
  <title>mailbox</title>
  <g transform="scale(1, -1) translate(0, -1024)">
    <path d="..." fill="currentColor"/>
  </g>
</svg>
```

**React/Vue Components:**
```jsx
import MailboxIcon from './mailbox.svg';
// or import as inline SVG
```

Each icon is scalable and will inherit text color when using `currentColor`.

## 🎯 Success Criteria

✅ **COMPLETED**: All 21 icons successfully extracted  
✅ **COMPLETED**: Icons display correctly without distortion  
✅ **COMPLETED**: Mailbox icon (e011) extracted as requested  
✅ **COMPLETED**: Clean, standalone SVG files generated  
✅ **COMPLETED**: Visual preview created for verification  

The extraction task is now complete with properly formatted, non-distorted SVG icons ready for use.
