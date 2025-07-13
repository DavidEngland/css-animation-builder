# Simple Versioning System for CSS Animation Builder

## 🎯 Easy Version Management

### Quick Version Commands

```bash
# Patch version (bug fixes): 1.4.0 → 1.4.1
./version.sh patch

# Minor version (new features): 1.4.0 → 1.5.0
./version.sh minor

# Major version (breaking changes): 1.4.0 → 2.0.0
./version.sh major

# Custom version
./version.sh 1.6.3
```

## 📋 Version Types

### 🔧 Patch (1.4.0 → 1.4.1)
- **Bug fixes**
- **CSS tweaks** 
- **Small improvements**
- **Documentation updates**

### 🚀 Minor (1.4.0 → 1.5.0)
- **New animations**
- **New features**
- **Enhanced functionality**
- **New demo pages**

### 💥 Major (1.4.0 → 2.0.0)
- **Breaking changes**
- **Complete rewrites**
- **API changes**
- **New architecture**

## 🛠️ Auto-Generated Files

When you run versioning, it automatically updates:
- `package.json`
- `composer.json`
- `README.md` badges
- PHP file headers
- `CHANGELOG.md` entry
- Git tag creation

## 📝 Changelog Automation

Each version automatically:
1. **Creates changelog entry**
2. **Lists changed files**
3. **Prompts for description**
4. **Commits changes**
5. **Creates git tag**

## 🎨 Examples

### Adding New Handwriting Style
```bash
./version.sh minor
# Prompts: "What's new in v1.5.0?"
# You enter: "Added calligraphy handwriting style"
# Result: Version 1.5.0 with automatic changelog
```

### Fixing Animation Bug
```bash
./version.sh patch
# Prompts: "What's fixed in v1.4.1?"
# You enter: "Fixed typewriter animation timing"
# Result: Version 1.4.1 with automatic changelog
```

### Major Rewrite
```bash
./version.sh major
# Prompts: "What's changed in v2.0.0?"
# You enter: "Complete rewrite with new animation engine"
# Result: Version 2.0.0 with automatic changelog
```

## 🔄 Workflow

1. **Make your changes**
2. **Run version script**
3. **Enter description**
4. **Everything else is automatic**

Simple as that! 🎉
