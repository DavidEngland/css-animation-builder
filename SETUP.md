# CSS Animation Builder Documentation

## Installation & Setup

To get started with development:

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build the project
npm run build

# Run tests
npm test
composer test
```

## Project Structure

```
css-animation-builder-standalone/
├── .github/workflows/       # GitHub Actions workflows
├── assets/                  # Frontend source code
│   ├── js/                 # JavaScript source files
│   ├── css/                # CSS files
│   └── scss/               # SCSS source files
├── dist/                   # Built files (generated)
├── src/                    # PHP source files
│   ├── Builder.php         # Core PHP builder class
│   └── WordPressPlugin.php # WordPress integration
├── tests/                  # Test files
├── composer.json           # PHP dependencies
├── package.json           # Node.js dependencies
└── README.md              # Main documentation
```

## Development Workflow

1. **Frontend Development**: Edit files in `assets/js/` and `assets/scss/`
2. **PHP Development**: Edit files in `src/`
3. **Testing**: Run `npm test` for JS tests, `composer test` for PHP tests
4. **Building**: Run `npm run build` to generate distribution files
5. **Linting**: Run `npm run lint` to check code quality

## Available Scripts

- `npm run build` - Build the project
- `npm run dev` - Start development mode with watch
- `npm test` - Run JavaScript tests
- `npm run lint` - Lint JavaScript files
- `composer test` - Run PHP tests

## Next Steps

1. Install dependencies: `npm install && composer install`
2. Build the project: `npm run build`
3. Test the implementation: `npm test`
4. Review the generated files in `dist/`
