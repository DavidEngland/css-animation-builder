import '../scss/main.scss';
import CSSAnimationBuilder from './css-animation-builder.js';

// Export for UMD build
export default CSSAnimationBuilder;

// Also make it available globally if loaded via script tag
if (typeof window !== 'undefined') {
  window.CSSAnimationBuilder = CSSAnimationBuilder;
}
