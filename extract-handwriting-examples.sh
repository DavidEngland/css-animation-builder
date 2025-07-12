#!/bin/bash

# Extract handwriting examples from Local Sites
# Created: July 12, 2025

echo "🔍 Extracting handwriting examples from Local Sites..."
echo "======================================================"

BASE_DIR="$HOME/Local Sites"
WORKSPACE_DIR="$(pwd)"
EXAMPLES_DIR="$WORKSPACE_DIR/handwriting-examples"

# Create examples directory
mkdir -p "$EXAMPLES_DIR"

echo "📁 Creating examples directory: $EXAMPLES_DIR"
echo ""

# Extract specific files that looked promising from our search
echo "🎯 Extracting specific promising files..."
echo "----------------------------------------"

# Shogun-Slogans plugin files
if [ -f "$BASE_DIR/reia-new/app/public/wp-content/plugins/Shogun-Slogans/HANDWRITING-SETUP-COMPLETE.md" ]; then
    echo "📄 Found Shogun-Slogans handwriting setup..."
    cp "$BASE_DIR/reia-new/app/public/wp-content/plugins/Shogun-Slogans/HANDWRITING-SETUP-COMPLETE.md" "$EXAMPLES_DIR/"
fi

# Look for CSS files with handwriting animations
echo "🖋️  Searching for CSS files with handwriting animations..."
find "$BASE_DIR" -type f -name "*.css" -exec grep -l "handwriting\|signature\|script\|cursive\|fountain\|pen\|calligraphy" {} \; 2>/dev/null | while read file; do
    echo "Found: $file"
    filename=$(basename "$file")
    dirname=$(dirname "$file" | sed "s|$BASE_DIR/||" | tr '/' '_')
    cp "$file" "$EXAMPLES_DIR/${dirname}_${filename}" 2>/dev/null || echo "  ⚠️  Could not copy $file"
done

echo ""
echo "🔤 Searching for font files and typography..."
echo "----------------------------------------------"

# Find font-related CSS files
find "$BASE_DIR" -type f -name "*.css" -exec grep -l "font-family.*script\|font-family.*cursive\|coca.cola\|spencerian\|brush.*font" {} \; 2>/dev/null | while read file; do
    echo "Found typography: $file"
    filename=$(basename "$file")
    dirname=$(dirname "$file" | sed "s|$BASE_DIR/||" | tr '/' '_')
    cp "$file" "$EXAMPLES_DIR/font_${dirname}_${filename}" 2>/dev/null || echo "  ⚠️  Could not copy $file"
done

echo ""
echo "📝 Searching for animation keyframes..."
echo "---------------------------------------"

# Find files with keyframes
find "$BASE_DIR" -type f -name "*.css" -exec grep -l "@keyframes\|animation.*name" {} \; 2>/dev/null | head -10 | while read file; do
    echo "Found keyframes: $file"
    filename=$(basename "$file")
    dirname=$(dirname "$file" | sed "s|$BASE_DIR/||" | tr '/' '_')
    cp "$file" "$EXAMPLES_DIR/keyframes_${dirname}_${filename}" 2>/dev/null || echo "  ⚠️  Could not copy $file"
done

echo ""
echo "🎨 Extracting from specific promising projects..."
echo "------------------------------------------------"

# Extract from animate-it and border-animations
for project in "animate-it" "border-animations" "reia-hello-child" "Shogun-Slogans"; do
    echo "🔍 Searching in $project..."
    find "$BASE_DIR" -type d -name "*$project*" -exec find {} -type f \( -name "*.css" -o -name "*.html" -o -name "*.md" \) \; 2>/dev/null | while read file; do
        if [ -f "$file" ]; then
            echo "  Found in $project: $file"
            filename=$(basename "$file")
            dirname=$(dirname "$file" | sed "s|$BASE_DIR/||" | tr '/' '_')
            cp "$file" "$EXAMPLES_DIR/${project}_${dirname}_${filename}" 2>/dev/null || echo "    ⚠️  Could not copy $file"
        fi
    done
done

echo ""
echo "📊 Summary of extracted files:"
echo "------------------------------"
ls -la "$EXAMPLES_DIR/"

echo ""
echo "✅ Extraction complete! Check the handwriting-examples directory for reference files."
