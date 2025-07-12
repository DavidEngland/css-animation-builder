<?php
/**
 * CSS Variables Refactoring Script
 * Converts hardcoded values to CSS variables in PHP files
 * Version: 1.2.0
 */

class CSSVariablesRefactor {
    private $colorMappings = [
        '#007cba' => 'var(--primary-color)',
        '#005a8b' => 'var(--primary-color-dark)',
        '#e3f2fd' => 'var(--primary-color-light)',
        '#0056b3' => 'var(--primary-color-hover)',
        '#6c757d' => 'var(--secondary-color)',
        '#5a6268' => 'var(--secondary-color-dark)',
        '#f8f9fa' => 'var(--bg-secondary)',
        '#333' => 'var(--text-primary)',
        '#666' => 'var(--text-secondary)',
        '#999' => 'var(--text-muted)',
        '#ccc' => 'var(--text-light)',
        '#2c3e50' => 'var(--text-dark)',
        '#fff' => 'var(--bg-primary)',
        '#e9ecef' => 'var(--bg-tertiary)',
        '#2d3748' => 'var(--bg-dark)',
        '#f5f5f5' => 'var(--bg-light)',
        '#ddd' => 'var(--border-primary)',
        '#dee2e6' => 'var(--border-secondary)',
        '#ced4da' => 'var(--border-tertiary)',
        '#667eea' => 'var(--animation-secondary)',
        '#8B4513' => 'var(--handwriting-primary)',
        '#654321' => 'var(--handwriting-secondary)',
        '#f9f2e7' => 'var(--handwriting-background)',
        '#495057' => 'var(--typewriter-secondary)',
        '#ff6b6b' => 'var(--animation-error)',
        '#28a745' => 'var(--animation-success)',
        '#ffc107' => 'var(--animation-warning)',
        '#90cdf4' => 'var(--text-light)',
        '#e2e8f0' => 'var(--text-light)'
    ];

    private $sizeMappings = [
        '3px' => 'var(--element-height-divider)',
        '100%' => 'var(--element-width-full)',
        '80%' => 'var(--element-width-80)',
        '60%' => 'var(--element-width-60)',
        '40%' => 'var(--element-width-40)',
        '20%' => 'var(--element-width-20)',
        '10%' => 'var(--spacing-sm)',
        '200px' => 'var(--layout-min-height-xxl)',
        '150px' => 'var(--layout-min-height-xl)',
        '120px' => 'var(--layout-min-height-lg)',
        '100px' => 'var(--layout-min-height-md)',
        '60px' => 'var(--layout-min-height-sm)',
        '2px' => 'var(--border-width-medium)',
        '1px' => 'var(--border-width-thin)',
        '5px' => 'var(--transform-translate-xs)',
        '10px' => 'var(--transform-translate-sm)',
        '20px' => 'var(--transform-translate-md)',
        '1s' => 'var(--duration-slow)',
        '0.5s' => 'var(--duration-normal)',
        '0.3s' => 'var(--duration-fast)',
        '1rem' => 'var(--font-size-md)',
        '1.5rem' => 'var(--font-size-xxl)',
        '2rem' => 'var(--font-size-xxxl)'
    ];

    private $borderMappings = [
        'border: 2px solid #ddd' => 'border: var(--border-width-medium) solid var(--border-primary)',
        'border: 1px solid #dee2e6' => 'border: var(--border-width-thin) solid var(--border-secondary)',
        'border: 1px solid #ced4da' => 'border: var(--border-width-thin) solid var(--border-tertiary)',
        'border-radius: 5px' => 'border-radius: var(--radius-md)',
        'border-radius: 4px' => 'border-radius: var(--radius-sm)',
        'border-radius: 8px' => 'border-radius: var(--radius-lg)'
    ];

    private $transformMappings = [
        'scale(0.3)' => 'scale(var(--transform-scale-xs))',
        'scale(0.8)' => 'scale(var(--transform-scale-sm))',
        'scale(1)' => 'scale(var(--transform-scale-md))',
        'scale(1.05)' => 'scale(var(--transform-scale-lg))',
        'scale(1.1)' => 'scale(var(--transform-scale-xl))',
        'translateX(-5px)' => 'translateX(calc(-1 * var(--transform-translate-xs)))',
        'translateX(5px)' => 'translateX(var(--transform-translate-xs))',
        'translateX(-10px)' => 'translateX(calc(-1 * var(--transform-translate-sm)))',
        'translateX(10px)' => 'translateX(var(--transform-translate-sm))',
        'translateY(-2deg)' => 'translateY(calc(-1 * var(--transform-rotate-xs)))',
        'rotate(-2deg)' => 'rotate(calc(-1 * var(--transform-rotate-xs)))',
        'rotate(5deg)' => 'rotate(var(--transform-rotate-sm))',
        'rotate(-5deg)' => 'rotate(calc(-1 * var(--transform-rotate-sm)))',
        'rotate(10deg)' => 'rotate(var(--transform-rotate-md))',
        'rotate(-10deg)' => 'rotate(calc(-1 * var(--transform-rotate-md)))',
        'rotate(0deg)' => 'rotate(0deg)',
        'rotate(360deg)' => 'rotate(var(--transform-rotate-full))'
    ];

    private $opacityMappings = [
        'opacity: 0' => 'opacity: var(--opacity-transparent)',
        'opacity: 0.3' => 'opacity: var(--opacity-low)',
        'opacity: 0.6' => 'opacity: var(--opacity-medium)',
        'opacity: 0.7' => 'opacity: var(--opacity-medium)',
        'opacity: 0.8' => 'opacity: var(--opacity-high)',
        'opacity: 0.9' => 'opacity: var(--opacity-high)',
        'opacity: 1' => 'opacity: var(--opacity-opaque)'
    ];

    public function refactorFile($filePath) {
        if (!file_exists($filePath)) {
            echo "❌ File not found: $filePath\n";
            return false;
        }

        $content = file_get_contents($filePath);
        $originalContent = $content;

        // Apply color mappings
        foreach ($this->colorMappings as $hardcoded => $variable) {
            $content = str_replace($hardcoded, $variable, $content);
        }

        // Apply size mappings
        foreach ($this->sizeMappings as $hardcoded => $variable) {
            $content = str_replace($hardcoded, $variable, $content);
        }

        // Apply border mappings
        foreach ($this->borderMappings as $hardcoded => $variable) {
            $content = str_replace($hardcoded, $variable, $content);
        }

        // Apply transform mappings
        foreach ($this->transformMappings as $hardcoded => $variable) {
            $content = str_replace($hardcoded, $variable, $content);
        }

        // Apply opacity mappings
        foreach ($this->opacityMappings as $hardcoded => $variable) {
            $content = str_replace($hardcoded, $variable, $content);
        }

        // Only write if content changed
        if ($content !== $originalContent) {
            file_put_contents($filePath, $content);
            echo "✅ Updated: $filePath\n";
            return true;
        } else {
            echo "ℹ️  No changes: $filePath\n";
            return false;
        }
    }

    public function refactorDirectory($directory) {
        $files = glob($directory . '/*.{php,html}', GLOB_BRACE);
        $updatedCount = 0;

        foreach ($files as $file) {
            if ($this->refactorFile($file)) {
                $updatedCount++;
            }
        }

        echo "\n📊 Summary: Updated $updatedCount files\n";
        return $updatedCount;
    }

    public function generateVariablesImport() {
        $import = "<!-- CSS Variables Import -->\n";
        $import .= "<link rel=\"stylesheet\" href=\"src/variables.css\">\n";
        $import .= "<!-- End CSS Variables Import -->\n";
        return $import;
    }

    public function addVariablesImportToFile($filePath) {
        if (!file_exists($filePath)) {
            echo "❌ File not found: $filePath\n";
            return false;
        }

        $content = file_get_contents($filePath);
        
        // Check if already has variables import
        if (strpos($content, 'src/variables.css') !== false) {
            echo "ℹ️  Variables already imported: $filePath\n";
            return false;
        }

        // Find head section and add import
        $import = $this->generateVariablesImport();
        
        if (strpos($content, '</head>') !== false) {
            $content = str_replace('</head>', $import . '</head>', $content);
        } else {
            // Add after opening head tag
            $content = str_replace('<head>', '<head>' . "\n" . $import, $content);
        }

        file_put_contents($filePath, $content);
        echo "✅ Added variables import: $filePath\n";
        return true;
    }
}

// Run the refactoring
$refactor = new CSSVariablesRefactor();

echo "🔄 Starting CSS Variables Refactoring...\n\n";

// Refactor PHP files
echo "📁 Refactoring PHP files...\n";
$refactor->refactorFile('src/Builder.php');
$refactor->refactorFile('src/Builder.min.php');
$refactor->refactorFile('src/WordPressPlugin.php');
$refactor->refactorFile('test-keyframes.php');
$refactor->refactorFile('test-enhanced.php');
$refactor->refactorFile('css-animation-builder-wordpress.php');

echo "\n📁 Refactoring HTML files...\n";
$refactor->refactorFile('demo.html');
$refactor->refactorFile('example.html');
$refactor->refactorFile('example-enhanced.html');
$refactor->refactorFile('quick-demo.html');
$refactor->refactorFile('demos/typewriter-demo.html');
$refactor->refactorFile('demos/handwriting-demo.html');

echo "\n📝 Adding CSS variables imports...\n";
$refactor->addVariablesImportToFile('demo.html');
$refactor->addVariablesImportToFile('example.html');
$refactor->addVariablesImportToFile('example-enhanced.html');
$refactor->addVariablesImportToFile('quick-demo.html');
$refactor->addVariablesImportToFile('demos/typewriter-demo.html');
$refactor->addVariablesImportToFile('demos/handwriting-demo.html');

echo "\n🎉 CSS Variables Refactoring Complete!\n";
echo "📋 Next steps:\n";
echo "1. Test all animations and demos\n";
echo "2. Verify CSS variables are working correctly\n";
echo "3. Update any remaining hardcoded values manually\n";
echo "4. Consider creating theme variants using CSS variables\n";
