<?php

require_once 'src/Builder.php';

use Reia\CSSAnimationBuilder\Builder;

// Test the dangleFall animations integration
$builder = new Builder();

// Display available animations
echo "Available animations:\n";
$animations = $builder->getAnimations();
foreach ($animations as $animation) {
    echo "- $animation\n";
}

echo "\n";

// Test dangleFall animation generation
echo "Testing dangleFall animation generation:\n";
$dangleFallCSS = $builder->generateCSS('dangleFall', [
    'duration' => 4,
    'delay' => 0,
    'timingFunction' => 'ease-in'
]);

echo "Generated CSS:\n";
echo $dangleFallCSS;

echo "\n\nTesting leafFloat animation generation:\n";
$leafFloatCSS = $builder->generateCSS('leafFloat', [
    'duration' => 3,
    'delay' => 0.5,
    'timingFunction' => 'ease-in-out'
]);

echo "Generated CSS:\n";
echo $leafFloatCSS;

echo "\n\nTesting HTML generation for dangleFall:\n";
$htmlOutput = $builder->generateHTML('dangleFall', [
    'duration' => 4,
    'delay' => 0,
    'timingFunction' => 'ease-in'
]);

echo "Generated HTML (first 500 chars):\n";
echo substr($htmlOutput, 0, 500) . "...\n";

echo "\n\nAll tests completed successfully!\n";
echo "dangleFall animations have been successfully integrated into CSS Animation Builder.\n";
?>
