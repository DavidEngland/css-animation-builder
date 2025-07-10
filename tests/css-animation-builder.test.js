import CSSAnimationBuilder from '../assets/js/css-animation-builder.js';

describe('CSSAnimationBuilder', () => {
  let container;
  let builder;

  beforeEach(() => {
    container = createMockContainer();
    builder = new CSSAnimationBuilder({
      container: '#test-container'
    });
  });

  afterEach(() => {
    if (builder) {
      builder.destroy();
    }
    if (container && container.parentNode) {
      container.parentNode.removeChild(container);
    }
  });

  describe('Initialization', () => {
    test('should create instance with default options', () => {
      expect(builder).toBeInstanceOf(CSSAnimationBuilder);
      expect(builder.options.container).toBe('#test-container');
      expect(builder.options.theme).toBe('default');
    });

    test('should initialize with custom options', () => {
      const customBuilder = new CSSAnimationBuilder({
        container: '#custom-container',
        theme: 'dark',
        showPreview: false
      });

      expect(customBuilder.options.theme).toBe('dark');
      expect(customBuilder.options.showPreview).toBe(false);
    });

    test('should throw error if container not found', () => {
      const invalidBuilder = new CSSAnimationBuilder({
        container: '#non-existent'
      });

      expect(() => {
        invalidBuilder.init();
      }).toThrow('Container element "#non-existent" not found');
    });
  });

  describe('Animation Management', () => {
    beforeEach(() => {
      builder.init();
    });

    test('should get current animation settings', () => {
      const animation = builder.getAnimation();
      expect(animation).toHaveProperty('duration');
      expect(animation).toHaveProperty('delay');
      expect(animation).toHaveProperty('timingFunction');
    });

    test('should set animation settings', () => {
      builder.setAnimation({
        duration: 2.0,
        delay: 0.5,
        timingFunction: 'ease-in'
      });

      const animation = builder.getAnimation();
      expect(animation.duration).toBe(2.0);
      expect(animation.delay).toBe(0.5);
      expect(animation.timingFunction).toBe('ease-in');
    });

    test('should add custom animation', () => {
      const customAnimation = {
        name: 'Custom Test',
        keyframes: '0% { opacity: 0; } 100% { opacity: 1; }'
      };

      builder.addCustomAnimation('customTest', customAnimation);
      expect(builder.animationKeyframes.customTest).toEqual(customAnimation);
    });
  });

  describe('CSS Generation', () => {
    beforeEach(() => {
      builder.init();
    });

    test('should generate CSS for default animation', () => {
      const css = builder.generateCSS();
      expect(css).toContain('@keyframes');
      expect(css).toContain('animation:');
      expect(css).toContain('.animated-element');
    });

    test('should generate CSS with custom settings', () => {
      builder.setAnimation({
        duration: 2.0,
        delay: 0.5,
        timingFunction: 'ease-in-out'
      });

      const css = builder.generateCSS();
      expect(css).toContain('2s');
      expect(css).toContain('0.5s');
      expect(css).toContain('ease-in-out');
    });
  });

  describe('Preview Functionality', () => {
    beforeEach(() => {
      builder.init();
    });

    test('should start preview', () => {
      const mockCallback = jest.fn();
      builder.options.callbacks.onPreviewStarted = mockCallback;
      
      builder.preview();
      expect(mockCallback).toHaveBeenCalled();
    });

    test('should stop preview', () => {
      const mockCallback = jest.fn();
      builder.options.callbacks.onPreviewStopped = mockCallback;
      
      builder.preview();
      builder.stopPreview();
      expect(mockCallback).toHaveBeenCalled();
    });
  });

  describe('Event Handling', () => {
    beforeEach(() => {
      builder.init();
    });

    test('should trigger animation change callback', () => {
      const mockCallback = jest.fn();
      builder.options.callbacks.onAnimationChange = mockCallback;
      
      builder.setAnimation({ duration: 3.0 });
      expect(mockCallback).toHaveBeenCalledWith(
        expect.objectContaining({ duration: 3.0 })
      );
    });

    test('should trigger code generated callback', () => {
      const mockCallback = jest.fn();
      builder.options.callbacks.onCodeGenerated = mockCallback;
      
      builder.updateCode();
      expect(mockCallback).toHaveBeenCalledWith(expect.any(String));
    });
  });

  describe('Cleanup', () => {
    test('should destroy instance properly', () => {
      builder.init();
      expect(builder.isInitialized).toBe(true);
      
      builder.destroy();
      expect(builder.isInitialized).toBe(false);
      expect(container.innerHTML).toBe('');
    });
  });
});
