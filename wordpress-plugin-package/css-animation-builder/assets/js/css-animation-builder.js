/**
 * CSS Animation Builder
 * A framework-agnostic CSS animation builder with interactive controls
 * 
 * @version 1.0.0
 * @author David England
 * @license MIT
 */

class CSSAnimationBuilder {
  constructor(options = {}) {
    this.options = {
      container: '#animation-builder',
      theme: 'default',
      showPreview: true,
      showCode: true,
      animations: [
        'fadeIn', 'fadeOut', 'slideInLeft', 'slideInRight', 
        'slideInUp', 'slideInDown', 'slideOutLeft', 'slideOutRight',
        'zoomIn', 'zoomOut', 'bounceIn', 'bounceOut', 
        'rotateIn', 'rotateOut', 'pulse', 'shake', 'wobble', 'swing',
        'typewriter', 'handwriting'
      ],
      defaults: {
        duration: 1.0,
        delay: 0.0,
        timingFunction: 'ease',
        iterationCount: 1,
        direction: 'normal',
        fillMode: 'both'
      },
      callbacks: {
        onAnimationChange: null,
        onCodeGenerated: null,
        onPreviewStarted: null,
        onPreviewStopped: null
      },
      ...options
    };

    this.container = null;
    this.currentAnimation = { ...this.options.defaults };
    this.customAnimations = {};
    this.isInitialized = false;
    this.previewElement = null;
    this.previewTimeout = null;

    // Animation keyframes definitions
    this.animationKeyframes = {
      fadeIn: {
        name: 'Fade In',
        keyframes: `
          0% { opacity: 0; }
          100% { opacity: 1; }
        `
      },
      fadeOut: {
        name: 'Fade Out',
        keyframes: `
          0% { opacity: 1; }
          100% { opacity: 0; }
        `
      },
      slideInLeft: {
        name: 'Slide In Left',
        keyframes: `
          0% { transform: translateX(-100%); opacity: 0; }
          100% { transform: translateX(0); opacity: 1; }
        `
      },
      slideInRight: {
        name: 'Slide In Right',
        keyframes: `
          0% { transform: translateX(100%); opacity: 0; }
          100% { transform: translateX(0); opacity: 1; }
        `
      },
      slideInUp: {
        name: 'Slide In Up',
        keyframes: `
          0% { transform: translateY(100%); opacity: 0; }
          100% { transform: translateY(0); opacity: 1; }
        `
      },
      slideInDown: {
        name: 'Slide In Down',
        keyframes: `
          0% { transform: translateY(-100%); opacity: 0; }
          100% { transform: translateY(0); opacity: 1; }
        `
      },
      slideOutLeft: {
        name: 'Slide Out Left',
        keyframes: `
          0% { transform: translateX(0); opacity: 1; }
          100% { transform: translateX(-100%); opacity: 0; }
        `
      },
      slideOutRight: {
        name: 'Slide Out Right',
        keyframes: `
          0% { transform: translateX(0); opacity: 1; }
          100% { transform: translateX(100%); opacity: 0; }
        `
      },
      zoomIn: {
        name: 'Zoom In',
        keyframes: `
          0% { transform: scale(0.3); opacity: 0; }
          50% { opacity: 1; }
          100% { transform: scale(1); }
        `
      },
      zoomOut: {
        name: 'Zoom Out',
        keyframes: `
          0% { transform: scale(1); opacity: 1; }
          50% { opacity: 0; }
          100% { transform: scale(0.3); opacity: 0; }
        `
      },
      bounceIn: {
        name: 'Bounce In',
        keyframes: `
          0% { transform: scale(0.3); opacity: 0; }
          50% { transform: scale(1.05); opacity: 1; }
          70% { transform: scale(0.9); }
          100% { transform: scale(1); opacity: 1; }
        `
      },
      bounceOut: {
        name: 'Bounce Out',
        keyframes: `
          0% { transform: scale(1); opacity: 1; }
          25% { transform: scale(0.95); opacity: 1; }
          50% { transform: scale(1.1); opacity: 1; }
          100% { transform: scale(0.3); opacity: 0; }
        `
      },
      rotateIn: {
        name: 'Rotate In',
        keyframes: `
          0% { transform: rotate(-200deg); opacity: 0; }
          100% { transform: rotate(0); opacity: 1; }
        `
      },
      rotateOut: {
        name: 'Rotate Out',
        keyframes: `
          0% { transform: rotate(0); opacity: 1; }
          100% { transform: rotate(200deg); opacity: 0; }
        `
      },
      pulse: {
        name: 'Pulse',
        keyframes: `
          0% { transform: scale(1); }
          50% { transform: scale(1.05); }
          100% { transform: scale(1); }
        `
      },
      shake: {
        name: 'Shake',
        keyframes: `
          0%, 100% { transform: translateX(0); }
          10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
          20%, 40%, 60%, 80% { transform: translateX(10px); }
        `
      },
      wobble: {
        name: 'Wobble',
        keyframes: `
          0% { transform: translateX(0%); }
          15% { transform: translateX(-25%) rotate(-5deg); }
          30% { transform: translateX(20%) rotate(3deg); }
          45% { transform: translateX(-15%) rotate(-3deg); }
          60% { transform: translateX(10%) rotate(2deg); }
          75% { transform: translateX(-5%) rotate(-1deg); }
          100% { transform: translateX(0%); }
        `
      },
      swing: {
        name: 'Swing',
        keyframes: `
          20% { transform: rotate(15deg); }
          40% { transform: rotate(-10deg); }
          60% { transform: rotate(5deg); }
          80% { transform: rotate(-5deg); }
          100% { transform: rotate(0deg); }
        `
      },
      typewriter: {
        name: 'Typewriter',
        keyframes: `
          0% { width: 0; }
          100% { width: 100%; }
        `,
        customCSS: `
          overflow: hidden;
          border-right: 2px solid;
          white-space: nowrap;
          margin: 0 auto;
          letter-spacing: 0.1em;
          font-family: 'Courier New', monospace;
        `
      },
      handwriting: {
        name: 'Handwriting',
        keyframes: `
          0% { stroke-dashoffset: 1000; }
          100% { stroke-dashoffset: 0; }
        `,
        customCSS: `
          stroke-dasharray: 1000;
          stroke-linecap: round;
          stroke-linejoin: round;
          fill: none;
        `
      }
    };
  }

  /**
   * Initialize the animation builder
   */
  init() {
    if (this.isInitialized) {
      console.warn('CSS Animation Builder is already initialized');
      return;
    }

    this.container = document.querySelector(this.options.container);
    if (!this.container) {
      throw new Error(`Container element "${this.options.container}" not found`);
    }

    this.render();
    this.bindEvents();
    this.isInitialized = true;

    return this;
  }

  /**
   * Render the animation builder interface
   */
  render() {
    const html = `
      <div class="css-animation-builder theme-${this.options.theme}">
        <div class="cab-header">
          <h2>CSS Animation Builder</h2>
        </div>
        
        <div class="cab-content">
          <div class="cab-controls">
            <div class="cab-section">
              <h3>Animation Type</h3>
              <select id="cab-animation-type" class="cab-select">
                ${this.options.animations.map(anim => `
                  <option value="${anim}">${this.animationKeyframes[anim]?.name || anim}</option>
                `).join('')}
              </select>
            </div>

            <div class="cab-section">
              <h3>Duration</h3>
              <input type="range" id="cab-duration" class="cab-slider" 
                     min="0.1" max="5" step="0.1" value="${this.options.defaults.duration}">
              <span id="cab-duration-value">${this.options.defaults.duration}s</span>
            </div>

            <div class="cab-section">
              <h3>Delay</h3>
              <input type="range" id="cab-delay" class="cab-slider" 
                     min="0" max="3" step="0.1" value="${this.options.defaults.delay}">
              <span id="cab-delay-value">${this.options.defaults.delay}s</span>
            </div>

            <div class="cab-section">
              <h3>Timing Function</h3>
              <select id="cab-timing-function" class="cab-select">
                <option value="ease">Ease</option>
                <option value="ease-in">Ease In</option>
                <option value="ease-out">Ease Out</option>
                <option value="ease-in-out">Ease In Out</option>
                <option value="linear">Linear</option>
                <option value="cubic-bezier(0.25, 0.46, 0.45, 0.94)">Custom Cubic Bezier</option>
              </select>
            </div>

            <div class="cab-section">
              <h3>Iteration Count</h3>
              <input type="number" id="cab-iteration-count" class="cab-input" 
                     min="1" max="100" value="${this.options.defaults.iterationCount}">
            </div>

            <div class="cab-actions">
              <button id="cab-preview-btn" class="cab-btn cab-btn-primary">Preview</button>
              <button id="cab-stop-btn" class="cab-btn cab-btn-secondary">Stop</button>
              <button id="cab-reset-btn" class="cab-btn cab-btn-secondary">Reset</button>
            </div>
          </div>

          ${this.options.showPreview ? `
            <div class="cab-preview">
              <h3>Preview</h3>
              <div class="cab-preview-container">
                <div class="cab-preview-element" id="cab-preview-element">
                  <div class="cab-preview-content">Preview Element</div>
                </div>
              </div>
            </div>
          ` : ''}

          ${this.options.showCode ? `
            <div class="cab-code">
              <h3>Generated CSS</h3>
              <textarea id="cab-css-output" class="cab-textarea" readonly></textarea>
              <button id="cab-copy-btn" class="cab-btn cab-btn-secondary">Copy CSS</button>
            </div>
          ` : ''}
        </div>
      </div>
    `;

    this.container.innerHTML = html;
    this.previewElement = document.getElementById('cab-preview-element');
    this.updateCode();
  }

  /**
   * Bind event listeners
   */
  bindEvents() {
    // Animation type change
    const animationType = document.getElementById('cab-animation-type');
    animationType?.addEventListener('change', (e) => {
      this.currentAnimation.type = e.target.value;
      this.updateCode();
      this.trigger('animationChange', this.currentAnimation);
    });

    // Duration slider
    const durationSlider = document.getElementById('cab-duration');
    const durationValue = document.getElementById('cab-duration-value');
    durationSlider?.addEventListener('input', (e) => {
      this.currentAnimation.duration = parseFloat(e.target.value);
      durationValue.textContent = `${this.currentAnimation.duration}s`;
      this.updateCode();
      this.trigger('animationChange', this.currentAnimation);
    });

    // Delay slider
    const delaySlider = document.getElementById('cab-delay');
    const delayValue = document.getElementById('cab-delay-value');
    delaySlider?.addEventListener('input', (e) => {
      this.currentAnimation.delay = parseFloat(e.target.value);
      delayValue.textContent = `${this.currentAnimation.delay}s`;
      this.updateCode();
      this.trigger('animationChange', this.currentAnimation);
    });

    // Timing function
    const timingFunction = document.getElementById('cab-timing-function');
    timingFunction?.addEventListener('change', (e) => {
      this.currentAnimation.timingFunction = e.target.value;
      this.updateCode();
      this.trigger('animationChange', this.currentAnimation);
    });

    // Iteration count
    const iterationCount = document.getElementById('cab-iteration-count');
    iterationCount?.addEventListener('input', (e) => {
      this.currentAnimation.iterationCount = parseInt(e.target.value);
      this.updateCode();
      this.trigger('animationChange', this.currentAnimation);
    });

    // Preview button
    const previewBtn = document.getElementById('cab-preview-btn');
    previewBtn?.addEventListener('click', () => this.preview());

    // Stop button
    const stopBtn = document.getElementById('cab-stop-btn');
    stopBtn?.addEventListener('click', () => this.stopPreview());

    // Reset button
    const resetBtn = document.getElementById('cab-reset-btn');
    resetBtn?.addEventListener('click', () => this.reset());

    // Copy button
    const copyBtn = document.getElementById('cab-copy-btn');
    copyBtn?.addEventListener('click', () => this.copyCSS());
  }

  /**
   * Update the generated CSS code
   */
  updateCode() {
    const css = this.generateCSS();
    const output = document.getElementById('cab-css-output');
    if (output) {
      output.value = css;
    }
    this.trigger('codeGenerated', css);
  }

  /**
   * Generate CSS code for the current animation
   */
  generateCSS() {
    const type = this.currentAnimation.type || this.options.animations[0];
    const animation = this.animationKeyframes[type];
    
    if (!animation) {
      return '/* Animation not found */';
    }

    const animationRule = `
animation: ${type} ${this.currentAnimation.duration}s ${this.currentAnimation.timingFunction} ${this.currentAnimation.delay}s ${this.currentAnimation.iterationCount === 1 ? '1' : this.currentAnimation.iterationCount} ${this.currentAnimation.direction} ${this.currentAnimation.fillMode};`;

    return `@keyframes ${type} {${animation.keyframes}}

.animated-element {${animationRule}
}`;
  }

  /**
   * Preview the animation
   */
  preview() {
    if (!this.previewElement) return;

    this.stopPreview();
    
    const type = this.currentAnimation.type || this.options.animations[0];
    const css = `
      animation: ${type} ${this.currentAnimation.duration}s ${this.currentAnimation.timingFunction} ${this.currentAnimation.delay}s ${this.currentAnimation.iterationCount === 1 ? '1' : this.currentAnimation.iterationCount} ${this.currentAnimation.direction} ${this.currentAnimation.fillMode};
    `;
    
    // Inject keyframes
    const animation = this.animationKeyframes[type];
    if (animation) {
      this.injectKeyframes(type, animation.keyframes);
    }
    
    this.previewElement.style.cssText = css;
    this.trigger('previewStarted');
    
    // Auto-stop after animation completes
    const totalDuration = (this.currentAnimation.duration + this.currentAnimation.delay) * 1000;
    this.previewTimeout = setTimeout(() => {
      this.stopPreview();
    }, totalDuration);
  }

  /**
   * Stop the preview animation
   */
  stopPreview() {
    if (this.previewElement) {
      this.previewElement.style.animation = 'none';
    }
    if (this.previewTimeout) {
      clearTimeout(this.previewTimeout);
      this.previewTimeout = null;
    }
    this.trigger('previewStopped');
  }

  /**
   * Reset to default values
   */
  reset() {
    this.currentAnimation = { ...this.options.defaults };
    
    // Reset form controls
    const animationType = document.getElementById('cab-animation-type');
    const durationSlider = document.getElementById('cab-duration');
    const durationValue = document.getElementById('cab-duration-value');
    const delaySlider = document.getElementById('cab-delay');
    const delayValue = document.getElementById('cab-delay-value');
    const timingFunction = document.getElementById('cab-timing-function');
    const iterationCount = document.getElementById('cab-iteration-count');
    
    if (animationType) animationType.value = this.options.animations[0];
    if (durationSlider) durationSlider.value = this.options.defaults.duration;
    if (durationValue) durationValue.textContent = `${this.options.defaults.duration}s`;
    if (delaySlider) delaySlider.value = this.options.defaults.delay;
    if (delayValue) delayValue.textContent = `${this.options.defaults.delay}s`;
    if (timingFunction) timingFunction.value = this.options.defaults.timingFunction;
    if (iterationCount) iterationCount.value = this.options.defaults.iterationCount;
    
    this.stopPreview();
    this.updateCode();
  }

  /**
   * Copy CSS to clipboard
   */
  copyCSS() {
    const output = document.getElementById('cab-css-output');
    if (output) {
      output.select();
      document.execCommand('copy');
      
      // Visual feedback
      const copyBtn = document.getElementById('cab-copy-btn');
      if (copyBtn) {
        const originalText = copyBtn.textContent;
        copyBtn.textContent = 'Copied!';
        setTimeout(() => {
          copyBtn.textContent = originalText;
        }, 1000);
      }
    }
  }

  /**
   * Inject keyframes into the document
   */
  injectKeyframes(name, keyframes) {
    // Remove existing keyframes
    const existingStyle = document.getElementById(`cab-keyframes-${name}`);
    if (existingStyle) {
      existingStyle.remove();
    }

    // Add new keyframes
    const style = document.createElement('style');
    style.id = `cab-keyframes-${name}`;
    style.textContent = `@keyframes ${name} {${keyframes}}`;
    document.head.appendChild(style);
  }

  /**
   * Add a custom animation
   */
  addCustomAnimation(name, config) {
    this.animationKeyframes[name] = config;
    this.customAnimations[name] = config;
    return this;
  }

  /**
   * Get current animation settings
   */
  getAnimation() {
    return { ...this.currentAnimation };
  }

  /**
   * Set animation settings
   */
  setAnimation(settings) {
    this.currentAnimation = { ...this.currentAnimation, ...settings };
    this.updateCode();
    return this;
  }

  /**
   * Trigger a callback
   */
  trigger(event, data) {
    const callback = this.options.callbacks[`on${event.charAt(0).toUpperCase() + event.slice(1)}`];
    if (typeof callback === 'function') {
      callback(data);
    }
  }

  /**
   * Destroy the animation builder
   */
  destroy() {
    this.stopPreview();
    if (this.container) {
      this.container.innerHTML = '';
    }
    this.isInitialized = false;
    return this;
  }
}

export default CSSAnimationBuilder;
