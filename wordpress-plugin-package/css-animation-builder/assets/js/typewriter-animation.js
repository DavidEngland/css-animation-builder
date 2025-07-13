/**
 * Typewriter Animation Engine
 * Advanced typewriter effects for CSS Animation Builder
 * Developed by Real Estate Intelligence Agency (REIA)
 * 
 * @author David England <DavidEngland@hotmail.com>
 * @version 1.1.0
 * @license MIT
 */

class TypewriterAnimation {
  constructor(element, options = {}) {
    this.element = typeof element === 'string' ? document.querySelector(element) : element;
    
    if (!this.element) {
      throw new Error('TypewriterAnimation: Element not found');
    }

    this.options = {
      // Basic settings
      speed: 100,              // Milliseconds per character
      deleteSpeed: 50,         // Milliseconds per character when deleting
      pauseTime: 1000,         // Pause between typing sequences
      
      // Cursor settings
      cursor: '|',             // Cursor character
      cursorColor: '#333',     // Cursor color
      cursorBlink: true,       // Enable cursor blinking
      cursorBlinkSpeed: 500,   // Cursor blink interval
      
      // Behavior
      loop: false,             // Loop the animation
      autoStart: true,         // Start automatically
      deleteAll: false,        // Delete all text before next sequence
      preserveMarkup: false,   // Preserve HTML markup
      
      // Advanced effects
      humanize: true,          // Add human-like typing variations
      humanizeVariance: 0.3,   // Speed variance for humanization (0-1)
      mistakes: false,         // Enable typing mistakes
      mistakeChance: 0.05,     // Chance of making mistakes (0-1)
      correctionDelay: 300,    // Delay before correcting mistakes
      
      // Sound effects (if audio files provided)
      sounds: {
        typing: null,          // Audio file for typing sounds
        delete: null,          // Audio file for delete sounds
        bell: null             // Audio file for completion bell
      },
      
      // Callbacks
      onStart: null,
      onComplete: null,
      onCharacterTyped: null,
      onCharacterDeleted: null,
      onPause: null,
      onResume: null,
      
      ...options
    };

    this.textSequences = [];
    this.currentSequence = 0;
    this.currentIndex = 0;
    this.isTyping = false;
    this.isPaused = false;
    this.isDeleting = false;
    this.cursorElement = null;
    this.originalText = this.element.textContent;
    this.timeouts = [];
    
    this.init();
  }

  init() {
    this.setupCursor();
    this.setupSounds();
    
    if (this.options.autoStart && this.originalText) {
      this.type(this.originalText);
    }
  }

  setupCursor() {
    if (this.options.cursor) {
      this.cursorElement = document.createElement('span');
      this.cursorElement.className = 'typewriter-cursor';
      this.cursorElement.textContent = this.options.cursor;
      this.cursorElement.style.color = this.options.cursorColor;
      this.cursorElement.style.fontWeight = 'normal';
      
      if (this.options.cursorBlink) {
        this.cursorElement.style.animation = `typewriter-blink ${this.options.cursorBlinkSpeed}ms infinite`;
        this.addBlinkStyles();
      }
      
      this.element.appendChild(this.cursorElement);
    }
  }

  addBlinkStyles() {
    const styleId = 'typewriter-blink-styles';
    if (!document.getElementById(styleId)) {
      const style = document.createElement('style');
      style.id = styleId;
      style.textContent = `
        @keyframes typewriter-blink {
          0%, 50% { opacity: 1; }
          51%, 100% { opacity: 0; }
        }
      `;
      document.head.appendChild(style);
    }
  }

  setupSounds() {
    this.sounds = {};
    Object.keys(this.options.sounds).forEach(key => {
      if (this.options.sounds[key]) {
        this.sounds[key] = new Audio(this.options.sounds[key]);
        this.sounds[key].preload = 'auto';
      }
    });
  }

  playSound(type) {
    if (this.sounds[type]) {
      this.sounds[type].currentTime = 0;
      this.sounds[type].play().catch(() => {
        // Ignore audio play errors (user interaction required)
      });
    }
  }

  type(text, options = {}) {
    const config = { ...this.options, ...options };
    
    if (Array.isArray(text)) {
      this.textSequences = text;
      this.currentSequence = 0;
      this.startSequence();
    } else {
      this.textSequences = [text];
      this.currentSequence = 0;
      this.startSequence();
    }
    
    return this;
  }

  startSequence() {
    if (this.currentSequence >= this.textSequences.length) {
      if (this.options.loop) {
        this.currentSequence = 0;
      } else {
        this.complete();
        return;
      }
    }

    const text = this.textSequences[this.currentSequence];
    this.currentIndex = 0;
    this.isTyping = true;
    this.isDeleting = false;
    
    this.callCallback('onStart');
    this.typeCharacter(text);
  }

  typeCharacter(text) {
    if (this.isPaused || !this.isTyping) return;

    if (this.currentIndex < text.length) {
      const char = text[this.currentIndex];
      
      // Handle mistakes
      if (this.options.mistakes && Math.random() < this.options.mistakeChance) {
        this.typeMistake(text);
        return;
      }
      
      this.insertCharacter(char);
      this.currentIndex++;
      
      this.callCallback('onCharacterTyped', char);
      this.playSound('typing');
      
      const speed = this.calculateSpeed();
      this.scheduleNext(() => this.typeCharacter(text), speed);
    } else {
      this.completeSequence();
    }
  }

  typeMistake(text) {
    const wrongChar = this.getRandomChar();
    this.insertCharacter(wrongChar);
    
    this.scheduleNext(() => {
      this.deleteCharacter();
      this.scheduleNext(() => this.typeCharacter(text), this.options.deleteSpeed);
    }, this.options.correctionDelay);
  }

  insertCharacter(char) {
    const currentText = this.element.textContent.replace(this.options.cursor, '');
    this.element.textContent = currentText + char;
    
    if (this.cursorElement) {
      this.element.appendChild(this.cursorElement);
    }
  }

  deleteCharacter() {
    const currentText = this.element.textContent.replace(this.options.cursor, '');
    this.element.textContent = currentText.slice(0, -1);
    
    if (this.cursorElement) {
      this.element.appendChild(this.cursorElement);
    }
    
    this.callCallback('onCharacterDeleted');
    this.playSound('delete');
  }

  calculateSpeed() {
    let speed = this.options.speed;
    
    if (this.options.humanize) {
      const variance = this.options.humanizeVariance;
      const randomFactor = 1 + (Math.random() - 0.5) * variance;
      speed *= randomFactor;
    }
    
    return Math.max(speed, 10); // Minimum 10ms
  }

  getRandomChar() {
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return chars[Math.floor(Math.random() * chars.length)];
  }

  completeSequence() {
    this.isTyping = false;
    
    if (this.options.deleteAll && this.currentSequence < this.textSequences.length - 1) {
      this.scheduleNext(() => this.deleteAll(), this.options.pauseTime);
    } else {
      this.scheduleNext(() => this.nextSequence(), this.options.pauseTime);
    }
  }

  deleteAll() {
    this.isDeleting = true;
    const currentText = this.element.textContent.replace(this.options.cursor, '');
    
    if (currentText.length > 0) {
      this.deleteCharacter();
      this.scheduleNext(() => this.deleteAll(), this.options.deleteSpeed);
    } else {
      this.isDeleting = false;
      this.nextSequence();
    }
  }

  nextSequence() {
    this.currentSequence++;
    this.startSequence();
  }

  complete() {
    this.isTyping = false;
    this.callCallback('onComplete');
    this.playSound('bell');
  }

  pause() {
    this.isPaused = true;
    this.clearTimeouts();
    this.callCallback('onPause');
    return this;
  }

  resume() {
    this.isPaused = false;
    this.callCallback('onResume');
    
    if (this.isTyping && this.textSequences.length > 0) {
      const text = this.textSequences[this.currentSequence];
      this.typeCharacter(text);
    }
    
    return this;
  }

  stop() {
    this.isTyping = false;
    this.isPaused = false;
    this.clearTimeouts();
    return this;
  }

  reset() {
    this.stop();
    this.element.textContent = '';
    
    if (this.cursorElement) {
      this.element.appendChild(this.cursorElement);
    }
    
    this.currentSequence = 0;
    this.currentIndex = 0;
    return this;
  }

  destroy() {
    this.stop();
    
    if (this.cursorElement) {
      this.cursorElement.remove();
    }
    
    this.element.textContent = this.originalText;
  }

  scheduleNext(callback, delay) {
    const timeout = setTimeout(callback, delay);
    this.timeouts.push(timeout);
  }

  clearTimeouts() {
    this.timeouts.forEach(timeout => clearTimeout(timeout));
    this.timeouts = [];
  }

  callCallback(name, ...args) {
    if (typeof this.options[name] === 'function') {
      this.options[name](...args);
    }
  }

  // Static method to create CSS keyframes for pure CSS typewriter effect
  static generateCSS(text, options = {}) {
    const config = {
      duration: '3s',
      steps: text.length,
      cursor: true,
      ...options
    };

    const keyframes = `
      @keyframes typewriter-${Date.now()} {
        from { width: 0; }
        to { width: 100%; }
      }
      
      @keyframes blink-caret {
        from, to { border-color: transparent; }
        50% { border-color: currentColor; }
      }
    `;

    const css = `
      .typewriter-text {
        overflow: hidden;
        border-right: ${config.cursor ? '2px solid' : 'none'};
        white-space: nowrap;
        margin: 0 auto;
        letter-spacing: 0.1em;
        animation: 
          typewriter-${Date.now()} ${config.duration} steps(${config.steps}, end),
          ${config.cursor ? `blink-caret 0.75s step-end infinite` : ''};
      }
    `;

    return keyframes + css;
  }
}

// Export for both Node.js and browser environments
if (typeof module !== 'undefined' && module.exports) {
  module.exports = TypewriterAnimation;
} else if (typeof window !== 'undefined') {
  window.TypewriterAnimation = TypewriterAnimation;
}
