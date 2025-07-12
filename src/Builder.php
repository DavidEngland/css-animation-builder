<?php

namespace Reia\CSSAnimationBuilder;

/**
 * CSS Animation Builder - Core Builder Class
 * 
 * A framework-agnostic CSS animation builder that generates interactive
 * HTML interfaces for creating CSS animations.
 * Developed by Real Estate Intelligence Agency (REIA)
 * 
 * @package Reia\CSSAnimationBuilder
 * @version 1.2.0
 * @author David England <DavidEngland@hotmail.com>
 * @license MIT
 */
class Builder
{
    /**
     * Configuration options
     * 
     * @var array
     */
    private $config;

    /**
     * Available animation types
     * 
     * @var array
     */
    private $animations;

    /**
     * Custom animations
     * 
     * @var array
     */
    private $customAnimations = [];

    /**
     * Animation presets
     * 
     * @var array
     */
    private $presets = [];

    /**
     * Default configuration
     * 
     * @var array
     */
    private static $defaultConfig = [
        'theme' => 'default',
        'showPreview' => true,
        'showCode' => true,
        'showPresets' => true,
        'showAdvanced' => true,
        'cssPrefix' => 'animated-',
        'animations' => [
            'fadeIn', 'fadeOut', 'slideInLeft', 'slideInRight', 
            'slideInUp', 'slideInDown', 'zoomIn', 'zoomOut',
            'bounceIn', 'rotateIn', 'pulse', 'shake', 'wobble', 'swing',
            'typewriter', 'handwriting', 'drawLine', 'writeText', 'signatureDraw'
        ],
        'defaults' => [
            'duration' => 1.0,
            'delay' => 0.0,
            'timingFunction' => 'ease',
            'iterationCount' => 1,
            'direction' => 'normal',
            'fillMode' => 'none',
            'transformOrigin' => 'center'
        ],
        'presets' => [
            'attention' => ['type' => 'pulse', 'duration' => 1, 'count' => 'infinite'],
            'bounce' => ['type' => 'bounceIn', 'duration' => 1.2, 'timing' => 'cubic-bezier(0.68, -0.55, 0.265, 1.55)'],
            'elegant' => ['type' => 'fadeIn', 'duration' => 2, 'delay' => 0.5, 'timing' => 'ease-out'],
            'slide' => ['type' => 'slideInLeft', 'duration' => 0.8, 'delay' => 0.2],
            'zoom' => ['type' => 'zoomIn', 'duration' => 0.6, 'timing' => 'ease-out'],
            'rotate' => ['type' => 'rotateIn', 'duration' => 1, 'timing' => 'ease-in-out'],
            'typewriter' => ['type' => 'typewriter', 'duration' => 3, 'timing' => 'steps(30, end)'],
            'handwriting' => ['type' => 'handwriting', 'duration' => 2.5, 'timing' => 'ease-in-out'],
            'signature' => ['type' => 'signatureDraw', 'duration' => 4, 'timing' => 'ease-in-out'],
            'reveal' => ['type' => 'writeText', 'duration' => 2, 'timing' => 'ease-out']
        ]
    ];

    /**
     * Constructor
     * 
     * @param array $config Configuration options
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge(self::$defaultConfig, $config);
        $this->animations = $this->config['animations'];
        $this->presets = $this->config['presets'];
        $this->initializeCustomAnimations();
    }

    /**
     * Initialize custom animations
     * 
     * @return void
     */
    private function initializeCustomAnimations()
    {
        if (isset($this->config['customAnimations'])) {
            foreach ($this->config['customAnimations'] as $name => $animation) {
                $this->addCustomAnimation($name, $animation);
            }
        }
    }

    /**
     * Add a custom animation
     * 
     * @param string $name Animation name
     * @param array $animation Animation configuration
     * @return self
     */
    public function addCustomAnimation(string $name, array $animation): self
    {
        $this->customAnimations[$name] = array_merge([
            'name' => ucfirst($name),
            'keyframes' => '',
            'defaultDuration' => 1.0,
            'defaultTiming' => 'ease'
        ], $animation);
        
        if (!in_array($name, $this->animations)) {
            $this->animations[] = $name;
        }
        
        return $this;
    }

    /**
     * Get available animations
     * 
     * @return array
     */
    public function getAnimations(): array
    {
        return $this->animations;
    }

    /**
     * Get custom animations
     * 
     * @return array
     */
    public function getCustomAnimations(): array
    {
        return $this->customAnimations;
    }

    /**
     * Get animation presets
     * 
     * @return array
     */
    public function getPresets(): array
    {
        return $this->presets;
    }

    /**
     * Add animation preset
     * 
     * @param string $name Preset name
     * @param array $preset Preset configuration
     * @return self
     */
    public function addPreset(string $name, array $preset): self
    {
        $this->presets[$name] = $preset;
        return $this;
    }

    /**
     * Set theme
     * 
     * @param string $theme Theme name
     * @return self
     */
    public function setTheme(string $theme): self
    {
        $this->config['theme'] = $theme;
        return $this;
    }

    /**
     * Generate CSS for a specific animation
     * 
     * @param string $animation Animation type
     * @param array $options Animation options
     * @return string Generated CSS
     */
    public function generateCSS(string $animation, array $options = []): string
    {
        $options = array_merge($this->config['defaults'], $options);
        $className = $this->config['cssPrefix'] . strtolower($animation);
        
        $css = "/* Generated CSS Animation */\n";
        $css .= ".{$className} {\n";
        $css .= "    animation-name: {$animation};\n";
        $css .= "    animation-duration: {$options['duration']}s;\n";
        $css .= "    animation-delay: {$options['delay']}s;\n";
        $css .= "    animation-timing-function: {$options['timingFunction']};\n";
        $css .= "    animation-iteration-count: {$options['iterationCount']};\n";
        $css .= "    animation-direction: {$options['direction']};\n";
        $css .= "    animation-fill-mode: {$options['fillMode']};\n";
        $css .= "    transform-origin: {$options['transformOrigin']};\n";
        
        // Add specific styles for typewriter and handwriting animations
        if ($animation === 'typewriter') {
            $css .= "    overflow: hidden;\n";
            $css .= "    white-space: nowrap;\n";
            $css .= "    border-right: var(--border-width-medium) solid;\n";
            $css .= "    font-family: 'Courier New', monospace;\n";
        } elseif (in_array($animation, ['handwriting', 'drawLine', 'signatureDraw'])) {
            $css .= "    font-family: 'Caveat', 'Dancing Script', cursive;\n";
            $css .= "    position: relative;\n";
            if ($animation === 'handwriting') {
                $css .= "    transform: rotate(-1deg);\n";
                $css .= "    letter-spacing: 0.02em;\n";
            }
        } elseif ($animation === 'writeText') {
            $css .= "    overflow: hidden;\n";
            $css .= "    white-space: nowrap;\n";
            $css .= "    font-family: 'Caveat', 'Dancing Script', cursive;\n";
            $css .= "    position: relative;\n";
        }
        
        $css .= "}\n\n";
        
        // Add cursor animation for typewriter
        if ($animation === 'typewriter') {
            $css .= ".{$className}::after {\n";
            $css .= "    content: '';\n";
            $css .= "    animation: typewriter-cursor var(--duration-slow) infinite;\n";
            $css .= "}\n\n";
            
            $css .= "@keyframes typewriter-cursor {\n";
            $css .= "    0%, 50% { border-right-color: transparent; }\n";
            $css .= "    51%, var(--element-width-full) { border-right-color: currentColor; }\n";
            $css .= "}\n\n";
        }
        
        // Add underline effect for handwriting
        if ($animation === 'handwriting') {
            $css .= ".{$className}::after {\n";
            $css .= "    content: '';\n";
            $css .= "    position: absolute;\n";
            $css .= "    bottom: -var(--transform-translate-xs);\n";
            $css .= "    left: var(--spacing-sm);\n";
            $css .= "    right: var(--spacing-sm);\n";
            $css .= "    height: var(--element-height-divider);\n";
            $css .= "    background: linear-gradient(90deg, transparent, currentColor, transparent);\n";
            $css .= "    border-radius: var(--border-width-medium);\n";
            $css .= "    opacity: var(--opacity-transparent).7;\n";
            $css .= "    animation: handwriting-underline {$options['duration']}s {$options['delay']}s {$options['timingFunction']} {$options['iterationCount']};\n";
            $css .= "}\n\n";
            
            $css .= "@keyframes handwriting-underline {\n";
            $css .= "    0% { width: 0; left: 50%; }\n";
            $css .= "    var(--element-width-full) { width: var(--element-width-80); left: var(--spacing-sm); }\n";
            $css .= "}\n\n";
        }
        
        $css .= "/* Keyframes for {$animation} */\n";
        $css .= $this->getKeyframes($animation);
        
        return $css;
    }

    /**
     * Get keyframes for an animation
     * 
     * @param string $animation Animation type
     * @return string Keyframes CSS
     */
    private function getKeyframes(string $animation): string
    {
        // Check if it's a custom animation
        if (isset($this->customAnimations[$animation])) {
            return "@keyframes {$animation} {\n    " . 
                   str_replace("\n", "\n    ", trim($this->customAnimations[$animation]['keyframes'])) . 
                   "\n}";
        }

        // Load keyframes from file
        $keyframeFile = __DIR__ . "/Keyframes/{$animation}.css";
        
        if (file_exists($keyframeFile)) {
            $keyframeContent = file_get_contents($keyframeFile);
            $keyframeContent = str_replace("\n", "\n    ", trim($keyframeContent));
            return "@keyframes {$animation} {\n    {$keyframeContent}\n}";
        }

        // Fallback for unknown animations
        return "@keyframes {$animation} {\n    0% { opacity: var(--opacity-transparent); }\n    var(--element-width-full) { opacity: var(--opacity-opaque); }\n}";
    }

    /**
     * Generate HTML example
     * 
     * @param string $animation Animation type
     * @param array $options Animation options
     * @return string Generated HTML
     */
    public function generateHTML(string $animation, array $options = []): string
    {
        $className = $this->config['cssPrefix'] . strtolower($animation);
        
        $html = "<!-- HTML Example -->\n";
        $html .= "<div class=\"{$className}\">\n";
        
        // Customize content based on animation type
        if ($animation === 'typewriter') {
            $html .= "    <h2>Hello, I'm a typewriter!</h2>\n";
            $html .= "    <p>This text will appear character by character...</p>\n";
        } elseif (in_array($animation, ['handwriting', 'writeText'])) {
            $html .= "    <h2>Beautiful Handwriting</h2>\n";
            $html .= "    <p>This text has an elegant, handwritten feel with smooth animations.</p>\n";
        } elseif ($animation === 'signatureDraw') {
            $html .= "    <h2>My Signature</h2>\n";
            $html .= "    <p>Watch as this signature draws itself smoothly.</p>\n";
        } elseif ($animation === 'drawLine') {
            $html .= "    <h2>Drawing Lines</h2>\n";
            $html .= "    <p>Perfect for underlines and decorative elements.</p>\n";
        } else {
            $html .= "    <h2>Your Animated Content</h2>\n";
            $html .= "    <p>This element will animate when the page loads.</p>\n";
        }
        
        $html .= "</div>";
        
        return $html;
    }

    /**
     * Render the complete animation builder interface
     * 
     * @return string Complete HTML interface
     */
    public function render(): string
    {
        $html = $this->renderStyles();
        $html .= $this->renderHTML();
        $html .= $this->renderScript();
        
        return $html;
    }

    /**
     * Render only the HTML structure
     * 
     * @return string HTML structure
     */
    public function renderHTML(): string
    {
        $containerId = 'css-animation-builder-' . uniqid();
        $theme = $this->config['theme'];
        
        $html = "<div id=\"{$containerId}\" class=\"css-animation-builder theme-{$theme}\">\n";
        $html .= "    <div class=\"builder-container\">\n";
        $html .= "        <header class=\"builder-header\">\n";
        $html .= "            <h1>CSS Animation Builder</h1>\n";
        $html .= "            <p>Create beautiful CSS animations with our interactive builder.</p>\n";
        $html .= "        </header>\n\n";
        
        $html .= "        <div class=\"builder-wrapper\">\n";
        $html .= "            <!-- Animation Controls -->\n";
        $html .= "            <div class=\"animation-controls\">\n";
        $html .= $this->renderControlTabs();
        $html .= $this->renderBasicControls();
        
        if ($this->config['showAdvanced']) {
            $html .= $this->renderAdvancedControls();
        }
        
        if ($this->config['showPresets']) {
            $html .= $this->renderPresetControls();
        }
        
        $html .= "                <div class=\"action-buttons\">\n";
        $html .= "                    <button id=\"preview-animation\" class=\"button primary\">Preview Animation</button>\n";
        $html .= "                    <button id=\"generate-css\" class=\"button secondary\">Generate CSS</button>\n";
        $html .= "                    <button id=\"reset-controls\" class=\"button\">Reset</button>\n";
        $html .= "                </div>\n";
        $html .= "            </div>\n\n";
        
        if ($this->config['showPreview']) {
            $html .= $this->renderPreviewArea();
        }
        
        if ($this->config['showCode']) {
            $html .= $this->renderCodeOutput();
        }
        
        $html .= "        </div>\n";
        $html .= "    </div>\n";
        $html .= "</div>\n";
        
        return $html;
    }

    /**
     * Render control tabs
     * 
     * @return string HTML for control tabs
     */
    private function renderControlTabs(): string
    {
        $html = "                <div class=\"control-tabs\">\n";
        $html .= "                    <button class=\"tab-button active\" data-tab=\"basic\">Basic</button>\n";
        
        if ($this->config['showAdvanced']) {
            $html .= "                    <button class=\"tab-button\" data-tab=\"advanced\">Advanced</button>\n";
        }
        
        if ($this->config['showPresets']) {
            $html .= "                    <button class=\"tab-button\" data-tab=\"presets\">Presets</button>\n";
        }
        
        $html .= "                </div>\n\n";
        
        return $html;
    }

    /**
     * Render basic controls
     * 
     * @return string HTML for basic controls
     */
    private function renderBasicControls(): string
    {
        $html = "                <div class=\"tab-content active\" id=\"basic-tab\">\n";
        
        // Animation Type Select
        $html .= "                    <div class=\"control-group\">\n";
        $html .= "                        <label for=\"animation-type\">Animation Type:</label>\n";
        $html .= "                        <select id=\"animation-type\">\n";
        
        foreach ($this->animations as $animation) {
            $name = isset($this->customAnimations[$animation]) 
                ? $this->customAnimations[$animation]['name'] 
                : ucfirst($animation);
            $html .= "                            <option value=\"{$animation}\">{$name}</option>\n";
        }
        
        $html .= "                        </select>\n";
        $html .= "                    </div>\n\n";
        
        // Duration Control
        $html .= "                    <div class=\"control-group\">\n";
        $html .= "                        <label for=\"duration\">Duration (seconds):</label>\n";
        $html .= "                        <input type=\"range\" id=\"duration\" min=\"0.1\" max=\"5\" step=\"0.1\" value=\"{$this->config['defaults']['duration']}\">\n";
        $html .= "                        <span class=\"value-display\" id=\"duration-value\">{$this->config['defaults']['duration']}s</span>\n";
        $html .= "                    </div>\n\n";
        
        // Delay Control
        $html .= "                    <div class=\"control-group\">\n";
        $html .= "                        <label for=\"delay\">Delay (seconds):</label>\n";
        $html .= "                        <input type=\"range\" id=\"delay\" min=\"0\" max=\"3\" step=\"0.1\" value=\"{$this->config['defaults']['delay']}\">\n";
        $html .= "                        <span class=\"value-display\" id=\"delay-value\">{$this->config['defaults']['delay']}s</span>\n";
        $html .= "                    </div>\n\n";
        
        // Timing Function
        $html .= "                    <div class=\"control-group\">\n";
        $html .= "                        <label for=\"timing-function\">Timing Function:</label>\n";
        $html .= "                        <select id=\"timing-function\">\n";
        $html .= "                            <option value=\"ease\">Ease</option>\n";
        $html .= "                            <option value=\"ease-in\">Ease In</option>\n";
        $html .= "                            <option value=\"ease-out\">Ease Out</option>\n";
        $html .= "                            <option value=\"ease-in-out\">Ease In Out</option>\n";
        $html .= "                            <option value=\"linear\">Linear</option>\n";
        $html .= "                            <option value=\"cubic-bezier(0.25, 0.1, 0.25, 1)\">Smooth</option>\n";
        $html .= "                            <option value=\"cubic-bezier(0.68, -0.55, 0.265, 1.55)\">Bounce</option>\n";
        $html .= "                        </select>\n";
        $html .= "                    </div>\n\n";
        
        // Iteration Count
        $html .= "                    <div class=\"control-group\">\n";
        $html .= "                        <label for=\"iteration-count\">Repeat:</label>\n";
        $html .= "                        <select id=\"iteration-count\">\n";
        $html .= "                            <option value=\"1\">Once</option>\n";
        $html .= "                            <option value=\"2\">Twice</option>\n";
        $html .= "                            <option value=\"3\">3 times</option>\n";
        $html .= "                            <option value=\"infinite\">Infinite</option>\n";
        $html .= "                        </select>\n";
        $html .= "                    </div>\n";
        
        $html .= "                </div>\n\n";
        
        return $html;
    }

    /**
     * Render advanced controls
     * 
     * @return string HTML for advanced controls
     */
    private function renderAdvancedControls(): string
    {
        $html = "                <div class=\"tab-content\" id=\"advanced-tab\">\n";
        
        // Transform Origin
        $html .= "                    <div class=\"control-group\">\n";
        $html .= "                        <label for=\"transform-origin\">Transform Origin:</label>\n";
        $html .= "                        <select id=\"transform-origin\">\n";
        $html .= "                            <option value=\"center\">Center</option>\n";
        $html .= "                            <option value=\"top\">Top</option>\n";
        $html .= "                            <option value=\"bottom\">Bottom</option>\n";
        $html .= "                            <option value=\"left\">Left</option>\n";
        $html .= "                            <option value=\"right\">Right</option>\n";
        $html .= "                            <option value=\"top left\">Top Left</option>\n";
        $html .= "                            <option value=\"top right\">Top Right</option>\n";
        $html .= "                            <option value=\"bottom left\">Bottom Left</option>\n";
        $html .= "                            <option value=\"bottom right\">Bottom Right</option>\n";
        $html .= "                        </select>\n";
        $html .= "                    </div>\n\n";
        
        // Direction
        $html .= "                    <div class=\"control-group\">\n";
        $html .= "                        <label for=\"direction\">Direction:</label>\n";
        $html .= "                        <select id=\"direction\">\n";
        $html .= "                            <option value=\"normal\">Normal</option>\n";
        $html .= "                            <option value=\"reverse\">Reverse</option>\n";
        $html .= "                            <option value=\"alternate\">Alternate</option>\n";
        $html .= "                            <option value=\"alternate-reverse\">Alternate Reverse</option>\n";
        $html .= "                        </select>\n";
        $html .= "                    </div>\n\n";
        
        // Fill Mode
        $html .= "                    <div class=\"control-group\">\n";
        $html .= "                        <label for=\"fill-mode\">Fill Mode:</label>\n";
        $html .= "                        <select id=\"fill-mode\">\n";
        $html .= "                            <option value=\"none\">None</option>\n";
        $html .= "                            <option value=\"forwards\">Forwards</option>\n";
        $html .= "                            <option value=\"backwards\">Backwards</option>\n";
        $html .= "                            <option value=\"both\">Both</option>\n";
        $html .= "                        </select>\n";
        $html .= "                    </div>\n";
        
        $html .= "                </div>\n\n";
        
        return $html;
    }

    /**
     * Render preset controls
     * 
     * @return string HTML for preset controls
     */
    private function renderPresetControls(): string
    {
        $html = "                <div class=\"tab-content\" id=\"presets-tab\">\n";
        $html .= "                    <div class=\"preset-grid\">\n";
        
        foreach ($this->config['presets'] as $key => $preset) {
            $name = ucfirst($key);
            $html .= "                        <button class=\"preset-button\" data-preset=\"{$key}\">{$name}</button>\n";
        }
        
        $html .= "                    </div>\n";
        $html .= "                </div>\n\n";
        
        return $html;
    }

    /**
     * Render preview area
     * 
     * @return string HTML for preview area
     */
    private function renderPreviewArea(): string
    {
        $html = "            <div class=\"preview-area\">\n";
        $html .= "                <h3>Live Preview</h3>\n";
        $html .= "                <div class=\"preview-container\">\n";
        $html .= "                    <div class=\"preview-element\" id=\"preview-element\">\n";
        $html .= "                        <div class=\"preview-content\">\n";
        $html .= "                            <h4>Your Animation</h4>\n";
        $html .= "                            <p>This element will animate based on your settings.</p>\n";
        $html .= "                        </div>\n";
        $html .= "                    </div>\n";
        $html .= "                </div>\n";
        $html .= "                <div class=\"preview-controls\">\n";
        $html .= "                    <button id=\"play-preview\" class=\"button\">Play</button>\n";
        $html .= "                    <button id=\"pause-preview\" class=\"button\">Pause</button>\n";
        $html .= "                    <button id=\"restart-preview\" class=\"button\">Restart</button>\n";
        $html .= "                </div>\n";
        $html .= "            </div>\n\n";
        
        return $html;
    }

    /**
     * Render code output area
     * 
     * @return string HTML for code output
     */
    private function renderCodeOutput(): string
    {
        $html = "            <div class=\"css-output\">\n";
        $html .= "                <h3>Generated CSS</h3>\n";
        $html .= "                <div class=\"output-tabs\">\n";
        $html .= "                    <button class=\"output-tab active\" data-output=\"css\">CSS</button>\n";
        $html .= "                    <button class=\"output-tab\" data-output=\"html\">HTML</button>\n";
        $html .= "                    <button class=\"output-tab\" data-output=\"usage\">Usage</button>\n";
        $html .= "                </div>\n\n";
        
        $html .= "                <div class=\"output-content active\" id=\"css-output\">\n";
        $html .= "                    <pre><code id=\"css-code\">/* Your generated CSS will appear here */</code></pre>\n";
        $html .= "                    <button id=\"copy-css\" class=\"copy-button\">Copy CSS</button>\n";
        $html .= "                </div>\n\n";
        
        $html .= "                <div class=\"output-content\" id=\"html-output\">\n";
        $html .= "                    <pre><code id=\"html-code\"><!-- Your HTML example will appear here --></code></pre>\n";
        $html .= "                    <button id=\"copy-html\" class=\"copy-button\">Copy HTML</button>\n";
        $html .= "                </div>\n\n";
        
        $html .= "                <div class=\"output-content\" id=\"usage-output\">\n";
        $html .= "                    <div class=\"usage-instructions\">\n";
        $html .= "                        <h4>How to Use Your Animation</h4>\n";
        $html .= "                        <ol>\n";
        $html .= "                            <li>Copy the generated CSS code</li>\n";
        $html .= "                            <li>Add it to your stylesheet</li>\n";
        $html .= "                            <li>Apply the class to your HTML element</li>\n";
        $html .= "                            <li>The animation will trigger automatically</li>\n";
        $html .= "                        </ol>\n";
        $html .= "                    </div>\n";
        $html .= "                </div>\n";
        $html .= "            </div>\n\n";
        
        return $html;
    }

    /**
     * Render CSS styles
     * 
     * @return string CSS styles
     */
    public function renderStyles(): string
    {
        $cssFile = __DIR__ . '/../assets/css/animation-builder.css';
        if (file_exists($cssFile)) {
            return "<style>\n" . file_get_contents($cssFile) . "\n</style>\n";
        }
        
        // Fallback inline styles
        return "<style>\n" . $this->getInlineStyles() . "\n</style>\n";
    }

    /**
     * Get inline styles (fallback)
     * 
     * @return string Inline CSS
     */
    private function getInlineStyles(): string
    {
        return "
.css-animation-builder {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
    color: var(--text-primary);
    max-width: 1var(--layout-min-height-xxl);
    margin: 0 auto;
    padding: var(--font-size-xxxl);
}

.builder-header {
    text-align: center;
    margin-bottom: 3rem;
}

.builder-header h1 {
    font-size: 2.5rem;
    margin-bottom: var(--font-size-md);
    color: var(--text-dark);
}

.builder-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: var(--font-size-xxxl);
}

.animation-controls,
.preview-area,
.css-output {
    background: var(--bg-primary);
    padding: var(--font-size-xxxl);
    border-radius: var(--radius-lg);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.css-output {
    grid-column: 1 / -1;
}

.control-tabs {
    display: flex;
    margin-bottom: var(--font-size-xxl);
    border-bottom: var(--border-width-medium) solid #eee;
}

.tab-button {
    background: none;
    border: none;
    padding: 0.75rem var(--font-size-xxl);
    cursor: pointer;
    border-bottom: var(--border-width-medium) solid transparent;
    transition: all var(--duration-fast) ease;
}

.tab-button.active {
    border-bottom-color: var(--primary-color);
    color: var(--primary-color);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.control-group {
    margin-bottom: var(--font-size-xxl);
}

.control-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.control-group input,
.control-group select {
    width: var(--element-width-full);
    padding: 0.5rem;
    border: var(--border-width-medium) solid var(--border-primary);
    border-radius: var(--radius-sm);
    font-size: var(--font-size-md);
}

.control-group input[type='range'] {
    width: calc(var(--element-width-full) - var(--layout-min-height-sm));
    margin-right: var(--transform-translate-sm);
}

.value-display {
    display: inline-block;
    min-width: 50px;
    font-weight: 600;
    color: var(--primary-color);
}

.preset-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(var(--layout-min-height-xl), 1fr));
    gap: var(--font-size-md);
}

.preset-button {
    padding: var(--font-size-md);
    background: var(--bg-secondary);
    border: var(--border-width-medium) solid var(--border-primary);
    border-radius: var(--radius-lg);
    cursor: pointer;
    transition: all var(--duration-fast) ease;
}

.preset-button:hover {
    border-color: var(--primary-color);
    background: var(--primary-color-light);
}

.action-buttons {
    display: flex;
    gap: var(--font-size-md);
    margin-top: var(--font-size-xxxl);
}

.button {
    padding: 0.75rem var(--font-size-xxl);
    border: none;
    border-radius: var(--radius-sm);
    cursor: pointer;
    font-size: var(--font-size-md);
    transition: all var(--duration-fast) ease;
}

.button.primary {
    background: var(--primary-color);
    color: white;
}

.button.secondary {
    background: var(--secondary-color);
    color: white;
}

.button:hover {
    opacity: var(--opacity-transparent).9;
    transform: translateY(-var(--border-width-thin));
}

.preview-container {
    background: var(--bg-secondary);
    padding: 3rem;
    border-radius: var(--radius-lg);
    margin: var(--font-size-md) 0;
    text-align: center;
    min-height: var(--layout-min-height-xxl);
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-element {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: var(--font-size-xxxl);
    border-radius: var(--radius-lg);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transform-origin: center;
    font-size: 1.var(--font-size-xxxl);
    max-width: 400px;
}

.preview-element h4 {
    margin: 0 0 var(--font-size-md) 0;
    font-size: var(--font-size-xxl);
}

.preview-element p {
    margin: 0;
    line-height: 1.4;
}

.preview-controls {
    display: flex;
    gap: var(--font-size-md);
    justify-content: center;
}

.output-tabs {
    display: flex;
    margin-bottom: var(--font-size-md);
    border-bottom: var(--border-width-medium) solid #eee;
}

.output-tab {
    background: none;
    border: none;
    padding: 0.75rem var(--font-size-xxl);
    cursor: pointer;
    border-bottom: var(--border-width-medium) solid transparent;
}

.output-tab.active {
    border-bottom-color: var(--primary-color);
    color: var(--primary-color);
}

.output-content {
    display: none;
    position: relative;
}

.output-content.active {
    display: block;
}

.output-content pre {
    background: var(--bg-dark);
    color: var(--text-light);
    padding: var(--font-size-xxl);
    border-radius: var(--radius-lg);
    overflow-x: auto;
    font-family: 'Courier New', monospace;
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.4;
}

.copy-button {
    position: absolute;
    top: var(--font-size-md);
    right: var(--font-size-md);
    background: var(--animation-success);
    color: white;
    border: none;
    padding: 0.5rem var(--font-size-md);
    border-radius: var(--radius-sm);
    cursor: pointer;
    font-size: 0.875rem;
}

.copy-button:hover {
    background: #218838;
}

/* Animation styles for preview */
.animated-typewriter {
    font-family: 'Courier New', monospace;
    border-right: var(--border-width-medium) solid;
    animation: typewriter-cursor var(--duration-slow) infinite;
}

.animated-handwriting {
    font-family: 'Dancing Script', 'Great Vibes', 'Caveat', 'Tangerine', cursive;
    transform: rotate(-1deg);
    letter-spacing: 0.02em;
    position: relative;
    color: var(--handwriting-primary);
    opacity: 0;
    animation: quillWrite 3s ease-out forwards;
    transform-origin: left center;
}

.animated-handwriting::before {
    content: '';
    position: absolute;
    top: -5px;
    left: -10px;
    width: 25px;
    height: 25px;
    background: radial-gradient(circle, rgba(139, 69, 19, 0.8) 0%, transparent 70%);
    border-radius: 50%;
    animation: quillFloat 3s ease-out forwards;
    pointer-events: none;
}

.animated-handwriting::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(139, 69, 19, 0.4), transparent);
    border-radius: 1px;
    opacity: 0;
    animation: inkFlow 3s ease-out 0.5s forwards;
}

/* Fountain Pen Variant */
.animated-handwriting.fountain-pen {
    animation: fountainWrite 3.5s ease-out forwards;
}

.animated-handwriting.fountain-pen::before {
    background: radial-gradient(circle, rgba(25, 25, 112, 0.9) 0%, transparent 70%);
    animation: fountainFloat 3.5s ease-out forwards;
}

.animated-handwriting.fountain-pen::after {
    background: linear-gradient(90deg, transparent, rgba(25, 25, 112, 0.5), transparent);
    animation: fountainInk 3.5s ease-out 0.5s forwards;
}

@keyframes quillWrite {
    0% {
        opacity: 0;
        transform: translateX(-20px) rotate(-3deg) scale(0.8);
        filter: blur(2px);
    }
    20% {
        opacity: 0.7;
        transform: translateX(-10px) rotate(-2deg) scale(0.9);
        filter: blur(1px);
    }
    100% {
        opacity: 1;
        transform: translateX(0) rotate(-1deg) scale(1);
        filter: blur(0);
    }
}

@keyframes quillFloat {
    0% {
        transform: translateX(-30px) translateY(-10px) rotate(-45deg);
        opacity: 0;
    }
    20% {
        transform: translateX(-15px) translateY(-5px) rotate(-30deg);
        opacity: 0.8;
    }
    100% {
        transform: translateX(0) translateY(0) rotate(-15deg);
        opacity: 0.6;
    }
}

@keyframes inkFlow {
    0% {
        opacity: 0;
        transform: scaleX(0);
    }
    50% {
        opacity: 0.8;
        transform: scaleX(0.7);
    }
    100% {
        opacity: 0.4;
        transform: scaleX(1);
    }
}

@keyframes fountainWrite {
    0% {
        opacity: 0;
        transform: translateX(-25px) rotate(-4deg) scale(0.7);
        filter: blur(3px);
    }
    15% {
        opacity: 0.6;
        transform: translateX(-15px) rotate(-3deg) scale(0.85);
        filter: blur(2px);
    }
    35% {
        opacity: 0.8;
        transform: translateX(-5px) rotate(-2deg) scale(0.95);
        filter: blur(1px);
    }
    100% {
        opacity: 1;
        transform: translateX(0) rotate(-1deg) scale(1);
        filter: blur(0);
    }
}

@keyframes fountainFloat {
    0% {
        transform: translateX(-35px) translateY(-15px) rotate(-50deg);
        opacity: 0;
    }
    15% {
        transform: translateX(-25px) translateY(-10px) rotate(-40deg);
        opacity: 0.6;
    }
    35% {
        transform: translateX(-10px) translateY(-5px) rotate(-25deg);
        opacity: 0.8;
    }
    100% {
        transform: translateX(0) translateY(0) rotate(-10deg);
        opacity: 0.7;
    }
}

@keyframes fountainInk {
    0% {
        opacity: 0;
        transform: scaleX(0);
        filter: blur(2px);
    }
    30% {
        opacity: 0.6;
        transform: scaleX(0.5);
        filter: blur(1px);
    }
    70% {
        opacity: 0.8;
        transform: scaleX(0.8);
        filter: blur(0.5px);
    }
    100% {
        opacity: 0.5;
        transform: scaleX(1);
        filter: blur(0);
    }
}

.animated-writetext {
    font-family: 'Caveat', 'Dancing Script', cursive;
    overflow: hidden;
    white-space: nowrap;
}

.animated-signaturedraw {
    font-family: 'Caveat', 'Dancing Script', cursive;
    position: relative;
}

.animated-drawline {
    font-family: 'Caveat', 'Dancing Script', cursive;
    position: relative;
}

/* Import Google Fonts for handwriting */
@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Great+Vibes&family=Caveat:wght@400;600;700&family=Tangerine:wght@400;700&display=swap');

@media (max-width: 768px) {
    .builder-wrapper {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .preview-controls {
        flex-direction: column;
        align-items: center;
    }
    
    .preview-element {
        font-size: var(--font-size-md);
        padding: var(--font-size-xxl);
    }
}
        ";
    }

    /**
     * Render JavaScript
     * 
     * @return string JavaScript code
     */
    public function renderScript(): string
    {
        $jsFile = __DIR__ . '/../assets/js/animation-builder.js';
        if (file_exists($jsFile)) {
            return "<script>\n" . file_get_contents($jsFile) . "\n</script>\n";
        }
        
        // Fallback inline script
        return "<script>\n" . $this->getInlineScript() . "\n</script>\n";
    }

    /**
     * Get inline script (fallback)
     * 
     * @return string Inline JavaScript
     */
    private function getInlineScript(): string
    {
        $animationsJson = json_encode($this->animations);
        $presetsJson = json_encode($this->config['presets']);
        $defaultsJson = json_encode($this->config['defaults']);
        $customAnimationsJson = json_encode($this->customAnimations);
        $cssPrefix = $this->config['cssPrefix'];
        
        return "
// CSS Animation Builder JavaScript
(function() {
    const animations = {$animationsJson};
    const presets = {$presetsJson};
    const defaults = {$defaultsJson};
    const customAnimations = {$customAnimationsJson};
    const cssPrefix = '{$cssPrefix}';
    
    document.addEventListener('DOMContentLoaded', function() {
        initializeAnimationBuilder();
    });
    
    function initializeAnimationBuilder() {
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.dataset.tab;
                
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                button.classList.add('active');
                document.getElementById(tabId + '-tab').classList.add('active');
            });
        });
        
        // Output tab functionality
        const outputTabs = document.querySelectorAll('.output-tab');
        const outputContents = document.querySelectorAll('.output-content');
        
        outputTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const outputId = tab.dataset.output;
                
                outputTabs.forEach(t => t.classList.remove('active'));
                outputContents.forEach(content => content.classList.remove('active'));
                
                tab.classList.add('active');
                document.getElementById(outputId + '-output').classList.add('active');
            });
        });
        
        // Range input value display
        const rangeInputs = document.querySelectorAll('input[type=\"range\"]');
        rangeInputs.forEach(input => {
            const valueDisplay = document.getElementById(input.id + '-value');
            if (valueDisplay) {
                input.addEventListener('input', () => {
                    valueDisplay.textContent = input.value + (input.id === 'duration' || input.id === 'delay' ? 's' : '');
                });
            }
        });
        
        // Animation generator functionality
        function generateCSS() {
            const animationType = document.getElementById('animation-type').value;
            const duration = document.getElementById('duration').value;
            const delay = document.getElementById('delay').value;
            const timingFunction = document.getElementById('timing-function').value;
            const iterationCount = document.getElementById('iteration-count').value;
            const transformOrigin = document.getElementById('transform-origin').value;
            const direction = document.getElementById('direction').value;
            const fillMode = document.getElementById('fill-mode').value;
            
            const className = cssPrefix + animationType.toLowerCase();
            
            let css = '/* Generated CSS Animation */\\n.' + className + ' {\\n    animation-name: ' + animationType + ';\\n    animation-duration: ' + duration + 's;\\n    animation-delay: ' + delay + 's;\\n    animation-timing-function: ' + timingFunction + ';\\n    animation-iteration-count: ' + iterationCount + ';\\n    animation-direction: ' + direction + ';\\n    animation-fill-mode: ' + fillMode + ';\\n    transform-origin: ' + transformOrigin + ';';
    
            // Add specific styles for typewriter and handwriting animations
            if (animationType === 'typewriter') {
                css += '\\n    overflow: hidden;\\n    white-space: nowrap;\\n    border-right: var(--border-width-medium) solid;\\n    font-family: \\'Courier New\\', monospace;';
            } else if (['handwriting', 'drawLine', 'signatureDraw'].includes(animationType)) {
                css += '\\n    font-family: \\'Caveat\\', \\'Dancing Script\\', cursive;\\n    position: relative;';
                if (animationType === 'handwriting') {
                    css += '\\n    transform: rotate(-1deg);\\n    letter-spacing: 0.02em;';
                }
            } else if (animationType === 'writeText') {
                css += '\\n    overflow: hidden;\\n    white-space: nowrap;\\n    font-family: \\'Caveat\\', \\'Dancing Script\\', cursive;\\n    position: relative;';
            }
            
            css += '\\n}\\n\\n';
            
            // Add cursor animation for typewriter
            if (animationType === 'typewriter') {
                css += '.' + className + '::after {\\n    content: \\'\\';\\n    animation: typewriter-cursor var(--duration-slow) infinite;\\n}\\n\\n@keyframes typewriter-cursor {\\n    0%, 50% { border-right-color: transparent; }\\n    51%, var(--element-width-full) { border-right-color: currentColor; }\\n}\\n\\n';
            }
            
            // Add underline effect for handwriting
            if (animationType === 'handwriting') {
                css += '.' + className + '::after {\\n    content: \\'\\';\\n    position: absolute;\\n    bottom: -var(--transform-translate-xs);\\n    left: var(--spacing-sm);\\n    right: var(--spacing-sm);\\n    height: var(--element-height-divider);\\n    background: linear-gradient(90deg, transparent, currentColor, transparent);\\n    border-radius: var(--border-width-medium);\\n    opacity: var(--opacity-transparent).7;\\n    animation: handwriting-underline ' + duration + 's ' + delay + 's ' + timingFunction + ' ' + iterationCount + ';\\n}\\n\\n@keyframes handwriting-underline {\\n    0% { width: 0; left: 50%; }\\n    var(--element-width-full) { width: var(--element-width-80); left: var(--spacing-sm); }\\n}\\n\\n';
            }
            
            css += '/* Keyframes for ' + animationType + ' */\\n' + getKeyframes(animationType);

            // Generate HTML based on animation type
            let html = '<!-- HTML Example -->\\n<div class=\"' + className + '\">\\n';
            
            if (animationType === 'typewriter') {
                html += '    <h2>Hello, I\\'m a typewriter!</h2>\\n    <p>This text will appear character by character...</p>\\n';
            } else if (['handwriting', 'writeText'].includes(animationType)) {
                html += '    <h2>Beautiful Handwriting</h2>\\n    <p>This text has an elegant, handwritten feel with smooth animations.</p>\\n';
            } else if (animationType === 'signatureDraw') {
                html += '    <h2>My Signature</h2>\\n    <p>Watch as this signature draws itself smoothly.</p>\\n';
            } else if (animationType === 'drawLine') {
                html += '    <h2>Drawing Lines</h2>\\n    <p>Perfect for underlines and decorative elements.</p>\\n';
            } else {
                html += '    <h2>Your Animated Content</h2>\\n    <p>This element will animate when the page loads.</p>\\n';
            }
            
            html += '</div>';

            document.getElementById('css-code').textContent = css;
            document.getElementById('html-code').textContent = html;
            
            return { css, html, className };
        }
        
        function getKeyframes(animationType) {
            if (customAnimations[animationType]) {
                return '@keyframes ' + animationType + ' {\\n    ' + customAnimations[animationType].keyframes.replace(/\\n/g, '\\n    ') + '\\n}';
            }
            
            // Use keyframes from the generated file
            const keyframes = window.animationKeyframes || {};
            const keyframeContent = keyframes[animationType] || '0% { opacity: var(--opacity-transparent); } var(--element-width-full) { opacity: var(--opacity-opaque); }';
            
            return '@keyframes ' + animationType + ' {\\n    ' + keyframeContent + '\\n}';
        }
        
        function previewAnimation() {
            const previewElement = document.getElementById('preview-element');
            const { className } = generateCSS();
            const animationType = document.getElementById('animation-type').value;
            
            // Reset classes
            previewElement.className = 'preview-element';
            
            // Add animation-specific styling classes
            if (animationType === 'typewriter') {
                previewElement.classList.add('animated-typewriter');
            } else if (animationType === 'handwriting') {
                previewElement.classList.add('animated-handwriting');
            } else if (animationType === 'writeText') {
                previewElement.classList.add('animated-writetext');
            } else if (animationType === 'signatureDraw') {
                previewElement.classList.add('animated-signaturedraw');
            } else if (animationType === 'drawLine') {
                previewElement.classList.add('animated-drawline');
            }
            
            // Force reflow
            previewElement.offsetHeight;
            
            // Add animation class
            previewElement.classList.add(className);
            
            // Update dynamic styles
            if (!document.getElementById('preview-styles')) {
                const style = document.createElement('style');
                style.id = 'preview-styles';
                document.head.appendChild(style);
            }
            
            const styleSheet = document.getElementById('preview-styles');
            const { css } = generateCSS();
            styleSheet.textContent = css;
        }
        
        // Event listeners
        document.getElementById('preview-animation').addEventListener('click', previewAnimation);
        document.getElementById('generate-css').addEventListener('click', generateCSS);
        
        document.getElementById('play-preview').addEventListener('click', () => {
            const previewElement = document.getElementById('preview-element');
            previewElement.style.animationPlayState = 'running';
        });
        
        document.getElementById('pause-preview').addEventListener('click', () => {
            const previewElement = document.getElementById('preview-element');
            previewElement.style.animationPlayState = 'paused';
        });
        
        document.getElementById('restart-preview').addEventListener('click', previewAnimation);
        
        // Copy functionality
        document.getElementById('copy-css').addEventListener('click', () => {
            const cssCode = document.getElementById('css-code').textContent;
            navigator.clipboard.writeText(cssCode).then(() => {
                const button = document.getElementById('copy-css');
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                setTimeout(() => {
                    button.textContent = originalText;
                }, 2000);
            });
        });
        
        document.getElementById('copy-html').addEventListener('click', () => {
            const htmlCode = document.getElementById('html-code').textContent;
            navigator.clipboard.writeText(htmlCode).then(() => {
                const button = document.getElementById('copy-html');
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                setTimeout(() => {
                    button.textContent = originalText;
                }, 2000);
            });
        });
        
        // Preset functionality
        const presetButtons = document.querySelectorAll('.preset-button');
        presetButtons.forEach(button => {
            button.addEventListener('click', () => {
                const preset = button.dataset.preset;
                applyPreset(preset);
            });
        });
        
        function applyPreset(preset) {
            const config = presets[preset];
            if (config) {
                document.getElementById('animation-type').value = config.type;
                document.getElementById('duration').value = config.duration;
                document.getElementById('delay').value = config.delay || 0;
                document.getElementById('timing-function').value = config.timing || 'ease';
                document.getElementById('iteration-count').value = config.count || 1;
                
                // Update value displays
                document.getElementById('duration-value').textContent = config.duration + 's';
                document.getElementById('delay-value').textContent = (config.delay || 0) + 's';
                
                setTimeout(previewAnimation, 100);
            }
        }
        
        // Initialize
        generateCSS();
    }
})();
        ";
    }

    /**
     * Generate JavaScript keyframes file from CSS files
     * 
     * @return string JavaScript content
     */
    public function generateJavaScriptKeyframes(): string
    {
        $keyframeDir = __DIR__ . '/Keyframes/';
        $jsContent = "// Auto-generated keyframes from CSS files\n";
        $jsContent .= "const keyframes = {\n";
        
        $keyframeEntries = [];
        
        if (is_dir($keyframeDir)) {
            $files = scandir($keyframeDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
                    $animationName = pathinfo($file, PATHINFO_FILENAME);
                    $keyframeContent = file_get_contents($keyframeDir . $file);
                    $keyframeContent = trim($keyframeContent);
                    // Escape for JavaScript string
                    $keyframeContent = str_replace(["\n", "\r"], ['\\n    ', ''], $keyframeContent);
                    $keyframeContent = str_replace("'", "\\'", $keyframeContent);
                    $keyframeEntries[] = "    {$animationName}: '{$keyframeContent}'";
                }
            }
        }
        
        $jsContent .= implode(",\n", $keyframeEntries);
        $jsContent .= "\n};\n\n";
        $jsContent .= "// Export for use in main script\n";
        $jsContent .= "if (typeof window !== 'undefined') {\n";
        $jsContent .= "    window.animationKeyframes = keyframes;\n";
        $jsContent .= "} else if (typeof module !== 'undefined') {\n";
        $jsContent .= "    module.exports = keyframes;\n";
        $jsContent .= "}\n";
        
        return $jsContent;
    }
}
