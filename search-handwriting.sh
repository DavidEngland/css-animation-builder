#!/bin/bash

# Search script for handwriting examples in Local Sites
# Created: July 12, 2025

echo "🔍 Searching for handwriting-related files in ~/Local Sites..."
echo "============================================================"

BASE_DIR="$HOME/Local Sites"

if [ ! -d "$BASE_DIR" ]; then
    echo "❌ Directory '$BASE_DIR' not found"
    exit 1
fi

echo "📁 Base directory: $BASE_DIR"
echo ""

# Search for handwriting-related files
echo "🖋️  Searching for handwriting files..."
echo "--------------------------------------"

# Find files with handwriting in name or content
find "$BASE_DIR" -type f \( -name "*.css" -o -name "*.html" -o -name "*.scss" -o -name "*.php" -o -name "*.js" -o -name "*.md" \) -exec grep -l -i "handwriting\|signature\|script\|cursive\|fountain\|pen\|calligraphy" {} \; 2>/dev/null | sort

echo ""
echo "🔤 Searching for font-related files (Coca-Cola style)..."
echo "--------------------------------------------------------"

# Search for specific fonts and typography
find "$BASE_DIR" -type f \( -name "*.css" -o -name "*.html" -o -name "*.scss" -o -name "*.php" \) -exec grep -l -i "coca.cola\|spencerian\|script\|brush\|vintage\|retro\|display.*font" {} \; 2>/dev/null | sort

echo ""
echo "📝 Searching for animation-related files..."
echo "--------------------------------------------"

# Find animation files
find "$BASE_DIR" -type f \( -name "*anim*" -o -name "*motion*" -o -name "*effect*" \) \( -name "*.css" -o -name "*.html" -o -name "*.scss" -o -name "*.php" -o -name "*.js" \) 2>/dev/null | sort

echo ""
echo "🎨 Searching in themes and plugins directories..."
echo "--------------------------------------------------"

# Search specifically in themes and plugins
find "$BASE_DIR" -type d \( -name "themes" -o -name "plugins" \) -exec find {} -type f \( -name "*.css" -o -name "*.html" -o -name "*.scss" -o -name "*.php" -o -name "*.md" \) \; 2>/dev/null | head -20

echo ""
echo "📋 Searching for documentation files..."
echo "----------------------------------------"

# Find markdown files with detailed documentation
find "$BASE_DIR" -name "*.md" -exec grep -l -i "font\|typography\|handwriting\|animation\|demo\|showcase" {} \; 2>/dev/null | sort

echo ""
echo "🔍 Detailed content search in promising files..."
echo "------------------------------------------------"

# Search for specific terms in CSS/HTML files
echo "Files containing 'font-family' with script/cursive:"
find "$BASE_DIR" -type f \( -name "*.css" -o -name "*.html" -o -name "*.scss" \) -exec grep -l "font-family.*\(script\|cursive\|signature\|hand\)" {} \; 2>/dev/null | head -10

echo ""
echo "Files containing animation keyframes:"
find "$BASE_DIR" -type f \( -name "*.css" -o -name "*.scss" \) -exec grep -l "@keyframes\|animation:" {} \; 2>/dev/null | head -10

echo ""
echo "🏁 Search complete!"
echo "==================="

# Summary statistics
total_css=$(find "$BASE_DIR" -name "*.css" 2>/dev/null | wc -l)
total_html=$(find "$BASE_DIR" -name "*.html" 2>/dev/null | wc -l)
total_php=$(find "$BASE_DIR" -name "*.php" 2>/dev/null | wc -l)
total_md=$(find "$BASE_DIR" -name "*.md" 2>/dev/null | wc -l)

echo "📊 File summary:"
echo "   CSS files: $total_css"
echo "   HTML files: $total_html"
echo "   PHP files: $total_php"
echo "   MD files: $total_md"
