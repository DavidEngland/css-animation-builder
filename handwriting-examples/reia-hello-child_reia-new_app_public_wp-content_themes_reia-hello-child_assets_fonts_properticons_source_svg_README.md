# Properticons SVG Icon Extraction

This directory contains tools and extracted SVG icons from the Properticons font family.

## 📁 Directory Structure

```
source/svg/
├── extract-svg-icons.py    # Python script to extract SVG icons from font
├── extract-svg-icons.js    # Node.js script (alternative)
├── debug-xml.py            # Debug script for XML structure analysis
├── extracted/               # Output directory for extracted SVG icons
│   ├── index.html          # Visual index of all extracted icons
│   ├── beds.svg            # Individual SVG icon files
│   ├── mailbox.svg         # (e011) - Mailbox icon
│   ├── home.svg            # (e005) - Home icon
│   └── ...                 # All 21 extracted icons
└── README.md               # This documentation file
```

## 🚀 Quick Start

### Extract SVG Icons from Font

```bash
# Navigate to the SVG source directory
cd assets/fonts/properticons/source/svg

# Run the extraction script
python3 extract-svg-icons.py
```

### View Extracted Icons

Open `extracted/index.html` in your browser to see all extracted icons with their names and Unicode values.

## 📋 Available Icons

The script extracts 21 icons from the Properticons font:

| Icon Name | Unicode | File Name | Description |
|-----------|---------|-----------|-------------|
| beds | e001 | beds.svg | Bedroom/bed icon |
| building | e002 | building.svg | Multi-story building |
| message | e003 | message.svg | Message/chat bubble |
| search | e004 | search.svg | Search/magnifying glass |
| home | e005 | home.svg | House/home icon |
| map-marker-home | e006 | map-marker-home.svg | Map marker with house |
| mobile | e007 | mobile.svg | Mobile phone |
| key | e008 | key.svg | Key icon |
| graph-line | e009 | graph-line.svg | Line graph |
| mail | e010 | mail.svg | Email envelope |
| **mailbox** | **e011** | **mailbox.svg** | **Mailbox icon** |
| phone | e012 | phone.svg | Telephone |
| graph-pie | e013 | graph-pie.svg | Pie chart |
| map-marker | e014 | map-marker.svg | Map location marker |
| question | e015 | question.svg | Question mark |
| baths | e016 | baths.svg | Bathroom/bath icon |
| pushpin | e017 | pushpin.svg | Push pin |
| graph-bar | e018 | graph-bar.svg | Bar chart |
| logo-eho | e019 | logo-eho.svg | Equal Housing Opportunity logo |
| logo-realtor | e020 | logo-realtor.svg | REALTOR® logo |
| logo-idx | e021 | logo-idx.svg | IDX logo |

## 🔧 Technical Details

### Font to SVG Conversion

The extraction script performs the following operations:

1. **Parses the SVG font file** (`../../fonts/properticons.svg`)
2. **Extracts glyph elements** with Unicode attributes
3. **Converts font coordinates** to standard SVG coordinates (Y-axis flip)
4. **Generates individual SVG files** with proper metadata
5. **Creates an HTML index** for visual reference

### SVG Output Format

Each extracted SVG includes:

- **Proper XML declaration** and SVG namespace
- **Accessibility metadata** (title and description)
- **Standardized viewBox** (0 0 1024 1024)
- **Scalable dimensions** (1024x1024 default)
- **currentColor fill** for easy styling

### Example SVG Output

```svg
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" width="1024" height="1024">
  <title>mailbox</title>
  <desc>Properticons mailbox icon (Unicode: \e011)</desc>
  <path d="M 600 1888.0h-120v160h120v-160z..." fill="currentColor"/>
</svg>
```

## 🎨 Usage in Projects

### HTML

```html
<!-- Inline SVG -->
<svg class="icon">
  <use href="./extracted/mailbox.svg#icon"></use>
</svg>

<!-- Direct embedding -->
<img src="./extracted/mailbox.svg" alt="Mailbox" width="24" height="24">
```

### CSS

```css
.mailbox-icon {
  background-image: url('./extracted/mailbox.svg');
  background-size: contain;
  background-repeat: no-repeat;
  width: 24px;
  height: 24px;
}
```

### React/Vue Components

```jsx
import MailboxIcon from './extracted/mailbox.svg';

function MyComponent() {
  return <MailboxIcon className="icon" />;
}
```

## 📝 Script Features

### Python Script (`extract-svg-icons.py`)

- ✅ **No dependencies** - Uses only Python standard library
- ✅ **Automatic naming** - Maps Unicode values to readable names
- ✅ **Coordinate conversion** - Handles font-to-SVG coordinate transformation
- ✅ **Visual index** - Generates HTML preview of all icons
- ✅ **Error handling** - Comprehensive error reporting and debugging

### Node.js Script (`extract-svg-icons.js`)

- ✅ **Alternative implementation** - For Node.js environments
- ✅ **XML parsing** - Uses xmldom for parsing
- ✅ **Same output format** - Produces identical SVG files

## 🔍 Debugging

If extraction fails, use the debug script:

```bash
python3 debug-xml.py
```

This will show the XML structure and help identify any parsing issues.

## 🎯 Original Font Reference

The extracted icons maintain the same Unicode mappings as the original Properticons font:

- **Font file**: `../../fonts/properticons.svg`
- **CSS classes**: `.properticons-mailbox`, `.properticons-beds`, etc.
- **Unicode range**: U+E001 to U+E021

## 📄 License

The extracted SVG icons maintain the same license as the original Properticons font:
- **License**: GPLv2 or later with font exception
- **Source**: Agent Evolution
- **Usage**: Free for real estate websites and applications

---

**Note**: The coordinate conversion may need refinement for complex paths. The current implementation handles basic transformations but may require adjustments for more complex icon geometries.
