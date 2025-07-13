# SVN Integration Guide for CSS Animation Builder

## 🔄 Git-SVN Bridge (Recommended)

### Use git-svn to work with both systems:

```bash
# Initialize git-svn in your existing git repository
git svn init https://your-svn-server.com/repo/trunk

# Fetch SVN history
git svn fetch

# Create a branch for SVN work
git checkout -b svn-sync

# Push changes to SVN
git svn dcommit

# Pull changes from SVN
git svn rebase
```

### Workflow:
1. **Development**: Work in Git as normal
2. **SVN Sync**: Use `git svn dcommit` to push to SVN
3. **Updates**: Use `git svn rebase` to pull SVN changes

## 📦 SVN-Only Approach

If you need to migrate completely to SVN:

### 1. Export Git History
```bash
# Create SVN-compatible structure
mkdir -p svn-export/{trunk,branches,tags}
cp -r * svn-export/trunk/

# Remove Git files
rm -rf svn-export/trunk/.git*
```

### 2. Import to SVN
```bash
# Import to SVN repository
svn import svn-export https://your-svn-server.com/repo -m "Initial import from Git"

# Checkout working copy
svn checkout https://your-svn-server.com/repo/trunk css-animation-builder-svn
```

## 🛠️ SVN Commands for CSS Animation Builder

### Daily Development
```bash
# Update from repository
svn update

# Add new files (like new animation files)
svn add css/new-animation.css
svn add assets/js/new-feature.js

# Commit changes
svn commit -m "Add new handwriting animation styles"

# Check status
svn status

# View differences
svn diff

# View log
svn log -v
```

### Release Management
```bash
# Create release branch
svn copy trunk branches/release-1.4.0 -m "Create release branch 1.4.0"

# Create tag
svn copy trunk tags/v1.4.0 -m "Tag release v1.4.0"

# Switch to release branch
svn switch branches/release-1.4.0
```

## 🔧 SVN Properties for Web Assets

### Set proper SVN properties for different file types:

```bash
# Set MIME types for web files
svn propset svn:mime-type "text/html" *.html
svn propset svn:mime-type "text/css" css/*.css
svn propset svn:mime-type "text/javascript" assets/js/*.js
svn propset svn:mime-type "application/json" *.json

# Set executable property for scripts
svn propset svn:executable ON *.sh

# Ignore build artifacts
svn propset svn:ignore "node_modules
dist
.env
.DS_Store
*.log" .
```

## 📂 Recommended SVN Structure

```
css-animation-builder/
├── trunk/
│   ├── src/
│   ├── css/
│   ├── assets/
│   ├── demos/
│   ├── package.json
│   └── README.md
├── branches/
│   ├── feature-new-animations/
│   ├── release-1.4.0/
│   └── hotfix-animation-bug/
└── tags/
    ├── v1.0.0/
    ├── v1.1.0/
    ├── v1.2.0/
    ├── v1.3.0/
    └── v1.4.0/
```

## 🚀 Release Process with SVN

### 1. Prepare Release
```bash
# Update version in trunk
svn update
# Edit version files (package.json, etc.)
svn commit -m "Bump version to 1.4.0"

# Create release branch
svn copy trunk branches/release-1.4.0 -m "Create release branch 1.4.0"
```

### 2. Test and Finalize
```bash
# Switch to release branch
svn switch branches/release-1.4.0

# Make final adjustments
# Test thoroughly
# Commit final changes
svn commit -m "Final release preparations"
```

### 3. Tag and Deploy
```bash
# Create release tag
svn copy branches/release-1.4.0 tags/v1.4.0 -m "Tag release v1.4.0"

# Export clean copy for deployment
svn export tags/v1.4.0 css-animation-builder-v1.4.0
```

## 🔄 Migration Strategy

If migrating from Git to SVN:

### 1. Preserve History (Optional)
```bash
# Use git2svn tool for history preservation
git2svn --trunk=trunk --branches=branches --tags=tags \
        --authors=authors.txt \
        https://github.com/DavidEngland/css-animation-builder.git \
        https://your-svn-server.com/repo
```

### 2. Clean Migration
```bash
# Export current state
git archive --format=tar HEAD | tar -x -C ../css-animation-builder-clean

# Import to SVN
svn import ../css-animation-builder-clean \
    https://your-svn-server.com/repo/trunk \
    -m "Import CSS Animation Builder v1.4.0"
```

## 🎯 Best Practices

### 1. **File Organization**
- Keep binary assets in separate directories
- Use SVN externals for shared libraries
- Maintain clean trunk/branches/tags structure

### 2. **Commit Practices**
- Make atomic commits
- Write descriptive commit messages
- Test before committing

### 3. **Branch Management**
- Use feature branches for new animations
- Create release branches for stabilization
- Tag all releases

### 4. **Performance**
- Use `svn update --depth` for large repositories
- Exclude build artifacts with svn:ignore
- Use sparse checkouts for large codebases

## 🛡️ SVN Hooks for Quality Control

### Pre-commit Hook (for code quality)
```bash
#!/bin/bash
# Check CSS and JavaScript syntax
find "$1" -name "*.css" -exec csslint {} \;
find "$1" -name "*.js" -exec jslint {} \;
```

### Post-commit Hook (for deployment)
```bash
#!/bin/bash
# Auto-deploy to staging after trunk commits
if [[ "$2" == "trunk" ]]; then
    svn export https://your-svn-server.com/repo/trunk /var/www/staging
fi
```

## 🎨 Integration with CSS Animation Builder

### SVN-Specific Features:
- **Version Keywords**: Use `$Id$` in CSS comments
- **Automated Builds**: Trigger builds on SVN commits
- **Asset Management**: Track binary assets properly
- **Release Automation**: Script release tagging

### Example CSS with SVN Keywords:
```css
/**
 * CSS Animation Builder - Handwriting Animations
 * Version: $Id$
 * Author: David England
 */
.handwriting-quill {
    /* Animation styles */
}
```

## 🔗 Tool Integration

### IDE Integration:
- **VS Code**: SVN extension for version control
- **WebStorm**: Built-in SVN support
- **TortoiseSVN**: Windows GUI client

### Build Integration:
- **Jenkins**: SVN polling for CI/CD
- **GitHub Actions**: Can work with SVN repositories
- **npm scripts**: Include SVN commands in package.json

---

**Choose the approach that best fits your team's workflow and infrastructure requirements.**
