<?php
/**
 * Build script to generate JavaScript keyframes from CSS files
 */

require_once __DIR__ . '/src/Builder.php';

$builder = new Reia\CSSAnimationBuilder\Builder();

// Generate JavaScript keyframes
$jsContent = $builder->generateJavaScriptKeyframes();

// Write to file
file_put_contents(__DIR__ . '/src/keyframes.js', $jsContent);

echo "✓ Generated JavaScript keyframes file: src/keyframes.js\n";
echo "✓ Build complete!\n";
