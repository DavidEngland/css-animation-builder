# REIA Hello Elementor Child Theme

A modern, feature-rich WordPress child theme for [Hello Elementor](https://wordpress.org/themes/hello-elementor/), specifically designed for Real Estate Intelligence Agency (REIA) with comprehensive branding, slogan management, and professional presentation features.

🌐 **Live Demo**: [test.realestate-huntsville.com](https://test.realestate-huntsville.com)

## 🚀 Key Features

- **🎨 Brand-Focused Design**: Custom styling optimized for real estate professionals
- **📝 Advanced Slogan System**: 15+ professional slogan styles with blockquote/citation formats
- **🌟 Modern CSS & SASS**: Uses CSS variables, `@property`, `@layer`, container queries, and robust SASS architecture
- **📱 Responsive Design**: Mobile-first approach with container queries and fluid typography
- **♿ Accessibility-First**: WCAG AA compliant with proper semantic markup and contrast ratios
- **🎭 Custom Card & Grid System**: Flexible layouts for posts, Connections Directory, and custom widgets
- **⚡ Performance Optimized**: Minimalist, fast-loading, and built for extensibility
- **👨‍💻 Developer Friendly**: Well-documented code, modular SASS partials, and clear variable/mixin usage
- **🔌 Extensible Shortcodes**: Improved PHP shortcodes for Connections plugin integration
- **🎯 WordPress & Elementor Ready**: Seamless integration with Elementor and WordPress block editor

## 📦 Installation

1. **Download or Clone**: 
   ```bash
   git clone https://github.com/DavidEngland/reia-hello-child.git
   ```
2. **Upload**: Upload the theme folder to `/wp-content/themes/` in your WordPress installation
3. **Activate**: In WordPress admin, go to **Appearance > Themes** and activate **Hello Elementor Child**
4. **Parent Theme**: Ensure [Hello Elementor](https://wordpress.org/themes/hello-elementor/) parent theme is installed
5. **Optional**: Install recommended plugins (Elementor, Connections Business Directory)

## 🎨 Slogan System

This theme includes a comprehensive slogan management system featuring the company motto: **"We will help you make the Smart Move<sup>SM</sup> — I guarantee it!"**

### Available Slogan Styles:
- **Gradient Animated** (`slogan-gradient`) - Eye-catching animated text
- **Handwritten Script** (`slogan-handwritten`) - Personal, approachable style  
- **Premium Combination** (`slogan-premium`) - Maximum visual impact
- **3D Text Effect** (`slogan-3d`) - Bold and memorable
- **Highlighted Box** (`slogan-highlighted`) - Clean, trustworthy presentation
- **Modern Card** (`slogan-card`) - Elegant card-style layout
- **Typewriter Animation** (`slogan-typewriter`) - Unique typing effect
- **Emphasis Style** (`slogan-emphasis`) - Professional with keyword highlights

### Blockquote Citations:
Professional blockquote formats with proper attribution to **Mikko P. Jetsu, Broker/CEO**, including:
- Executive statement cards
- Professional letterhead style
- Pull quote formats
- Speech bubble presentations
- Award/achievement styling
- Simple professional citations

### Implementation Files:
- `gutenberg-slogan-blocks.html` - Copy-paste ready HTML blocks for Gutenberg
- `CUSTOM-HTML-BLOCKS.html` - Additional HTML block variations
- `SLOGAN-IMPLEMENTATION.md` - Detailed implementation guide
- `SLOGAN-PLACEMENT-STRATEGY.md` - Strategic placement recommendations

## 🛠️ Usage

- **Customize Styles**: Edit `style.scss` and SASS partials under `/sass/`
- **Add Shortcodes**: Modify PHP shortcodes in `functions.php` or custom plugins
- **Use Card/Grid Classes**: Apply in Elementor or block layouts for consistent design
- **Connections Directory**: See `/connections-templates/cmap/` for customizations
- **Slogan Implementation**: Use provided HTML blocks in WordPress Gutenberg editor

## 👨‍💻 Development

### SASS Structure:
All SASS partials are in `/sass/` and compiled to `style.css`:
  - `_variables.scss`, `_mixins.scss`, `_post-card.scss`, `_post-grid.scss`
  - `_single-post-card.scss`, `_zillow-review.scss`, `home.scss`

### Build Process:
- Use your preferred SASS compiler (`npm scripts`, `gulp`, or VS Code SASS extension)
- Compile `style.scss` to `style.css`
- Modern CSS leverages custom properties, `@property`, `@layer`, and container queries

### Documentation:
- All custom code and SASS partials include usage examples and best practices
- Comprehensive commenting throughout codebase
- Strategic implementation guides for all features

## 🎨 Customization

- **Global Theming**: Edit SASS variables in `_variables.scss`
- **Layout Extensions**: Override card/grid layouts in relevant SASS partials  
- **Custom Shortcodes**: Add new shortcodes in child theme or custom plugins
- **WordPress Details**: See `readme.txt` for WordPress-specific information and changelog

## 📚 Documentation

- **Slogan Implementation**: `SLOGAN-IMPLEMENTATION.md` - Complete setup guide
- **Placement Strategy**: `SLOGAN-PLACEMENT-STRATEGY.md` - Where and how to use slogans
- **HTML Blocks**: Ready-to-use code snippets in `gutenberg-slogan-blocks.html`
- **Custom Blocks**: Additional variations in `CUSTOM-HTML-BLOCKS.html`

## 🔗 Resources & Links

- **Live Demo**: [test.realestate-huntsville.com](https://test.realestate-huntsville.com)
- **GitHub Repository**: [github.com/DavidEngland/reia-hello-child](https://github.com/DavidEngland/reia-hello-child)
- **Hello Elementor Docs**: [developers.elementor.com/docs/hello-elementor-theme](https://developers.elementor.com/docs/hello-elementor-theme/)
- **Elementor Page Builder**: [elementor.com](https://elementor.com/)
- **Connections Business Directory**: [connections-pro.com](https://connections-pro.com/)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📋 Requirements

- **WordPress**: 5.9+
- **PHP**: 7.4+
- **Parent Theme**: Hello Elementor
- **Recommended Plugins**: Elementor, Connections Business Directory

## 📄 License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Credits

- **Developer**: David England
- **Organization**: Real Estate Intelligence Agency (REIA)
- **Contact**: Mikko@RealEstate-Huntsville.com

---

**Version**: 2.3.1  
**Last Updated**: June 18, 2025  
**Tested WordPress Version**: 6.5+

This theme is licensed under the [GNU GPL v3 or later](https://www.gnu.org/licenses/gpl-3.0.html). See `readme.txt` for third-party attributions.
