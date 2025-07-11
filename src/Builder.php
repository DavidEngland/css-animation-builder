<?php

namespace Reia\CSSAnimationBuilder;

/**
 * CSS Animation Builder - Core Builder Class
 * 
 * A framework-agnostic CSS animation builder that generates interactive
 * HTML interfaces for creating CSS animations.
 * 
 * @package Reia\CSSAnimationBuilder
 * @version 1.0.0
 * @author David England
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
            'bounceIn', 'rotateIn', 'pulse', 'shake', 'wobble', 'swing'
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
            'rotate' => ['type' => 'rotateIn', 'duration' => 1, 'timing' => 'ease-in-out']
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
        $css .= "}\n\n";
        
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

        // Built-in animations
        $keyframes = [
            'fadeIn' => "0% { opacity: 0; }\n    100% { opacity: 1; }",
            'fadeOut' => "0% { opacity: 1; }\n    100% { opacity: 0; }",
            'slideInLeft' => "0% { transform: translateX(-100%); opacity: 0; }\n    100% { transform: translateX(0); opacity: 1; }",
            'slideInRight' => "0% { transform: translateX(100%); opacity: 0; }\n    100% { transform: translateX(0); opacity: 1; }",
            'slideInUp' => "0% { transform: translateY(100%); opacity: 0; }\n    100% { transform: translateY(0); opacity: 1; }",
            'slideInDown' => "0% { transform: translateY(-100%); opacity: 0; }\n    100% { transform: translateY(0); opacity: 1; }",
            'zoomIn' => "0% { transform: scale(0); opacity: 0; }\n    100% { transform: scale(1); opacity: 1; }",
            'zoomOut' => "0% { transform: scale(1); opacity: 1; }\n    100% { transform: scale(0); opacity: 0; }",
            'bounceIn' => "0% { transform: scale(0.3); opacity: 0; }\n    50% { transform: scale(1.05); opacity: 0.8; }\n    70% { transform: scale(0.9); opacity: 0.9; }\n    100% { transform: scale(1); opacity: 1; }",
            'rotateIn' => "0% { transform: rotate(-200deg); opacity: 0; }\n    100% { transform: rotate(0); opacity: 1; }",
            'pulse' => "0% { transform: scale(1); }\n    50% { transform: scale(1.1); }\n    100% { transform: scale(1); }",
            'shake' => "0%, 100% { transform: translateX(0); }\n    10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }\n    20%, 40%, 60%, 80% { transform: translateX(10px); }",
            'wobble' => "0% { transform: translateX(0%); }\n    15% { transform: translateX(-25%) rotate(-5deg); }\n    30% { transform: translateX(20%) rotate(3deg); }\n    45% { transform: translateX(-15%) rotate(-3deg); }\n    60% { transform: translateX(10%) rotate(2deg); }\n    75% { transform: translateX(-5%) rotate(-1deg); }\n    100% { transform: translateX(0%); }",
            'swing' => "20% { transform: rotate(15deg); }\n    40% { transform: rotate(-10deg); }\n    60% { transform: rotate(5deg); }\n    80% { transform: rotate(-5deg); }\n    100% { transform: rotate(0deg); }"
        ];

        $keyframeContent = $keyframes[$animation] ?? '0% { opacity: 0; } 100% { opacity: 1; }';
        
        return "@keyframes {$animation} {\n    {$keyframeContent}\n}";
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
        $html .= "    <h2>Your Animated Content</h2>\n";
        $html .= "    <p>This element will animate when the page loads.</p>\n";
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
    color: #333;
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.builder-header {
    text-align: center;
    margin-bottom: 3rem;
}

.builder-header h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.builder-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: 2rem;
}

.animation-controls,
.preview-area,
.css-output {
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.css-output {
    grid-column: 1 / -1;
}

.control-tabs {
    display: flex;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid #eee;
}

.tab-button {
    background: none;
    border: none;
    padding: 0.75rem 1.5rem;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}

.tab-button.active {
    border-bottom-color: #007cba;
    color: #007cba;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.control-group {
    margin-bottom: 1.5rem;
}

.control-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.control-group input,
.control-group select {
    width: 100%;
    padding: 0.5rem;
    border: 2px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.control-group input[type='range'] {
    width: calc(100% - 60px);
    margin-right: 10px;
}

.value-display {
    display: inline-block;
    min-width: 50px;
    font-weight: 600;
    color: #007cba;
}

.preset-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.preset-button {
    padding: 1rem;
    background: #f8f9fa;
    border: 2px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.preset-button:hover {
    border-color: #007cba;
    background: #e3f2fd;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.button {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.button.primary {
    background: #007cba;
    color: white;
}

.button.secondary {
    background: #6c757d;
    color: white;
}

.button:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.preview-container {
    background: #f8f9fa;
    padding: 3rem;
    border-radius: 8px;
    margin: 1rem 0;
    text-align: center;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-element {
    background: linear-gradient(135deg, #007cba, #6c757d);
    color: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transform-origin: center;
}

.preview-controls {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.output-tabs {
    display: flex;
    margin-bottom: 1rem;
    border-bottom: 2px solid #eee;
}

.output-tab {
    background: none;
    border: none;
    padding: 0.75rem 1.5rem;
    cursor: pointer;
    border-bottom: 2px solid transparent;
}

.output-tab.active {
    border-bottom-color: #007cba;
    color: #007cba;
}

.output-content {
    display: none;
    position: relative;
}

.output-content.active {
    display: block;
}

.output-content pre {
    background: #2d3748;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 8px;
    overflow-x: auto;
    font-family: 'Courier New', monospace;
    margin: 0;
}

.copy-button {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #28a745;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.875rem;
}

.copy-button:hover {
    background: #218838;
}

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
            
            const css = `/* Generated CSS Animation */
.` + className + ` {
    animation-name: ` + animationType + `;
    animation-duration: ` + duration + `s;
    animation-delay: ` + delay + `s;
    animation-timing-function: ` + timingFunction + `;
    animation-iteration-count: ` + iterationCount + `;
    animation-direction: ` + direction + `;
    animation-fill-mode: ` + fillMode + `;
    transform-origin: ` + transformOrigin + `;
}

/* Keyframes for ` + animationType + ` */
` + getKeyframes(animationType);

            const html = `<!-- HTML Example -->
<div class=\"` + className + `\">
    <h2>Your Animated Content</h2>
    <p>This element will animate when the page loads.</p>
</div>`;

            document.getElementById('css-code').textContent = css;
            document.getElementById('html-code').textContent = html;
            
            return { css, html, className };
        }
        
        function getKeyframes(animationType) {
            if (customAnimations[animationType]) {
                return '@keyframes ' + animationType + ' {\\n    ' + customAnimations[animationType].keyframes.replace(/\\n/g, '\\n    ') + '\\n}';
            }
            
            const keyframes = {
                fadeIn: '0% { opacity: 0; }\\n    100% { opacity: 1; }',
                fadeOut: '0% { opacity: 1; }\\n    100% { opacity: 0; }',
                slideInLeft: '0% { transform: translateX(-100%); opacity: 0; }\\n    100% { transform: translateX(0); opacity: 1; }',
                slideInRight: '0% { transform: translateX(100%); opacity: 0; }\\n    100% { transform: translateX(0); opacity: 1; }',
                slideInUp: '0% { transform: translateY(100%); opacity: 0; }\\n    100% { transform: translateY(0); opacity: 1; }',
                slideInDown: '0% { transform: translateY(-100%); opacity: 0; }\\n    100% { transform: translateY(0); opacity: 1; }',
                zoomIn: '0% { transform: scale(0); opacity: 0; }\\n    100% { transform: scale(1); opacity: 1; }',
                zoomOut: '0% { transform: scale(1); opacity: 1; }\\n    100% { transform: scale(0); opacity: 0; }',
                bounceIn: '0% { transform: scale(0.3); opacity: 0; }\\n    50% { transform: scale(1.05); opacity: 0.8; }\\n    70% { transform: scale(0.9); opacity: 0.9; }\\n    100% { transform: scale(1); opacity: 1; }',
                rotateIn: '0% { transform: rotate(-200deg); opacity: 0; }\\n    100% { transform: rotate(0); opacity: 1; }',
                pulse: '0% { transform: scale(1); }\\n    50% { transform: scale(1.1); }\\n    100% { transform: scale(1); }',
                shake: '0%, 100% { transform: translateX(0); }\\n    10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }\\n    20%, 40%, 60%, 80% { transform: translateX(10px); }',
                wobble: '0% { transform: translateX(0%); }\\n    15% { transform: translateX(-25%) rotate(-5deg); }\\n    30% { transform: translateX(20%) rotate(3deg); }\\n    45% { transform: translateX(-15%) rotate(-3deg); }\\n    60% { transform: translateX(10%) rotate(2deg); }\\n    75% { transform: translateX(-5%) rotate(-1deg); }\\n    100% { transform: translateX(0%); }',
                swing: '20% { transform: rotate(15deg); }\\n    40% { transform: rotate(-10deg); }\\n    60% { transform: rotate(5deg); }\\n    80% { transform: rotate(-5deg); }\\n    100% { transform: rotate(0deg); }'
            };
            
            const keyframeContent = keyframes[animationType] || '0% { opacity: 0; } 100% { opacity: 1; }';
            
            return '@keyframes ' + animationType + ' {\\n    ' + keyframeContent + '\\n}';
        }
        
        function previewAnimation() {
            const previewElement = document.getElementById('preview-element');
            const { className } = generateCSS();
            
            previewElement.className = 'preview-element';
            previewElement.offsetHeight; // Force reflow
            previewElement.classList.add(className);
            
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
}
