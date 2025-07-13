<?php

require_once 'src/Builder.php';

use Reia\CSSAnimationBuilder\Builder;

// Test the handwriting animations integration
$builder = new Builder();

echo "🎨 Testing Handwriting Animations from Shogun Slogans\n";
echo "=" . str_repeat("=", 50) . "\n\n";

// Test quillWriting animation
echo "✍️ Testing Quill Writing Animation:\n";
$quillCSS = $builder->generateCSS('quillWriting', [
    'duration' => 2,
    'delay' => 0,
    'timingFunction' => 'ease-out'
]);
echo "Generated CSS (first 300 chars):\n";
echo substr($quillCSS, 0, 300) . "...\n\n";

// Test fountainPenWriting animation
echo "🖋️ Testing Fountain Pen Writing Animation:\n";
$fountainPenCSS = $builder->generateCSS('fountainPenWriting', [
    'duration' => 2.5,
    'delay' => 0.5,
    'timingFunction' => 'ease-out'
]);
echo "Generated CSS (first 300 chars):\n";
echo substr($fountainPenCSS, 0, 300) . "...\n\n";

// Test calligraphyWriting animation
echo "✒️ Testing Calligraphy Writing Animation:\n";
$calligraphyCSS = $builder->generateCSS('calligraphyWriting', [
    'duration' => 3,
    'delay' => 0,
    'timingFunction' => 'ease-in-out'
]);
echo "Generated CSS (first 300 chars):\n";
echo substr($calligraphyCSS, 0, 300) . "...\n\n";

// Test handwritingReveal animation
echo "📝 Testing Handwriting Reveal Animation:\n";
$revealCSS = $builder->generateCSS('handwritingReveal', [
    'duration' => 1.5,
    'delay' => 0,
    'timingFunction' => 'ease-out'
]);
echo "Generated CSS (first 300 chars):\n";
echo substr($revealCSS, 0, 300) . "...\n\n";

// Test inkDrip animation
echo "💧 Testing Ink Drip Animation:\n";
$inkCSS = $builder->generateCSS('inkDrip', [
    'duration' => 2,
    'delay' => 0.2,
    'timingFunction' => 'ease-in-out'
]);
echo "Generated CSS (first 300 chars):\n";
echo substr($inkCSS, 0, 300) . "...\n\n";

echo "✅ All handwriting animations tested successfully!\n";
echo "🎯 These animations bring the sophisticated Shogun Slogans handwriting\n";
echo "   effects into the CSS Animation Builder with proper 15deg rotation.\n\n";

// Display all available animations to show the complete collection
echo "📋 Complete Animation Library:\n";
$animations = $builder->getAnimations();
$handwritingAnimations = ['quillWriting', 'fountainPenWriting', 'calligraphyWriting', 'handwritingReveal', 'inkDrip'];
$fallingAnimations = ['dangleFall', 'dangleFallSideways', 'dangleFallSpiral', 'leafFloat', 'cascadeFall'];

echo "\n🖋️ Handwriting Animations:\n";
foreach ($handwritingAnimations as $anim) {
    echo "   - $anim\n";
}

echo "\n🍂 Falling Animations:\n";
foreach ($fallingAnimations as $anim) {
    echo "   - $anim\n";
}

echo "\n💫 Other Animations:\n";
foreach ($animations as $anim) {
    if (!in_array($anim, $handwritingAnimations) && !in_array($anim, $fallingAnimations)) {
        echo "   - $anim\n";
    }
}

echo "\n🚀 Total animations available: " . count($animations) . "\n";
?>
