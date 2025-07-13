<?php
/*. TODO: Add support for custom animations with element-specific CSS properties */
public function addCustomAnimation(string $name, array $animation): self
{
$this->customAnimations[$name] = array_merge([
'name' => ucfirst($name),
'keyframes' => '',
'defaultDuration' => 1.0,
'defaultTiming' => 'ease',
'elementCss' => [] // New property for element-specific CSS
], $animation);
if (!in_array($name, $this->animations)) {
$this->animations[] = $name;
}
return $this;
}

// Example: getKeyframes could read from a file or a dedicated KeyframeManager class
private function getKeyframes(string $animation): string
{
    if (isset($this->customAnimations[$animation])) {
        return "@keyframes $animation{\n" . str_replace("\n", "\n    ", trim($this->customAnimations[$animation]['keyframes'])) . "\n}";
    }
    $keyframeFile = __DIR__ . '/Keyframes/' . ucfirst($animation) . 'Keyframes.php'; // Or .css, .json
    if (file_exists($keyframeFile)) {
        return file_get_contents($keyframeFile);
    }
    // Fallback or error
    return "@keyframes $animation{\n    0%{opacity:0;}100%{opacity:1;}\n}";
}