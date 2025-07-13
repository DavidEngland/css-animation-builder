Improvement 1: Enhanced Custom Animation Flexibility (Allowing elementCss for custom animations)

Phase 1: Design & Plan with Claude/Sonnet

Prompt (to Claude/Sonnet):
"I have a PHP class CSSAnimationBuilder. I want to extend its addCustomAnimation method so that when a user defines a custom animation, they can also specify CSS properties that apply directly to the animated HTML element itself, not just keyframes. For example, a custom 'typewriter-like' animation might need overflow: hidden; white-space: nowrap;.

Here's the current addCustomAnimation method:

PHP
public function addCustomAnimation(string $name, array $animation):self{
    $this->customAnimations[$name]=array_merge(['name'=>ucfirst($name),'keyframes'=>'','defaultDuration'=>1.0,'defaultTiming'=>'ease'],$animation);
    if(!in_array($name,$this->animations)){$this->animations[]=$name;}
    return $this;
}
And here's part of the generateCSS method that applies element-specific CSS for built-in animations:

PHP
public function generateCSS(string $animation,array $options=[]):string{
    // ...
    if($animation==='typewriter'){
        $css.="overflow:hidden;white-space:nowrap;border-right:2px solid;font-family:'Courier New',monospace;";
    }elseif(in_array($animation,['handwriting','drawLine','signatureDraw'])){
        $css.="font-family:'Caveat','Dancing Script',cursive;position:relative;";
        if($animation==='handwriting'){$css.="transform:rotate(-1deg);letter-spacing:0.02em;";}
    } // ...
}
Outline the precise changes needed in both the addCustomAnimation method and the generateCSS method to support a new elementCss array within custom animation definitions. How should this elementCss be merged and applied in generateCSS? Provide the revised PHP code for both methods."

Phase 2: Implementation with Copilot (or copy-paste from Claude/Sonnet)

Action: Copy the revised addCustomAnimation and generateCSS methods provided by Claude/Sonnet and paste them into your Builder.php file.

Prompt (VS Code with Copilot - for new elementCss values):
"Now that customAnimations can have an elementCss array, I need to update the getInlineScript()'s generateCSS() JavaScript function. Specifically, after applying the standard animation properties, I need to iterate through customAnimations[animationType].elementCss and append those properties to the css string for the main animation class. Show me just the relevant part of the JavaScript generateCSS function that needs modification."
(Copilot should provide the loop and string concatenation for elementCss)

Improvement 2: CSS Variable Support for Dynamic Theming

Phase 1: Design & Plan with Claude/Sonnet

Prompt (to Claude/Sonnet):
"I want to make the styling of my CSSAnimationBuilder more flexible using CSS variables for theming. Currently, my getInlineStyles() method contains hardcoded values for colors, shadows, and other properties.

Here's a snippet of my getInlineStyles():

PHP
private function getInlineStyles():string{
    return ".css-animation-builder{font-family:-apple-system,...;color:#333;}.button.primary{background:#007cba;color:white;}/* ... many more styles */";
}
Propose a set of CSS variables (e.g., --primary-color, --text-color, --background-light) and show me how to define them in a :root block. Then, show me examples of how to replace specific hardcoded values in my existing CSS with these new CSS variables. Focus on the most common ones first like primary/secondary colors, text color, and background shades."

Phase 2: Implementation with Copilot & Manual Refactoring

Action: Create the :root block with the CSS variables suggested by Claude/Sonnet.

Prompt (VS Code with Copilot - iterative refactoring):
"Refactor the following CSS block to use a CSS variable named --primary-color instead of #007cba:

CSS
.button.primary{background:#007cba;color:white;}
"Refactor this CSS to use --background-light instead of #f8f9fa and --text-color instead of #333:

CSS
.css-animation-builder{font-family:-apple-system,...;line-height:1.6;color:#333;max-width:1200px;margin:0 auto;padding:2rem;}
Repeat this process for other key colors and values, prompting Copilot for specific replacements.

Improvement 3: Modular Keyframe Definitions

Phase 1: Design & Plan with Claude/Sonnet

Prompt (to Claude/Sonnet):
"My getKeyframes method currently stores all keyframe strings in a large associative array. This becomes unwieldy. I want to refactor this so that each animation's keyframes are stored in a separate file, perhaps in a Keyframes subdirectory within my project.

Here's my current getKeyframes method:

PHP
private function getKeyframes(string $animation):string{
    if(isset($this->customAnimations[$animation])){ /* ... */ }
    $keyframes=[
        'fadeIn'=>'0%{opacity:0;}100%{opacity:1;}',
        'fadeOut'=>'0%{opacity:1;}100%{opacity:0;}',
        // ... many more
    ];
    $keyframeContent=$keyframes[$animation]??'0%{opacity:0;}100%{opacity:1;}';
    return "@keyframes $animation{\n$keyframeContent\n}";
}
Describe the directory structure I should create (e.g., src/Keyframes/). Then, provide the revised PHP code for the getKeyframes method that attempts to load keyframes from these files first, falling back to a default if the file isn't found. Also, give an example of the content for a src/Keyframes/FadeIn.css file."

Phase 2: Implementation with Copilot & Manual File Creation

Action: Create the Keyframes directory as suggested.

Prompt (VS Code with Copilot):
"Create a new file src/Keyframes/FadeIn.css. The content should be just the keyframe rules, without the @keyframes wrapper.
0% { opacity: 0; } 100% { opacity: 1; }"
Repeat for several other keyframe files, using Copilot to generate the content based on the original array.

Action: Copy the revised getKeyframes method provided by Claude/Sonnet and paste it into your Builder.php file.

Prompt (VS Code with Copilot):
"In my getInlineScript() JavaScript function, the getKeyframes JS function also uses a large inline object. Refactor this JavaScript getKeyframes function to fetch keyframes dynamically if they were stored externally, or at least mirror the PHP logic by trying to find it in a more organized way if I decide to embed them as separate JS variables. For now, assume I'll stick to the inline JS object, but show how I could make it more modular, perhaps by referencing a global keyframesData object where each property holds the keyframe string."
(This prompt helps you think about the JS side, even if you decide to keep it inline for now, guiding towards a modular approach.)

General Prompts to Use Throughout

For Code Review/Refinement (Claude/Sonnet):
"Review this code snippet/method: [paste code here]. Are there any performance optimizations, potential bugs, or areas for increased readability/maintainability? Suggest improvements."

For Test Cases (Claude/Sonnet):
"For the generateCSS method, provide a few edge-case test scenarios and their expected CSS output. Consider invalid animation names or unusual option combinations."

For Docblock Generation (Copilot in VS Code):
Simply type /** above any new or modified method, and Copilot will often suggest the appropriate PHPDoc block. Hit Enter to accept.

For Renaming/Refactoring (Copilot in VS Code):
Select a variable or method name, right-click, and choose "Rename Symbol" (F2). Copilot can suggest intelligent renames.

For Debugging/Explaining (Claude/Sonnet):
"I'm encountering an issue where [describe problem]. Here's the relevant code: [paste code]. What could be causing this, and how can I debug it?"

By systematically using these types of prompts, you can guide your AI agents to not only implement features but also refine, optimize, and make your CSSAnimationBuilder class more robust and maintainable.