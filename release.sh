#!/bin/bash

# Release Script for CSS Animation Builder
# This script helps prepare for a new release

echo "🚀 CSS Animation Builder Release Preparation"
echo "=============================================="

# Get current version from package.json
CURRENT_VERSION=$(grep '"version"' package.json | head -1 | cut -d'"' -f4)
echo "Current version: $CURRENT_VERSION"

# Calculate suggested next version (increment minor version)
IFS='.' read -r major minor patch <<< "$CURRENT_VERSION"
SUGGESTED_VERSION="$major.$((minor + 1)).0"

# Ask for new version with default suggestion
read -p "Enter new version (default: $SUGGESTED_VERSION): " NEW_VERSION

# Use suggested version if no input provided
if [ -z "$NEW_VERSION" ]; then
    NEW_VERSION="$SUGGESTED_VERSION"
    echo "Using default version: $NEW_VERSION"
fi

echo "🔄 Updating version to $NEW_VERSION..."

# Update package.json
sed -i '' "s/\"version\": \"$CURRENT_VERSION\"/\"version\": \"$NEW_VERSION\"/" package.json

# Update composer.json
sed -i '' "s/\"version\": \"$CURRENT_VERSION\"/\"version\": \"$NEW_VERSION\"/" composer.json

# Update README.md badge
sed -i '' "s/version-$CURRENT_VERSION-blue/version-$NEW_VERSION-blue/" README.md

# Update main PHP file
sed -i '' "s/Version: $CURRENT_VERSION/Version: $NEW_VERSION/" css-animation-builder.php

echo "✅ Version updated in all files"

# Run tests
echo "🧪 Running tests..."
npm test

if [ $? -eq 0 ]; then
    echo "✅ All tests passed"
else
    echo "❌ Tests failed. Please fix before releasing."
    exit 1
fi

# Build project
echo "🔨 Building project..."
npm run build

if [ $? -eq 0 ]; then
    echo "✅ Build successful"
else
    echo "❌ Build failed. Please fix before releasing."
    exit 1
fi

echo ""
echo "🎉 Release preparation complete!"
echo "Next steps:"
echo "1. Review changes: git diff"
echo "2. Update CHANGELOG.md with new features"
echo "3. Commit changes: git add . && git commit -m 'Release v$NEW_VERSION'"
echo "4. Create tag: git tag v$NEW_VERSION"
echo "5. Push to repository: git push && git push --tags"
echo "6. Create GitHub release"
echo "7. Publish to npm: npm publish"
