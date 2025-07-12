<?php
namespace Reia\CSSAnimationBuilder;
class Builder{
private $config;
private $animations;
private $customAnimations=[];
private $presets=[];
private static $defaultConfig=[
'theme'=>'default','showPreview'=>true,'showCode'=>true,'showPresets'=>true,'showAdvanced'=>true,'cssPrefix'=>'animated-',
'animations'=>['fadeIn','fadeOut','slideInLeft','slideInRight','slideInUp','slideInDown','zoomIn','zoomOut','bounceIn','rotateIn','pulse','shake','wobble','swing','typewriter','handwriting','drawLine','writeText','signatureDraw'],
'defaults'=>['duration'=>1.0,'delay'=>0.0,'timingFunction'=>'ease','iterationCount'=>1,'direction'=>'normal','fillMode'=>'none','transformOrigin'=>'center'],
'presets'=>['attention'=>['type'=>'pulse','duration'=>1,'count'=>'infinite'],'bounce'=>['type'=>'bounceIn','duration'=>1.2,'timing'=>'cubic-bezier(0.68, -0.55, 0.265, 1.55)'],'elegant'=>['type'=>'fadeIn','duration'=>2,'delay'=>0.5,'timing'=>'ease-out'],'slide'=>['type'=>'slideInLeft','duration'=>0.8,'delay'=>0.2],'zoom'=>['type'=>'zoomIn','duration'=>0.6,'timing'=>'ease-out'],'rotate'=>['type'=>'rotateIn','duration'=>1,'timing'=>'ease-in-out'],'typewriter'=>['type'=>'typewriter','duration'=>3,'timing'=>'steps(30, end)'],'handwriting'=>['type'=>'handwriting','duration'=>2.5,'timing'=>'ease-in-out'],'signature'=>['type'=>'signatureDraw','duration'=>4,'timing'=>'ease-in-out'],'reveal'=>['type'=>'writeText','duration'=>2,'timing'=>'ease-out']]
];
public function __construct(array $config=[]){
$this->config=array_merge(self::$defaultConfig,$config);
$this->animations=$this->config['animations'];
$this->presets=$this->config['presets'];
$this->initializeCustomAnimations();
}
private function initializeCustomAnimations(){
if(isset($this->config['customAnimations'])){
foreach($this->config['customAnimations'] as $name=>$animation){
$this->addCustomAnimation($name,$animation);
}}}
public function addCustomAnimation(string $name,array $animation):self{
$this->customAnimations[$name]=array_merge(['name'=>ucfirst($name),'keyframes'=>'','defaultDuration'=>1.0,'defaultTiming'=>'ease'],$animation);
if(!in_array($name,$this->animations)){$this->animations[]=$name;}
return $this;
}
public function getAnimations():array{return $this->animations;}
public function getCustomAnimations():array{return $this->customAnimations;}
public function getPresets():array{return $this->presets;}
public function addPreset(string $name,array $preset):self{
$this->presets[$name]=$preset;return $this;
}
public function setTheme(string $theme):self{
$this->config['theme']=$theme;return $this;
}

public function generateCSS(string $animation,array $options=[]):string{
$options=array_merge($this->config['defaults'],$options);
$className=$this->config['cssPrefix'].strtolower($animation);
$css=".".$className."{animation-name:".$animation.";animation-duration:".$options['duration']."s;animation-delay:".$options['delay']."s;animation-timing-function:".$options['timingFunction'].";animation-iteration-count:".$options['iterationCount'].";animation-direction:".$options['direction'].";animation-fill-mode:".$options['fillMode'].";transform-origin:".$options['transformOrigin'].";";
if($animation==='typewriter'){
$css.="overflow:hidden;white-space:nowrap;border-right:var(--border-width-medium) solid;font-family:'Courier New',monospace;";
}elseif(in_array($animation,['handwriting','drawLine','signatureDraw'])){
$css.="font-family:'Caveat','Dancing Script',cursive;position:relative;";
if($animation==='handwriting'){$css.="transform:rotate(-1deg);letter-spacing:0.02em;";}
}elseif($animation==='writeText'){
$css.="overflow:hidden;white-space:nowrap;font-family:'Caveat','Dancing Script',cursive;position:relative;";
}
$css.="}\n";
if($animation==='typewriter'){
$css.=".".$className."::after{content:'';animation:typewriter-cursor var(--duration-slow) infinite;}\n@keyframes typewriter-cursor{0%,50%{border-right-color:transparent;}51%,var(--element-width-full){border-right-color:currentColor;}}\n";
}
if($animation==='handwriting'){
$css.=".".$className."::after{content:'';position:absolute;bottom:-var(--transform-translate-xs);left:var(--spacing-sm);right:var(--spacing-sm);height:var(--element-height-divider);background:linear-gradient(90deg,transparent,currentColor,transparent);border-radius:var(--border-width-medium);opacity:0.7;animation:handwriting-underline ".$options['duration']."s ".$options['delay']."s ".$options['timingFunction']." ".$options['iterationCount'].";}\n@keyframes handwriting-underline{0%{width:0;left:50%;}var(--element-width-full){width:var(--element-width-80);left:var(--spacing-sm);}}\n";
}
$css.=$this->getKeyframes($animation);
return $css;
}

private function getKeyframes(string $animation):string{
if(isset($this->customAnimations[$animation])){
return "@keyframes $animation{\n".str_replace("\n","\n    ",trim($this->customAnimations[$animation]['keyframes']))."\n}";
}
$keyframes=[
'fadeIn'=>'0%{opacity:0;}var(--element-width-full){opacity:1;}',
'fadeOut'=>'0%{opacity:1;}var(--element-width-full){opacity:0;}',
'slideInLeft'=>'0%{transform:translateX(-var(--element-width-full));opacity:0;}var(--element-width-full){transform:translateX(0);opacity:1;}',
'slideInRight'=>'0%{transform:translateX(var(--element-width-full));opacity:0;}var(--element-width-full){transform:translateX(0);opacity:1;}',
'slideInUp'=>'0%{transform:translateY(var(--element-width-full));opacity:0;}var(--element-width-full){transform:translateY(0);opacity:1;}',
'slideInDown'=>'0%{transform:translateY(-var(--element-width-full));opacity:0;}var(--element-width-full){transform:translateY(0);opacity:1;}',
'zoomIn'=>'0%{transform:scale(0);opacity:0;}var(--element-width-full){transform:scale(var(--transform-scale-md));opacity:1;}',
'zoomOut'=>'0%{transform:scale(var(--transform-scale-md));opacity:1;}var(--element-width-full){transform:scale(0);opacity:0;}',
'bounceIn'=>'0%{transform:scale(var(--transform-scale-xs));opacity:0;}50%{transform:scale(var(--transform-scale-lg));opacity:0.8;}70%{transform:scale(0.9);opacity:0.9;}var(--element-width-full){transform:scale(var(--transform-scale-md));opacity:1;}',
'rotateIn'=>'0%{transform:rotate(-200deg);opacity:0;}var(--element-width-full){transform:rotate(0);opacity:1;}',
'pulse'=>'0%{transform:scale(var(--transform-scale-md));}50%{transform:scale(var(--transform-scale-xl));}var(--element-width-full){transform:scale(var(--transform-scale-md));}',
'shake'=>'0%,var(--element-width-full){transform:translateX(0);}var(--spacing-sm),30%,50%,70%,90%{transform:translateX(-var(--transform-translate-sm));}var(--element-width-20),var(--element-width-40),var(--element-width-60),var(--element-width-80){transform:translateX(var(--transform-translate-sm));}',
'wobble'=>'0%{transform:translateX(0%);}15%{transform:translateX(-25%) rotate(calc(-1 * var(--transform-rotate-sm)));}30%{transform:translateX(var(--element-width-20)) rotate(3deg);}45%{transform:translateX(-15%) rotate(-3deg);}var(--element-width-60){transform:translateX(var(--spacing-sm)) rotate(2deg);}75%{transform:translateX(-5%) rotate(-1deg);}var(--element-width-full){transform:translateX(0%);}',
'swing'=>'var(--element-width-20){transform:rotate(15deg);}var(--element-width-40){transform:rotate(calc(-1 * var(--transform-rotate-md)));}var(--element-width-60){transform:rotate(var(--transform-rotate-sm));}var(--element-width-80){transform:rotate(calc(-1 * var(--transform-rotate-sm)));}var(--element-width-full){transform:rotate(0deg);}',
'typewriter'=>'0%{width:0;}var(--element-width-full){width:var(--element-width-full);}',
'handwriting'=>'0%{stroke-dashoffset:var(--element-width-full);opacity:0;transform:translateY(var(--transform-translate-sm));}var(--spacing-sm){opacity:1;}var(--element-width-full){stroke-dashoffset:0%;opacity:1;transform:translateY(0);}',
'drawLine'=>'0%{stroke-dashoffset:1000;opacity:0.3;}var(--element-width-full){stroke-dashoffset:0;opacity:1;}',
'writeText'=>'0%{width:0;opacity:0;}1%{opacity:1;}var(--element-width-full){width:var(--element-width-full);opacity:1;}',
'signatureDraw'=>'0%{stroke-dashoffset:2000;opacity:0;}var(--spacing-sm){opacity:1;}var(--element-width-full){stroke-dashoffset:0;opacity:1;}'
];
$keyframeContent=$keyframes[$animation]??'0%{opacity:0;}var(--element-width-full){opacity:1;}';
return "@keyframes $animation{\n$keyframeContent\n}";
}

public function generateHTML(string $animation,array $options=[]):string{
$className=$this->config['cssPrefix'].strtolower($animation);
$html='<div class="'.$className.'">';
if($animation==='typewriter'){
$html.='<h2>Hello, I\'m a typewriter!</h2><p>This text will appear character by character...</p>';
}elseif(in_array($animation,['handwriting','writeText'])){
$html.='<h2>Beautiful Handwriting</h2><p>This text has an elegant, handwritten feel with smooth animations.</p>';
}elseif($animation==='signatureDraw'){
$html.='<h2>My Signature</h2><p>Watch as this signature draws itself smoothly.</p>';
}elseif($animation==='drawLine'){
$html.='<h2>Drawing Lines</h2><p>Perfect for underlines and decorative elements.</p>';
}else{
$html.='<h2>Your Animated Content</h2><p>This element will animate when the page loads.</p>';
}
$html.='</div>';
return $html;
}
public function render():string{
return $this->renderStyles().$this->renderHTML().$this->renderScript();
}

public function renderHTML():string{
$containerId='css-animation-builder-'.uniqid();
$theme=$this->config['theme'];
$html='<div id="'.$containerId.'" class="css-animation-builder theme-'.$theme.'"><div class="builder-container"><header class="builder-header"><h1>CSS Animation Builder</h1><p>Create beautiful CSS animations with our interactive builder.</p></header><div class="builder-wrapper"><div class="animation-controls">'.$this->renderControlTabs().$this->renderBasicControls();
if($this->config['showAdvanced']){$html.=$this->renderAdvancedControls();}
if($this->config['showPresets']){$html.=$this->renderPresetControls();}
$html.='<div class="action-buttons"><button id="preview-animation" class="button primary">Preview Animation</button><button id="generate-css" class="button secondary">Generate CSS</button><button id="reset-controls" class="button">Reset</button></div></div>';
if($this->config['showPreview']){$html.=$this->renderPreviewArea();}
if($this->config['showCode']){$html.=$this->renderCodeOutput();}
$html.='</div></div></div>';
return $html;
}

private function renderControlTabs():string{
$html='<div class="control-tabs"><button class="tab-button active" data-tab="basic">Basic</button>';
if($this->config['showAdvanced']){$html.='<button class="tab-button" data-tab="advanced">Advanced</button>';}
if($this->config['showPresets']){$html.='<button class="tab-button" data-tab="presets">Presets</button>';}
$html.='</div>';
return $html;
}
private function renderBasicControls():string{
$html='<div class="tab-content active" id="basic-tab"><div class="control-group"><label for="animation-type">Animation Type:</label><select id="animation-type">';
foreach($this->animations as $animation){
$name=isset($this->customAnimations[$animation])?$this->customAnimations[$animation]['name']:ucfirst($animation);
$html.='<option value="'.$animation.'">'.$name.'</option>';
}
$html.='</select></div><div class="control-group"><label for="duration">Duration (seconds):</label><input type="range" id="duration" min="0.1" max="5" step="0.1" value="'.$this->config['defaults']['duration'].'"><span class="value-display" id="duration-value">'.$this->config['defaults']['duration'].'s</span></div><div class="control-group"><label for="delay">Delay (seconds):</label><input type="range" id="delay" min="0" max="3" step="0.1" value="'.$this->config['defaults']['delay'].'"><span class="value-display" id="delay-value">'.$this->config['defaults']['delay'].'s</span></div><div class="control-group"><label for="timing-function">Timing Function:</label><select id="timing-function"><option value="ease">Ease</option><option value="ease-in">Ease In</option><option value="ease-out">Ease Out</option><option value="ease-in-out">Ease In Out</option><option value="linear">Linear</option><option value="cubic-bezier(0.25, 0.1, 0.25, 1)">Smooth</option><option value="cubic-bezier(0.68, -0.55, 0.265, 1.55)">Bounce</option></select></div><div class="control-group"><label for="iteration-count">Repeat:</label><select id="iteration-count"><option value="1">Once</option><option value="2">Twice</option><option value="3">3 times</option><option value="infinite">Infinite</option></select></div></div>';
return $html;
}
private function renderAdvancedControls():string{
return '<div class="tab-content" id="advanced-tab"><div class="control-group"><label for="transform-origin">Transform Origin:</label><select id="transform-origin"><option value="center">Center</option><option value="top">Top</option><option value="bottom">Bottom</option><option value="left">Left</option><option value="right">Right</option><option value="top left">Top Left</option><option value="top right">Top Right</option><option value="bottom left">Bottom Left</option><option value="bottom right">Bottom Right</option></select></div><div class="control-group"><label for="direction">Direction:</label><select id="direction"><option value="normal">Normal</option><option value="reverse">Reverse</option><option value="alternate">Alternate</option><option value="alternate-reverse">Alternate Reverse</option></select></div><div class="control-group"><label for="fill-mode">Fill Mode:</label><select id="fill-mode"><option value="none">None</option><option value="forwards">Forwards</option><option value="backwards">Backwards</option><option value="both">Both</option></select></div></div>';
}
private function renderPresetControls():string{
$html='<div class="tab-content" id="presets-tab"><div class="preset-grid">';
foreach($this->config['presets'] as $key=>$preset){
$name=ucfirst($key);
$html.='<button class="preset-button" data-preset="'.$key.'">'.$name.'</button>';
}
$html.='</div></div>';
return $html;
}
private function renderPreviewArea():string{
return '<div class="preview-area"><h3>Live Preview</h3><div class="preview-container"><div class="preview-element" id="preview-element"><div class="preview-content"><h4>Your Animation</h4><p>This element will animate based on your settings.</p></div></div></div><div class="preview-controls"><button id="play-preview" class="button">Play</button><button id="pause-preview" class="button">Pause</button><button id="restart-preview" class="button">Restart</button></div></div>';
}
private function renderCodeOutput():string{
return '<div class="css-output"><h3>Generated CSS</h3><div class="output-tabs"><button class="output-tab active" data-output="css">CSS</button><button class="output-tab" data-output="html">HTML</button><button class="output-tab" data-output="usage">Usage</button></div><div class="output-content active" id="css-output"><pre><code id="css-code">/* Your generated CSS will appear here */</code></pre><button id="copy-css" class="copy-button">Copy CSS</button></div><div class="output-content" id="html-output"><pre><code id="html-code"><!-- Your HTML example will appear here --></code></pre><button id="copy-html" class="copy-button">Copy HTML</button></div><div class="output-content" id="usage-output"><div class="usage-instructions"><h4>How to Use Your Animation</h4><ol><li>Copy the generated CSS code</li><li>Add it to your stylesheet</li><li>Apply the class to your HTML element</li><li>The animation will trigger automatically</li></ol></div></div></div>';
}

public function renderStyles():string{
$cssFile=__DIR__.'/../assets/css/animation-builder.css';
if(file_exists($cssFile)){return "<style>\n".file_get_contents($cssFile)."\n</style>\n";}
return "<style>\n".$this->getInlineStyles()."\n</style>\n";
}
private function getInlineStyles():string{
return ".css-animation-builder{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;line-height:1.6;color:var(--text-primary);max-width:1var(--layout-min-height-xxl);margin:0 auto;padding:var(--font-size-xxxl);}.builder-header{text-align:center;margin-bottom:3rem;}.builder-header h1{font-size:2.5rem;margin-bottom:var(--font-size-md);color:var(--text-dark);}.builder-wrapper{display:grid;grid-template-columns:1fr 1fr;grid-template-rows:auto auto;gap:var(--font-size-xxxl);}.animation-controls,.preview-area,.css-output{background:var(--bg-primary);padding:var(--font-size-xxxl);border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.1);}.css-output{grid-column:1/-1;}.control-tabs{display:flex;margin-bottom:var(--font-size-xxl);border-bottom:var(--border-width-medium) solid #eee;}.tab-button{background:none;border:none;padding:0.75rem var(--font-size-xxl);cursor:pointer;border-bottom:var(--border-width-medium) solid transparent;transition:all var(--duration-fast) ease;}.tab-button.active{border-bottom-color:var(--primary-color);color:var(--primary-color);}.tab-content{display:none;}.tab-content.active{display:block;}.control-group{margin-bottom:var(--font-size-xxl);}.control-group label{display:block;margin-bottom:0.5rem;font-weight:600;}.control-group input,.control-group select{width:var(--element-width-full);padding:0.5rem;border:var(--border-width-medium) solid var(--border-primary);border-radius:4px;font-size:var(--font-size-md);}.control-group input[type='range']{width:calc(var(--element-width-full) - var(--layout-min-height-sm));margin-right:var(--transform-translate-sm);}.value-display{display:inline-block;min-width:50px;font-weight:600;color:var(--primary-color);}.preset-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(var(--layout-min-height-xl),1fr));gap:var(--font-size-md);}.preset-button{padding:var(--font-size-md);background:var(--bg-secondary);border:var(--border-width-medium) solid var(--border-primary);border-radius:8px;cursor:pointer;transition:all var(--duration-fast) ease;}.preset-button:hover{border-color:var(--primary-color);background:var(--primary-color-light);}.action-buttons{display:flex;gap:var(--font-size-md);margin-top:var(--font-size-xxxl);}.button{padding:0.75rem var(--font-size-xxl);border:none;border-radius:4px;cursor:pointer;font-size:var(--font-size-md);transition:all var(--duration-fast) ease;}.button.primary{background:var(--primary-color);color:white;}.button.secondary{background:var(--secondary-color);color:white;}.button:hover{opacity:0.9;transform:translateY(-var(--border-width-thin));}.preview-container{background:var(--bg-secondary);padding:3rem;border-radius:8px;margin:var(--font-size-md) 0;text-align:center;min-height:var(--layout-min-height-xxl);display:flex;align-items:center;justify-content:center;}.preview-element{background:linear-gradient(135deg,var(--primary-color),var(--secondary-color));color:white;padding:var(--font-size-xxxl);border-radius:8px;box-shadow:0 4px 8px rgba(0,0,0,0.2);transform-origin:center;font-size:1.var(--font-size-xxxl);max-width:400px;}.preview-element h4{margin:0 0 var(--font-size-md) 0;font-size:var(--font-size-xxl);}.preview-element p{margin:0;line-height:1.4;}.preview-controls{display:flex;gap:var(--font-size-md);justify-content:center;}.output-tabs{display:flex;margin-bottom:var(--font-size-md);border-bottom:var(--border-width-medium) solid #eee;}.output-tab{background:none;border:none;padding:0.75rem var(--font-size-xxl);cursor:pointer;border-bottom:var(--border-width-medium) solid transparent;}.output-tab.active{border-bottom-color:var(--primary-color);color:var(--primary-color);}.output-content{display:none;position:relative;}.output-content.active{display:block;}.output-content pre{background:var(--bg-dark);color:var(--text-light);padding:var(--font-size-xxl);border-radius:8px;overflow-x:auto;font-family:'Courier New',monospace;margin:0;font-size:0.9rem;line-height:1.4;}.copy-button{position:absolute;top:var(--font-size-md);right:var(--font-size-md);background:var(--animation-success);color:white;border:none;padding:0.5rem var(--font-size-md);border-radius:4px;cursor:pointer;font-size:0.875rem;}.copy-button:hover{background:#218838;}.animated-typewriter{font-family:'Courier New',monospace;border-right:var(--border-width-medium) solid;animation:typewriter-cursor var(--duration-slow) infinite;}.animated-handwriting{font-family:'Caveat','Dancing Script',cursive;transform:rotate(-1deg);letter-spacing:0.02em;position:relative;}.animated-handwriting::after{content:'';position:absolute;bottom:-var(--transform-translate-xs);left:var(--spacing-sm);right:var(--spacing-sm);height:var(--element-height-divider);background:linear-gradient(90deg,transparent,currentColor,transparent);border-radius:var(--border-width-medium);opacity:0.7;}.animated-writetext{font-family:'Caveat','Dancing Script',cursive;overflow:hidden;white-space:nowrap;}.animated-signaturedraw{font-family:'Caveat','Dancing Script',cursive;position:relative;}.animated-drawline{font-family:'Caveat','Dancing Script',cursive;position:relative;}@import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&family=Dancing+Script:wght@400;600;700&display=swap');@media (max-width:768px){.builder-wrapper{grid-template-columns:1fr;}.action-buttons{flex-direction:column;}.preview-controls{flex-direction:column;align-items:center;}.preview-element{font-size:var(--font-size-md);padding:var(--font-size-xxl);}}";
}
public function renderScript():string{
$jsFile=__DIR__.'/../assets/js/animation-builder.js';
if(file_exists($jsFile)){return "<script>\n".file_get_contents($jsFile)."\n</script>\n";}
return "<script>\n".$this->getInlineScript()."\n</script>\n";
}
private function getInlineScript():string{
$animationsJson=json_encode($this->animations);
$presetsJson=json_encode($this->config['presets']);
$defaultsJson=json_encode($this->config['defaults']);
$customAnimationsJson=json_encode($this->customAnimations);
$cssPrefix=$this->config['cssPrefix'];
return "(function(){const animations=$animationsJson;const presets=$presetsJson;const defaults=$defaultsJson;const customAnimations=$customAnimationsJson;const cssPrefix='$cssPrefix';document.addEventListener('DOMContentLoaded',function(){initializeAnimationBuilder();});function initializeAnimationBuilder(){const tabButtons=document.querySelectorAll('.tab-button');const tabContents=document.querySelectorAll('.tab-content');tabButtons.forEach(button=>{button.addEventListener('click',()=>{const tabId=button.dataset.tab;tabButtons.forEach(btn=>btn.classList.remove('active'));tabContents.forEach(content=>content.classList.remove('active'));button.classList.add('active');document.getElementById(tabId+'-tab').classList.add('active');});});const outputTabs=document.querySelectorAll('.output-tab');const outputContents=document.querySelectorAll('.output-content');outputTabs.forEach(tab=>{tab.addEventListener('click',()=>{const outputId=tab.dataset.output;outputTabs.forEach(t=>t.classList.remove('active'));outputContents.forEach(content=>content.classList.remove('active'));tab.classList.add('active');document.getElementById(outputId+'-output').classList.add('active');});});const rangeInputs=document.querySelectorAll('input[type=\"range\"]');rangeInputs.forEach(input=>{const valueDisplay=document.getElementById(input.id+'-value');if(valueDisplay){input.addEventListener('input',()=>{valueDisplay.textContent=input.value+(input.id==='duration'||input.id==='delay'?'s':'');});}});function generateCSS(){const animationType=document.getElementById('animation-type').value;const duration=document.getElementById('duration').value;const delay=document.getElementById('delay').value;const timingFunction=document.getElementById('timing-function').value;const iterationCount=document.getElementById('iteration-count').value;const transformOrigin=document.getElementById('transform-origin').value;const direction=document.getElementById('direction').value;const fillMode=document.getElementById('fill-mode').value;const className=cssPrefix+animationType.toLowerCase();let css='/* Generated CSS Animation */\\n.'+className+' {\\n    animation-name: '+animationType+';\\n    animation-duration: '+duration+'s;\\n    animation-delay: '+delay+'s;\\n    animation-timing-function: '+timingFunction+';\\n    animation-iteration-count: '+iterationCount+';\\n    animation-direction: '+direction+';\\n    animation-fill-mode: '+fillMode+';\\n    transform-origin: '+transformOrigin+';';if(animationType==='typewriter'){css+='\\n    overflow: hidden;\\n    white-space: nowrap;\\n    border-right: var(--border-width-medium) solid;\\n    font-family: \\'Courier New\\', monospace;';}else if(['handwriting','drawLine','signatureDraw'].includes(animationType)){css+='\\n    font-family: \\'Caveat\\', \\'Dancing Script\\', cursive;\\n    position: relative;';if(animationType==='handwriting'){css+='\\n    transform: rotate(-1deg);\\n    letter-spacing: 0.02em;';}}else if(animationType==='writeText'){css+='\\n    overflow: hidden;\\n    white-space: nowrap;\\n    font-family: \\'Caveat\\', \\'Dancing Script\\', cursive;\\n    position: relative;';}css+='\\n}\\n\\n';if(animationType==='typewriter'){css+='.'+className+'::after {\\n    content: \\'\\';\\n    animation: typewriter-cursor var(--duration-slow) infinite;\\n}\\n\\n@keyframes typewriter-cursor {\\n    0%, 50% { border-right-color: transparent; }\\n    51%, var(--element-width-full) { border-right-color: currentColor; }\\n}\\n\\n';}if(animationType==='handwriting'){css+='.'+className+'::after {\\n    content: \\'\\';\\n    position: absolute;\\n    bottom: -var(--transform-translate-xs);\\n    left: var(--spacing-sm);\\n    right: var(--spacing-sm);\\n    height: var(--element-height-divider);\\n    background: linear-gradient(90deg, transparent, currentColor, transparent);\\n    border-radius: var(--border-width-medium);\\n    opacity: var(--opacity-transparent).7;\\n    animation: handwriting-underline '+duration+'s '+delay+'s '+timingFunction+' '+iterationCount+';\\n}\\n\\n@keyframes handwriting-underline {\\n    0% { width: 0; left: 50%; }\\n    var(--element-width-full) { width: var(--element-width-80); left: var(--spacing-sm); }\\n}\\n\\n';}css+='/* Keyframes for '+animationType+' */\\n'+getKeyframes(animationType);let html='<!-- HTML Example -->\\n<div class=\"'+className+'\">\\n';if(animationType==='typewriter'){html+='    <h2>Hello, I\\'m a typewriter!</h2>\\n    <p>This text will appear character by character...</p>\\n';}else if(['handwriting','writeText'].includes(animationType)){html+='    <h2>Beautiful Handwriting</h2>\\n    <p>This text has an elegant, handwritten feel with smooth animations.</p>\\n';}else if(animationType==='signatureDraw'){html+='    <h2>My Signature</h2>\\n    <p>Watch as this signature draws itself smoothly.</p>\\n';}else if(animationType==='drawLine'){html+='    <h2>Drawing Lines</h2>\\n    <p>Perfect for underlines and decorative elements.</p>\\n';}else{html+='    <h2>Your Animated Content</h2>\\n    <p>This element will animate when the page loads.</p>\\n';}html+='</div>';document.getElementById('css-code').textContent=css;document.getElementById('html-code').textContent=html;return{css,html,className};}function getKeyframes(animationType){if(customAnimations[animationType]){return '@keyframes '+animationType+' {\\n    '+customAnimations[animationType].keyframes.replace(/\\n/g,'\\n    ')+'\\n}';}const keyframes={fadeIn:'0% { opacity: var(--opacity-transparent); }\\n    var(--element-width-full) { opacity: var(--opacity-opaque); }',fadeOut:'0% { opacity: var(--opacity-opaque); }\\n    var(--element-width-full) { opacity: var(--opacity-transparent); }',slideInLeft:'0% { transform: translateX(-var(--element-width-full)); opacity: var(--opacity-transparent); }\\n    var(--element-width-full) { transform: translateX(0); opacity: var(--opacity-opaque); }',slideInRight:'0% { transform: translateX(var(--element-width-full)); opacity: var(--opacity-transparent); }\\n    var(--element-width-full) { transform: translateX(0); opacity: var(--opacity-opaque); }',slideInUp:'0% { transform: translateY(var(--element-width-full)); opacity: var(--opacity-transparent); }\\n    var(--element-width-full) { transform: translateY(0); opacity: var(--opacity-opaque); }',slideInDown:'0% { transform: translateY(-var(--element-width-full)); opacity: var(--opacity-transparent); }\\n    var(--element-width-full) { transform: translateY(0); opacity: var(--opacity-opaque); }',zoomIn:'0% { transform: scale(0); opacity: var(--opacity-transparent); }\\n    var(--element-width-full) { transform: scale(var(--transform-scale-md)); opacity: var(--opacity-opaque); }',zoomOut:'0% { transform: scale(var(--transform-scale-md)); opacity: var(--opacity-opaque); }\\n    var(--element-width-full) { transform: scale(0); opacity: var(--opacity-transparent); }',bounceIn:'0% { transform: scale(var(--transform-scale-xs)); opacity: var(--opacity-transparent); }\\n    50% { transform: scale(var(--transform-scale-lg)); opacity: var(--opacity-transparent).8; }\\n    70% { transform: scale(0.9); opacity: var(--opacity-transparent).9; }\\n    var(--element-width-full) { transform: scale(var(--transform-scale-md)); opacity: var(--opacity-opaque); }',rotateIn:'0% { transform: rotate(-200deg); opacity: var(--opacity-transparent); }\\n    var(--element-width-full) { transform: rotate(0); opacity: var(--opacity-opaque); }',pulse:'0% { transform: scale(var(--transform-scale-md)); }\\n    50% { transform: scale(var(--transform-scale-xl)); }\\n    var(--element-width-full) { transform: scale(var(--transform-scale-md)); }',shake:'0%, var(--element-width-full) { transform: translateX(0); }\\n    var(--spacing-sm), 30%, 50%, 70%, 90% { transform: translateX(-var(--transform-translate-sm)); }\\n    var(--element-width-20), var(--element-width-40), var(--element-width-60), var(--element-width-80) { transform: translateX(var(--transform-translate-sm)); }',wobble:'0% { transform: translateX(0%); }\\n    15% { transform: translateX(-25%) rotate(calc(-1 * var(--transform-rotate-sm))); }\\n    30% { transform: translateX(var(--element-width-20)) rotate(3deg); }\\n    45% { transform: translateX(-15%) rotate(-3deg); }\\n    var(--element-width-60) { transform: translateX(var(--spacing-sm)) rotate(2deg); }\\n    75% { transform: translateX(-5%) rotate(-1deg); }\\n    var(--element-width-full) { transform: translateX(0%); }',swing:'var(--element-width-20) { transform: rotate(15deg); }\\n    var(--element-width-40) { transform: rotate(calc(-1 * var(--transform-rotate-md))); }\\n    var(--element-width-60) { transform: rotate(var(--transform-rotate-sm)); }\\n    var(--element-width-80) { transform: rotate(calc(-1 * var(--transform-rotate-sm))); }\\n    var(--element-width-full) { transform: rotate(0deg); }',typewriter:'0% { width: 0; }\\n    var(--element-width-full) { width: var(--element-width-full); }',handwriting:'0% { \\n        stroke-dashoffset: var(--element-width-full); \\n        opacity: var(--opacity-transparent); \\n        transform: translateY(var(--transform-translate-sm));\\n    }\\n    var(--spacing-sm) { opacity: var(--opacity-opaque); }\\n    var(--element-width-full) { \\n        stroke-dashoffset: 0%; \\n        opacity: var(--opacity-opaque); \\n        transform: translateY(0);\\n    }',drawLine:'0% { \\n        stroke-dashoffset: 1000; \\n        opacity: var(--opacity-transparent).3;\\n    }\\n    var(--element-width-full) { \\n        stroke-dashoffset: 0; \\n        opacity: var(--opacity-opaque);\\n    }',writeText:'0% { \\n        width: 0; \\n        opacity: var(--opacity-transparent);\\n    }\\n    1% { opacity: var(--opacity-opaque); }\\n    var(--element-width-full) { \\n        width: var(--element-width-full); \\n        opacity: var(--opacity-opaque);\\n    }',signatureDraw:'0% { \\n        stroke-dashoffset: 2000; \\n        opacity: var(--opacity-transparent);\\n    }\\n    var(--spacing-sm) { opacity: var(--opacity-opaque); }\\n    var(--element-width-full) { \\n        stroke-dashoffset: 0; \\n        opacity: var(--opacity-opaque);\\n    }'};const keyframeContent=keyframes[animationType]||'0% { opacity: var(--opacity-transparent); } var(--element-width-full) { opacity: var(--opacity-opaque); }';return '@keyframes '+animationType+' {\\n    '+keyframeContent+'\\n}';}function previewAnimation(){const previewElement=document.getElementById('preview-element');const{className}=generateCSS();const animationType=document.getElementById('animation-type').value;previewElement.className='preview-element';if(animationType==='typewriter'){previewElement.classList.add('animated-typewriter');}else if(animationType==='handwriting'){previewElement.classList.add('animated-handwriting');}else if(animationType==='writeText'){previewElement.classList.add('animated-writetext');}else if(animationType==='signatureDraw'){previewElement.classList.add('animated-signaturedraw');}else if(animationType==='drawLine'){previewElement.classList.add('animated-drawline');}previewElement.offsetHeight;previewElement.classList.add(className);if(!document.getElementById('preview-styles')){const style=document.createElement('style');style.id='preview-styles';document.head.appendChild(style);}const styleSheet=document.getElementById('preview-styles');const{css}=generateCSS();styleSheet.textContent=css;}document.getElementById('preview-animation').addEventListener('click',previewAnimation);document.getElementById('generate-css').addEventListener('click',generateCSS);document.getElementById('play-preview').addEventListener('click',()=>{const previewElement=document.getElementById('preview-element');previewElement.style.animationPlayState='running';});document.getElementById('pause-preview').addEventListener('click',()=>{const previewElement=document.getElementById('preview-element');previewElement.style.animationPlayState='paused';});document.getElementById('restart-preview').addEventListener('click',previewAnimation);document.getElementById('copy-css').addEventListener('click',()=>{const cssCode=document.getElementById('css-code').textContent;navigator.clipboard.writeText(cssCode).then(()=>{const button=document.getElementById('copy-css');const originalText=button.textContent;button.textContent='Copied!';setTimeout(()=>{button.textContent=originalText;},2000);});});document.getElementById('copy-html').addEventListener('click',()=>{const htmlCode=document.getElementById('html-code').textContent;navigator.clipboard.writeText(htmlCode).then(()=>{const button=document.getElementById('copy-html');const originalText=button.textContent;button.textContent='Copied!';setTimeout(()=>{button.textContent=originalText;},2000);});});const presetButtons=document.querySelectorAll('.preset-button');presetButtons.forEach(button=>{button.addEventListener('click',()=>{const preset=button.dataset.preset;applyPreset(preset);});});function applyPreset(preset){const config=presets[preset];if(config){document.getElementById('animation-type').value=config.type;document.getElementById('duration').value=config.duration;document.getElementById('delay').value=config.delay||0;document.getElementById('timing-function').value=config.timing||'ease';document.getElementById('iteration-count').value=config.count||1;document.getElementById('duration-value').textContent=config.duration+'s';document.getElementById('delay-value').textContent=(config.delay||0)+'s';setTimeout(previewAnimation,100);}}generateCSS();}})();";
}
}";
