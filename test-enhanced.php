<?php
/**
 * Enhanced CSS Animation Builder Demo
 * Test file to showcase the new typewriter and handwriting animations
 */

// Include the Builder class
require_once __DIR__ . '/src/Builder.php';

use Reia\CSSAnimationBuilder\Builder;

// Create a new builder instance with enhanced configuration
$builder = new Builder([
    'theme' => 'default',
    'showPreview' => true,
    'showCode' => true,
    'showPresets' => true,
    'showAdvanced' => true,
    'cssPrefix' => 'animated-',
    'customAnimations' => [
        'typewriterAdvanced' => [
            'name' => 'Advanced Typewriter',
            'keyframes' => '
                0% { 
                    width: 0; 
                    border-right: var(--element-height-divider) solid currentColor; 
                }
                90% { 
                    width: var(--element-width-full); 
                    border-right: var(--element-height-divider) solid currentColor; 
                }
                var(--element-width-full) { 
                    width: var(--element-width-full); 
                    border-right: var(--element-height-divider) solid transparent; 
                }
            ',
            'defaultDuration' => 4.0,
            'defaultTiming' => 'steps(40, end)'
        ],
        'handwritingScript' => [
            'name' => 'Handwriting Script',
            'keyframes' => '
                0% { 
                    stroke-dashoffset: 200%; 
                    opacity: var(--opacity-transparent); 
                    transform: translateY(var(--transform-translate-md)) rotate(calc(-1 * var(--transform-rotate-xs))); 
                }
                var(--spacing-sm) { 
                    opacity: var(--opacity-opaque); 
                }
                var(--element-width-full) { 
                    stroke-dashoffset: 0%; 
                    opacity: var(--opacity-opaque); 
                    transform: translateY(0) rotate(-1deg); 
                }
            ',
            'defaultDuration' => 3.0,
            'defaultTiming' => 'ease-in-out'
        ]
    ]
]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced CSS Animation Builder - Live Demo</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--animation-secondary) 0%, #764ba2 var(--element-width-full));
            min-height: 100vh;
        }
        
        .demo-wrapper {
            padding: var(--font-size-xxxl);
            min-height: 100vh;
        }
        
        .demo-header {
            text-align: center;
            color: white;
            margin-bottom: var(--font-size-xxxl);
        }
        
        .demo-header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: var(--border-width-medium) var(--border-width-medium) 4px rgba(0,0,0,0.3);
        }
        
        .demo-header p {
            font-size: 1.var(--font-size-xxxl);
            opacity: var(--opacity-transparent).9;
            margin-bottom: 0;
        }
        
        /* Animation Examples */
        .animation-examples {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--font-size-xxxl);
            margin-bottom: 3rem;
        }
        
        .example-card {
            background: white;
            padding: var(--font-size-xxxl);
            border-radius: 1var(--border-width-medium);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .example-card h3 {
            color: var(--text-dark);
            margin-bottom: var(--font-size-md);
        }
        
        .example-demo {
            margin: var(--font-size-xxl) 0;
            padding: var(--font-size-xxl);
            background: var(--bg-secondary);
            border-radius: var(--radius-lg);
            min-height: var(--layout-min-height-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.var(--font-size-xxxl);
            position: relative;
        }
        
        /* Live Animation Examples */
        .typewriter-demo {
            font-family: 'Courier New', monospace;
            overflow: hidden;
            white-space: nowrap;
            border-right: var(--element-height-divider) solid var(--primary-color);
            animation: typewriter 4s steps(30, end), blink-cursor var(--duration-slow) step-end infinite;
        }
        
        .handwriting-demo {
            font-family: 'Caveat', 'Dancing Script', cursive;
            transform: rotate(-1deg);
            letter-spacing: 0.02em;
            position: relative;
            animation: handwriting-appear 3s ease-in-out;
        }
        
        .handwriting-demo::after {
            content: '';
            position: absolute;
            bottom: -var(--transform-translate-xs);
            left: var(--spacing-sm);
            right: var(--spacing-sm);
            height: var(--element-height-divider);
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
            border-radius: var(--border-width-medium);
            opacity: var(--opacity-transparent).7;
            animation: handwriting-underline 3s ease-in-out;
        }
        
        .signature-demo {
            font-family: 'Caveat', 'Dancing Script', cursive;
            font-size: 1.8rem;
            color: var(--text-dark);
            animation: signature-draw 4s ease-in-out;
        }
        
        @keyframes typewriter {
            0% { width: 0; }
            var(--element-width-full) { width: var(--element-width-full); }
        }
        
        @keyframes blink-cursor {
            0%, 50% { border-right-color: transparent; }
            51%, var(--element-width-full) { border-right-color: var(--primary-color); }
        }
        
        @keyframes handwriting-appear {
            0% { 
                opacity: var(--opacity-transparent); 
                transform: translateY(var(--transform-translate-sm)) rotate(calc(-1 * var(--transform-rotate-xs))); 
            }
            var(--spacing-sm) { opacity: var(--opacity-opaque); }
            var(--element-width-full) { 
                opacity: var(--opacity-opaque); 
                transform: translateY(0) rotate(-1deg); 
            }
        }
        
        @keyframes handwriting-underline {
            0% { width: 0; left: 50%; }
            var(--element-width-full) { width: var(--element-width-80); left: var(--spacing-sm); }
        }
        
        @keyframes signature-draw {
            0% { 
                opacity: var(--opacity-transparent); 
                transform: scale(var(--transform-scale-sm)); 
            }
            var(--spacing-sm) { opacity: var(--opacity-opaque); }
            var(--element-width-full) { 
                opacity: var(--opacity-opaque); 
                transform: scale(var(--transform-scale-md)); 
            }
        }
        
        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&family=Dancing+Script:wght@400;600;700&display=swap');
    </style>
</head>
<body>
    <div class="demo-wrapper">
        <div class="demo-header">
            <h1>Enhanced CSS Animation Builder</h1>
            <p>Featuring Typewriter & Handwriting Effects</p>
        </div>
        
        <div class="animation-examples">
            <div class="example-card">
                <h3>🖋️ Typewriter Effect</h3>
                <div class="example-demo">
                    <div class="typewriter-demo">Hello, I'm typing!</div>
                </div>
                <p>Classic typewriter animation with cursor effect</p>
            </div>
            
            <div class="example-card">
                <h3>✍️ Handwriting Animation</h3>
                <div class="example-demo">
                    <div class="handwriting-demo">Beautiful handwriting</div>
                </div>
                <p>Elegant handwritten style with underline effect</p>
            </div>
            
            <div class="example-card">
                <h3>🖊️ Signature Draw</h3>
                <div class="example-demo">
                    <div class="signature-demo">My Signature</div>
                </div>
                <p>Smooth signature-style animation</p>
            </div>
        </div>
        
        <?php echo $builder->render(); ?>
    </div>
</body>
</html>
