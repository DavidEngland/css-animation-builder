# Contributing to CSS Animation Builder

Thank you for your interest in contributing to CSS Animation Builder! This project is developed by the **Real Estate Intelligence Agency (REIA)** full stack development team.

## About REIA

- **Organization**: Real Estate Intelligence Agency (REIA)
- **Senior Lead Developer**: David England - DavidEngland@hotmail.com
- **CEO & Chief Broker**: Mikko P. Jetsu - Mikko@RealEstate-Huntsville.com
- **Website**: realestateintelligenceagency.com *(coming soon)*

## Code of Conduct

This project adheres to a Code of Conduct. By participating, you are expected to uphold this code. Please report unacceptable behavior to DavidEngland@hotmail.com.

## How to Contribute

### Reporting Bugs

Before creating bug reports, please check the existing issues to avoid duplicates. When creating a bug report, please include:

- **Use a clear and descriptive title**
- **Describe the exact steps to reproduce the problem**
- **Provide specific examples to demonstrate the steps**
- **Describe the behavior you observed and what behavior you expected**
- **Include screenshots if applicable**
- **Specify your browser/environment details**

### Suggesting Enhancements

Enhancement suggestions are welcome! Please provide:

- **A clear and descriptive title**
- **A detailed description of the suggested enhancement**
- **Explain why this enhancement would be useful**
- **List any similar features in other tools**

### Pull Requests

1. **Fork the repository** and create your branch from `main`
2. **Make your changes** following the coding standards
3. **Add tests** for new functionality
4. **Ensure all tests pass** (`npm test` and `composer test`)
5. **Update documentation** if needed
6. **Create a pull request** with a clear description

## Development Setup

### Prerequisites

- Node.js 16+
- PHP 7.4+
- Composer

### Installation

```bash
# Clone the repository
git clone https://github.com/DavidEngland/css-animation-builder.git
cd css-animation-builder

# Install Node.js dependencies
npm install

# Install PHP dependencies
composer install
```

### Development Workflow

```bash
# Start development server
npm run dev

# Run tests
npm test
composer test

# Run linting
npm run lint
composer run cs

# Build for production
npm run build
```

## Coding Standards

### JavaScript/TypeScript

- Use ESLint configuration provided
- Follow TypeScript best practices
- Use meaningful variable names
- Add JSDoc comments for public APIs
- Write unit tests for new features

### PHP

- Follow PSR-12 coding standards
- Use meaningful method and variable names
- Add PHPDoc comments
- Write unit tests with PHPUnit
- Use type hints where applicable

### CSS/SCSS

- Use BEM methodology for class naming
- Follow the existing architectural patterns
- Use CSS custom properties for theming
- Ensure responsive design principles

## Testing

### JavaScript Tests

```bash
# Run all tests
npm test

# Run tests in watch mode
npm run test:watch

# Run tests with coverage
npm run test:coverage
```

### PHP Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer run test:coverage

# Run static analysis
composer run analyze
```

## Documentation

- Update README.md for new features
- Add JSDoc/PHPDoc comments for new methods
- Update CHANGELOG.md following semantic versioning
- Add examples for new functionality

## Release Process

Releases are automated through GitHub Actions:

1. **Commit changes** following conventional commits
2. **Create pull request** to main branch
3. **After merge**, semantic-release will automatically:
   - Determine version bump
   - Generate changelog
   - Create GitHub release
   - Publish to npm (if configured)

## Animation Contributions

### Adding New Animations

1. **Create animation keyframes** in `src/animations/`
2. **Add animation metadata** to the registry
3. **Include preview examples**
4. **Add unit tests** for the animation
5. **Update documentation** with the new animation

### Animation Guidelines

- **Keep animations smooth** and performant
- **Test across browsers** and devices
- **Provide meaningful names** and descriptions
- **Include reasonable default values**
- **Consider accessibility** (respect prefers-reduced-motion)

## Questions?

Feel free to open an issue for questions, or contact David England directly at DavidEngland@hotmail.com.

## Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes
- Project documentation

Thank you for contributing to CSS Animation Builder! 🎨