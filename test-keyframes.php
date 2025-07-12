<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keyframes Test - File-based Loading</title>
</head>
<body>
    <h1>Testing File-based Keyframes</h1>
    
    <?php
    require_once 'src/Builder.php';
    
    $builder = new Reia\CSSAnimationBuilder\Builder();
    
    // Test a few animations to make sure they load from files
    $animations = ['fadeIn', 'slideInLeft', 'zoomIn', 'typewriter', 'handwriting'];
    
    foreach ($animations as $animation) {
        echo "<h2>Testing: {$animation}</h2>";
        
        // Generate CSS for this animation
        $css = $builder->generateCSS($animation, [
            'duration' => 'var(--duration-slow)',
            'easing' => 'ease-in-out'
        ]);
        
        echo "<pre style='background: var(--bg-light); padding: var(--transform-translate-sm); border-radius: var(--transform-translate-xs);'>";
        echo htmlspecialchars($css);
        echo "</pre>";
        
        echo "<hr>";
    }
    ?>
    
    <h2>File Structure Test</h2>
    <p>Checking if keyframe files exist:</p>
    <ul>
    <?php
    $keyframeDir = __DIR__ . '/src/Keyframes/';
    if (is_dir($keyframeDir)) {
        $files = scandir($keyframeDir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
                echo "<li style='color: green;'>✓ {$file}</li>";
            }
        }
    } else {
        echo "<li style='color: red;'>✗ Keyframes directory not found</li>";
    }
    ?>
    </ul>
</body>
</html>
