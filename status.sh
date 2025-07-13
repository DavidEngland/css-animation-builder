#!/bin/bash

# Project Status Script - See what's changed
# Usage: ./status.sh

echo "📊 CSS Animation Builder - Project Status"
echo "========================================"

# Get current version
CURRENT_VERSION=$(grep '"version"' package.json | head -1 | cut -d'"' -f4)
echo "Current version: $CURRENT_VERSION"

# Check git status
echo ""
echo "📝 Git Status:"
git status --porcelain

# Check if there are uncommitted changes
if [ -n "$(git status --porcelain)" ]; then
    echo ""
    echo "⚠️  You have uncommitted changes!"
    echo "   Run './version.sh patch|minor|major' when ready to version"
else
    echo ""
    echo "✅ No uncommitted changes - ready for versioning"
fi

# Show recent commits
echo ""
echo "📋 Recent Commits:"
git log --oneline -5

# Show available tags
echo ""
echo "🏷️  Recent Tags:"
git tag --sort=-version:refname | head -5

# Show file changes since last tag
LAST_TAG=$(git describe --tags --abbrev=0 2>/dev/null)
if [ -n "$LAST_TAG" ]; then
    echo ""
    echo "📄 Files changed since $LAST_TAG:"
    git diff --name-only $LAST_TAG..HEAD
fi

echo ""
echo "🎯 Version Commands:"
echo "   ./version.sh patch   # Bug fixes ($CURRENT_VERSION → patch bump)"
echo "   ./version.sh minor   # New features ($CURRENT_VERSION → minor bump)"  
echo "   ./version.sh major   # Breaking changes ($CURRENT_VERSION → major bump)"
echo "   ./version.sh 1.6.3   # Custom version ($CURRENT_VERSION → 1.6.3)"
