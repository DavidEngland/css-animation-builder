#!/bin/bash
# Setup script for CSS Animation Builder repository

echo "🚀 Setting up CSS Animation Builder repository..."

# Initialize git repository if not already done
if [ ! -d ".git" ]; then
    echo "📁 Initializing git repository..."
    git init
fi

# Add remote if not already added
if ! git remote get-url origin > /dev/null 2>&1; then
    echo "🔗 Adding GitHub remote..."
    git remote add origin https://github.com/DavidEngland/css-animation-builder.git
fi

# Create directory structure
echo "📁 Creating directory structure..."
mkdir -p src/{js,css,php,animations}
mkdir -p tests/{js,php}
mkdir -p dist
mkdir -p docs
mkdir -p examples/{wordpress,standalone,composer}

# Install dependencies if package.json exists
if [ -f "package.json" ]; then
    echo "📦 Installing Node.js dependencies..."
    npm install
fi

# Install PHP dependencies if composer.json exists
if [ -f "composer.json" ]; then
    echo "🎼 Installing PHP dependencies..."
    composer install
fi

# Initial commit
echo "📝 Creating initial commit..."
git add .
git commit -m "feat: initial project setup with complete repository structure

- Add comprehensive .gitignore for Node.js, PHP, and WordPress
- Set up package.json with build scripts and dependencies
- Configure composer.json for PHP package management
- Add GitHub Actions CI/CD pipeline
- Include MIT license and security policy
- Set up contributing guidelines and changelog
- Create professional README with full documentation"

echo "✅ Repository setup complete!"
echo ""
echo "🎯 Next steps:"
echo "   1. Push to GitHub: git push -u origin main"
echo "   2. Set up branch protection rules"
echo "   3. Configure secrets for CI/CD (NPM_TOKEN, CODECOV_TOKEN)"
echo "   4. Start development: npm run dev"
echo "   5. Run tests: npm test && composer test"
echo ""
echo "🔗 Repository URL: https://github.com/DavidEngland/css-animation-builder"