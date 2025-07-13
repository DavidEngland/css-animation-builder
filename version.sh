#!/bin/bash

# Simple Version Management Script for CSS Animation Builder
# Usage: ./version.sh [patch|minor|major|custom_version]

echo "🎯 CSS Animation Builder - Version Management"
echo "============================================"

# Get current version from package.json
CURRENT_VERSION=$(grep '"version"' package.json | head -1 | cut -d'"' -f4)
echo "Current version: $CURRENT_VERSION"

# Parse current version
IFS='.' read -r major minor patch <<< "$CURRENT_VERSION"

# Determine new version based on argument
if [ "$1" == "patch" ]; then
    NEW_VERSION="$major.$minor.$((patch + 1))"
    VERSION_TYPE="Patch"
elif [ "$1" == "minor" ]; then
    NEW_VERSION="$major.$((minor + 1)).0"
    VERSION_TYPE="Minor"
elif [ "$1" == "major" ]; then
    NEW_VERSION="$((major + 1)).0.0"
    VERSION_TYPE="Major"
elif [ -n "$1" ]; then
    NEW_VERSION="$1"
    VERSION_TYPE="Custom"
else
    echo "Usage: ./version.sh [patch|minor|major|version_number]"
    echo ""
    echo "Examples:"
    echo "  ./version.sh patch   # $CURRENT_VERSION → $major.$minor.$((patch + 1))"
    echo "  ./version.sh minor   # $CURRENT_VERSION → $major.$((minor + 1)).0"
    echo "  ./version.sh major   # $CURRENT_VERSION → $((major + 1)).0.0"
    echo "  ./version.sh 1.6.3   # $CURRENT_VERSION → 1.6.3"
    exit 1
fi

echo ""
echo "📋 $VERSION_TYPE Version Update"
echo "From: $CURRENT_VERSION"
echo "To:   $NEW_VERSION"
echo ""

# Ask for changelog description
echo "📝 What's new in v$NEW_VERSION?"
echo "Enter description (or press Enter for default):"
read -r DESCRIPTION

# Set default description based on version type
if [ -z "$DESCRIPTION" ]; then
    case "$VERSION_TYPE" in
        "Patch")
            DESCRIPTION="Bug fixes and minor improvements"
            ;;
        "Minor")
            DESCRIPTION="New features and enhancements"
            ;;
        "Major")
            DESCRIPTION="Major updates and breaking changes"
            ;;
        "Custom")
            DESCRIPTION="Version update"
            ;;
    esac
fi

echo ""
echo "🔄 Updating version to $NEW_VERSION..."

# Update package.json
sed -i '' "s/\"version\": \"$CURRENT_VERSION\"/\"version\": \"$NEW_VERSION\"/" package.json
echo "✅ Updated package.json"

# Update composer.json
sed -i '' "s/\"version\": \"$CURRENT_VERSION\"/\"version\": \"$NEW_VERSION\"/" composer.json
echo "✅ Updated composer.json"

# Update README.md badge
sed -i '' "s/version-$CURRENT_VERSION-blue/version-$NEW_VERSION-blue/" README.md
echo "✅ Updated README.md"

# Update main PHP file
sed -i '' "s/Version: $CURRENT_VERSION/Version: $NEW_VERSION/" css-animation-builder.php
echo "✅ Updated css-animation-builder.php"

# Update WordPress plugin file
sed -i '' "s/Version: $CURRENT_VERSION/Version: $NEW_VERSION/" css-animation-builder-wordpress.php
echo "✅ Updated css-animation-builder-wordpress.php"

# Update CHANGELOG.md
TODAY=$(date +"%Y-%m-%d")
CHANGELOG_ENTRY="## [${NEW_VERSION}] - ${TODAY}

### ${VERSION_TYPE} Release
- ${DESCRIPTION}

"

# Create temporary file with new changelog entry
{
    head -7 Changelog.md
    echo "$CHANGELOG_ENTRY"
    tail -n +8 Changelog.md
} > Changelog.tmp && mv Changelog.tmp Changelog.md

echo "✅ Updated Changelog.md"

# Git operations
echo ""
echo "📦 Git Operations"

# Add all changes
git add .
echo "✅ Added all changes to git"

# Commit changes
git commit -m "Release v$NEW_VERSION

$VERSION_TYPE release: $DESCRIPTION

- Updated all version references
- Updated changelog
- Ready for release"

echo "✅ Created git commit"

# Create tag
git tag -a "v$NEW_VERSION" -m "Release v$NEW_VERSION

$DESCRIPTION"

echo "✅ Created git tag v$NEW_VERSION"

echo ""
echo "🎉 Version Update Complete!"
echo "================================"
echo "Version: $NEW_VERSION"
echo "Type: $VERSION_TYPE"
echo "Description: $DESCRIPTION"
echo ""
echo "Next steps:"
echo "1. Review changes: git log --oneline -5"
echo "2. Push to repository: git push && git push --tags"
echo "3. Create GitHub release (optional)"
echo ""
echo "Files updated:"
echo "- package.json"
echo "- composer.json"
echo "- README.md"
echo "- css-animation-builder.php"
echo "- css-animation-builder-wordpress.php"
echo "- Changelog.md"
echo ""
echo "Git operations:"
echo "- Committed all changes"
echo "- Created tag v$NEW_VERSION"
echo ""
echo "🚀 Ready to push!"
