/**
 * Handwriting Animation Engine
 * SVG-based handwriting effects for CSS Animation Builder
 * Developed by Real Estate Intelligence Agency (REIA)
 * 
 * @author David England <DavidEngland@hotmail.com>
 * @version 1.1.0
 * @license MIT
 */

class HandwritingAnimation {
  constructor(element, options = {}) {
    this.element = typeof element === 'string' ? document.querySelector(element) : element;
    
    if (!this.element) {
      throw new Error('HandwritingAnimation: Element not found');
    }

    this.options = {
      // Basic settings
      speed: 50,               // Milliseconds per path unit
      strokeWidth: 2,          // SVG stroke width
      strokeColor: '#333',     // SVG stroke color
      
      // Pen settings
      penType: 'fountain',     // fountain, ballpoint, marker, pencil, quill
      inkFlow: true,           // Enable ink flow effects
      inkColor: '#1a1a1a',     // Ink color
      
      // Animation settings
      showPen: true,           // Show animated pen cursor
      penSize: 20,             // Pen cursor size
      showInkTrail: true,      // Show ink trail effect
      trailLength: 10,         // Length of ink trail
      
      // Handwriting style
      style: 'cursive',        // cursive, print, signature
      pressure: 1.0,           // Pressure sensitivity (0-2)
      shakiness: 0.1,          // Natural hand shake (0-1)
      
      // Timing
      pauseBetweenWords: 300,  // Pause between words
      pauseBetweenLines: 800,  // Pause between lines
      
      // Effects
      paperTexture: false,     // Add paper texture background
      inkBlots: false,         // Add random ink blots
      fadeIn: false,           // Fade in the writing
      
      // Callbacks
      onStart: null,
      onComplete: null,
      onWordComplete: null,
      onLineComplete: null,
      
      ...options
    };

    this.svgElement = null;
    this.pathElements = [];
    this.penElement = null;
    this.currentPath = null;
    this.isWriting = false;
    this.isPaused = false;
    this.animationId = null;
    this.paths = [];
    this.currentPathIndex = 0;
    this.currentProgress = 0;
    
    this.init();
  }

  init() {
    this.setupSVG();
    this.setupPenStyles();
    
    if (this.options.paperTexture) {
      this.addPaperTexture();
    }
  }

  setupSVG() {
    // Create SVG container
    this.svgElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    this.svgElement.setAttribute('width', '100%');
    this.svgElement.setAttribute('height', '100%');
    this.svgElement.style.position = 'absolute';
    this.svgElement.style.top = '0';
    this.svgElement.style.left = '0';
    this.svgElement.style.pointerEvents = 'none';
    this.svgElement.style.overflow = 'visible';
    
    // Make container relative if not already
    if (getComputedStyle(this.element).position === 'static') {
      this.element.style.position = 'relative';
    }
    
    this.element.appendChild(this.svgElement);
    
    // Create pen cursor if enabled
    if (this.options.showPen) {
      this.createPenCursor();
    }
  }

  setupPenStyles() {
    const penStyles = {
      fountain: {
        strokeWidth: this.options.strokeWidth,
        strokeLinecap: 'round',
        strokeLinejoin: 'round',
        opacity: 0.9
      },
      ballpoint: {
        strokeWidth: this.options.strokeWidth * 0.8,
        strokeLinecap: 'round',
        strokeLinejoin: 'round',
        opacity: 1
      },
      marker: {
        strokeWidth: this.options.strokeWidth * 2,
        strokeLinecap: 'round',
        strokeLinejoin: 'round',
        opacity: 0.7
      },
      pencil: {
        strokeWidth: this.options.strokeWidth * 0.6,
        strokeLinecap: 'round',
        strokeLinejoin: 'round',
        opacity: 0.8,
        filter: 'blur(0.5px)'
      },
      quill: {
        strokeWidth: this.options.strokeWidth * 1.2,
        strokeLinecap: 'round',
        strokeLinejoin: 'round',
        opacity: 0.85
      }
    };
    
    this.penStyle = penStyles[this.options.penType] || penStyles.fountain;
  }

  createPenCursor() {
    const penGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    penGroup.setAttribute('class', 'pen-cursor');
    
    // Create pen body based on type
    let penPath = '';
    switch (this.options.penType) {
      case 'fountain':
        penPath = 'M0,0 L15,0 L13,3 L2,3 Z M13,3 L15,8 L0,8 L2,3 Z';
        break;
      case 'ballpoint':
        penPath = 'M0,0 L12,0 L12,6 L0,6 Z M10,6 L12,10 L2,10 L0,6 Z';
        break;
      case 'marker':
        penPath = 'M0,0 L8,0 L8,12 L0,12 Z M6,12 L8,15 L2,15 L0,12 Z';
        break;
      case 'pencil':
        penPath = 'M0,0 L4,0 L4,15 L0,15 Z M2,15 L4,18 L0,18 L2,15 Z';
        break;
      case 'quill':
        penPath = 'M0,0 L6,0 L8,3 L8,12 L6,15 L0,15 L2,12 L2,3 Z';
        break;
    }
    
    const penElement = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    penElement.setAttribute('d', penPath);
    penElement.setAttribute('fill', '#8B4513');
    penElement.setAttribute('stroke', '#654321');
    penElement.setAttribute('stroke-width', '0.5');
    penElement.style.transform = 'scale(0.8)';
    
    penGroup.appendChild(penElement);
    this.penElement = penGroup;
    this.svgElement.appendChild(penGroup);
    
    // Initially hide the pen
    this.penElement.style.opacity = '0';
  }

  addPaperTexture() {
    const texture = document.createElement('div');
    texture.className = 'paper-texture';
    texture.style.cssText = `
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: 
        radial-gradient(circle at 20% 50%, rgba(120, 119, 108, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(120, 119, 108, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(120, 119, 108, 0.3) 0%, transparent 50%);
      background-size: 100px 100px, 80px 80px, 120px 120px;
      pointer-events: none;
      z-index: -1;
    `;
    
    this.element.appendChild(texture);
  }

  writeText(text, options = {}) {
    const config = { ...this.options, ...options };
    
    // Clear previous animations
    this.stop();
    this.clearPaths();
    
    // Convert text to SVG paths
    this.generateTextPaths(text, config);
    
    // Start writing animation
    this.startWriting();
    
    return this;
  }

  generateTextPaths(text, config) {
    const words = text.split(' ');
    const lineHeight = 40;
    const letterSpacing = 15;
    const wordSpacing = 25;
    
    let currentX = 20;
    let currentY = 40;
    let maxWidth = this.element.offsetWidth - 40;
    
    words.forEach((word, wordIndex) => {
      const wordWidth = word.length * letterSpacing + wordSpacing;
      
      // Check if word fits on current line
      if (currentX + wordWidth > maxWidth && currentX > 20) {
        currentY += lineHeight;
        currentX = 20;
      }
      
      // Generate path for each character
      for (let i = 0; i < word.length; i++) {
        const char = word[i];
        const charPath = this.generateCharacterPath(char, currentX, currentY, config);
        
        if (charPath) {
          this.paths.push({
            path: charPath,
            x: currentX,
            y: currentY,
            char: char,
            wordIndex: wordIndex
          });
        }
        
        currentX += letterSpacing;
      }
      
      currentX += wordSpacing;
    });
  }

  generateCharacterPath(char, x, y, config) {
    // Simple character path generation
    // In a real implementation, you'd have proper font path data
    const paths = {
      'a': `M${x},${y} Q${x+5},${y-10} ${x+10},${y} Q${x+8},${y+5} ${x+10},${y+10}`,
      'b': `M${x},${y-15} L${x},${y+10} Q${x+5},${y-5} ${x+8},${y} Q${x+5},${y+5} ${x},${y+10}`,
      'c': `M${x+8},${y-5} Q${x},${y-5} ${x},${y} Q${x},${y+5} ${x+8},${y+5}`,
      'd': `M${x+8},${y-15} L${x+8},${y+10} Q${x+3},${y-5} ${x},${y} Q${x+3},${y+5} ${x+8},${y+10}`,
      'e': `M${x},${y} Q${x+8},${y-5} ${x+8},${y} Q${x+8},${y+5} ${x},${y+5}`,
      'f': `M${x+8},${y-15} Q${x+3},${y-15} ${x+3},${y-10} L${x+3},${y+10} M${x},${y-5} L${x+6},${y-5}`,
      'g': `M${x+8},${y-5} Q${x},${y-5} ${x},${y} Q${x},${y+5} ${x+8},${y+5} L${x+8},${y+15} Q${x+3},${y+15} ${x},${y+10}`,
      'h': `M${x},${y-15} L${x},${y+10} M${x},${y-2} Q${x+5},${y-7} ${x+8},${y-2} L${x+8},${y+10}`,
      'i': `M${x+2},${y-15} L${x+2},${y-12} M${x+2},${y-8} L${x+2},${y+10}`,
      'j': `M${x+5},${y-15} L${x+5},${y-12} M${x+5},${y-8} L${x+5},${y+10} Q${x+2},${y+15} ${x-2},${y+10}`,
      'k': `M${x},${y-15} L${x},${y+10} M${x},${y-2} L${x+8},${y-8} M${x+3},${y+2} L${x+8},${y+10}`,
      'l': `M${x+2},${y-15} L${x+2},${y+10}`,
      'm': `M${x},${y-5} L${x},${y+10} M${x},${y-2} Q${x+2},${y-7} ${x+4},${y-2} L${x+4},${y+10} M${x+4},${y-2} Q${x+6},${y-7} ${x+8},${y-2} L${x+8},${y+10}`,
      'n': `M${x},${y-5} L${x},${y+10} M${x},${y-2} Q${x+3},${y-7} ${x+6},${y-2} L${x+6},${y+10}`,
      'o': `M${x},${y} Q${x},${y-5} ${x+4},${y-5} Q${x+8},${y-5} ${x+8},${y} Q${x+8},${y+5} ${x+4},${y+5} Q${x},${y+5} ${x},${y}`,
      'p': `M${x},${y-5} L${x},${y+15} M${x},${y-5} Q${x+5},${y-5} ${x+8},${y-2} Q${x+5},${y+2} ${x},${y+2}`,
      'q': `M${x+6},${y-5} L${x+6},${y+15} M${x+6},${y-5} Q${x+3},${y-5} ${x},${y-2} Q${x+3},${y+2} ${x+6},${y+2}`,
      'r': `M${x},${y-5} L${x},${y+10} M${x},${y-2} Q${x+3},${y-7} ${x+6},${y-2}`,
      's': `M${x+6},${y-5} Q${x},${y-5} ${x},${y-2} Q${x+3},${y} ${x+6},${y+2} Q${x+6},${y+5} ${x},${y+5}`,
      't': `M${x+3},${y-10} L${x+3},${y+8} Q${x+3},${y+10} ${x+6},${y+10} M${x},${y-5} L${x+6},${y-5}`,
      'u': `M${x},${y-5} L${x},${y+3} Q${x},${y+8} ${x+6},${y+8} L${x+6},${y-5}`,
      'v': `M${x},${y-5} L${x+4},${y+8} L${x+8},${y-5}`,
      'w': `M${x},${y-5} L${x+2},${y+8} L${x+4},${y+2} L${x+6},${y+8} L${x+8},${y-5}`,
      'x': `M${x},${y-5} L${x+8},${y+8} M${x+8},${y-5} L${x},${y+8}`,
      'y': `M${x},${y-5} L${x+4},${y+2} L${x+8},${y-5} L${x+4},${y+2} L${x+4},${y+15}`,
      'z': `M${x},${y-5} L${x+8},${y-5} L${x},${y+8} L${x+8},${y+8}`,
      ' ': null
    };
    
    return paths[char.toLowerCase()] || null;
  }

  startWriting() {
    if (this.paths.length === 0) return;
    
    this.isWriting = true;
    this.currentPathIndex = 0;
    this.currentProgress = 0;
    
    this.callCallback('onStart');
    
    if (this.penElement) {
      this.penElement.style.opacity = '1';
    }
    
    this.animateNextPath();
  }

  animateNextPath() {
    if (!this.isWriting || this.isPaused) return;
    
    if (this.currentPathIndex >= this.paths.length) {
      this.completeWriting();
      return;
    }
    
    const pathData = this.paths[this.currentPathIndex];
    
    if (!pathData.path) {
      // Handle spaces
      this.currentPathIndex++;
      setTimeout(() => this.animateNextPath(), this.options.pauseBetweenWords);
      return;
    }
    
    this.animatePath(pathData);
  }

  animatePath(pathData) {
    const pathElement = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    pathElement.setAttribute('d', pathData.path);
    pathElement.setAttribute('fill', 'none');
    pathElement.setAttribute('stroke', this.options.strokeColor);
    pathElement.setAttribute('stroke-width', this.penStyle.strokeWidth);
    pathElement.setAttribute('stroke-linecap', this.penStyle.strokeLinecap);
    pathElement.setAttribute('stroke-linejoin', this.penStyle.strokeLinejoin);
    pathElement.style.opacity = this.penStyle.opacity;
    
    if (this.penStyle.filter) {
      pathElement.style.filter = this.penStyle.filter;
    }
    
    // Add shakiness effect
    if (this.options.shakiness > 0) {
      const shake = this.options.shakiness * 2;
      const transform = `translate(${(Math.random() - 0.5) * shake}px, ${(Math.random() - 0.5) * shake}px)`;
      pathElement.style.transform = transform;
    }
    
    this.svgElement.appendChild(pathElement);
    this.pathElements.push(pathElement);
    
    const pathLength = pathElement.getTotalLength();
    pathElement.style.strokeDasharray = pathLength;
    pathElement.style.strokeDashoffset = pathLength;
    
    // Animate the path
    const startTime = Date.now();
    const duration = pathLength * this.options.speed;
    
    const animateFrame = () => {
      if (!this.isWriting || this.isPaused) return;
      
      const elapsed = Date.now() - startTime;
      const progress = Math.min(elapsed / duration, 1);
      
      const currentOffset = pathLength * (1 - progress);
      pathElement.style.strokeDashoffset = currentOffset;
      
      // Update pen position
      if (this.penElement && progress < 1) {
        const point = pathElement.getPointAtLength(pathLength * progress);
        this.penElement.style.transform = `translate(${point.x}px, ${point.y}px)`;
      }
      
      if (progress < 1) {
        requestAnimationFrame(animateFrame);
      } else {
        this.callCallback('onCharacterComplete', pathData.char);
        this.currentPathIndex++;
        
        setTimeout(() => this.animateNextPath(), 50);
      }
    };
    
    requestAnimationFrame(animateFrame);
  }

  completeWriting() {
    this.isWriting = false;
    
    if (this.penElement) {
      this.penElement.style.opacity = '0';
    }
    
    this.callCallback('onComplete');
  }

  pause() {
    this.isPaused = true;
    return this;
  }

  resume() {
    this.isPaused = false;
    if (this.isWriting) {
      this.animateNextPath();
    }
    return this;
  }

  stop() {
    this.isWriting = false;
    this.isPaused = false;
    
    if (this.animationId) {
      cancelAnimationFrame(this.animationId);
      this.animationId = null;
    }
    
    return this;
  }

  reset() {
    this.stop();
    this.clearPaths();
    this.currentPathIndex = 0;
    this.currentProgress = 0;
    return this;
  }

  clearPaths() {
    this.pathElements.forEach(element => element.remove());
    this.pathElements = [];
    this.paths = [];
  }

  destroy() {
    this.stop();
    this.clearPaths();
    
    if (this.svgElement) {
      this.svgElement.remove();
    }
  }

  callCallback(name, ...args) {
    if (typeof this.options[name] === 'function') {
      this.options[name](...args);
    }
  }

  // Static method to create handwriting CSS animation
  static generateCSS(options = {}) {
    const config = {
      duration: '5s',
      strokeColor: '#333',
      strokeWidth: 2,
      ...options
    };

    return `
      @keyframes handwriting-draw {
        0% { stroke-dashoffset: 1000; }
        100% { stroke-dashoffset: 0; }
      }
      
      .handwriting-path {
        stroke: ${config.strokeColor};
        stroke-width: ${config.strokeWidth};
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
        stroke-dasharray: 1000;
        animation: handwriting-draw ${config.duration} ease-in-out forwards;
      }
      
      .handwriting-container {
        position: relative;
        overflow: hidden;
      }
      
      .handwriting-svg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
      }
    `;
  }
}

// Export for both Node.js and browser environments
if (typeof module !== 'undefined' && module.exports) {
  module.exports = HandwritingAnimation;
} else if (typeof window !== 'undefined') {
  window.HandwritingAnimation = HandwritingAnimation;
}
