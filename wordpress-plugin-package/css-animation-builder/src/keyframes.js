// Auto-generated keyframes from CSS files
const keyframes = {
    bounceIn: '0% { transform: scale(var(--transform-scale-xs)); opacity: var(--opacity-transparent); }\n    50% { transform: scale(var(--transform-scale-lg)); opacity: var(--opacity-opaque); }\n    70% { transform: scale(0.9); opacity: var(--opacity-opaque); }\n    100% { transform: scale(var(--transform-scale-md)); opacity: var(--opacity-opaque); }',
    drawLine: '0% { stroke-dashoffset: 1000; }\n    100% { stroke-dashoffset: 0; }',
    fadeIn: '0% { opacity: var(--opacity-transparent); }\n    100% { opacity: var(--opacity-opaque); }',
    fadeOut: '0% { opacity: var(--opacity-opaque); }\n    100% { opacity: var(--opacity-transparent); }',
    handwriting: '0% { opacity: 0; transform: translateY(10px) rotate(-2deg); }\n    25% { opacity: 0.3; transform: translateY(5px) rotate(-1deg); }\n    50% { opacity: 0.7; transform: translateY(0px) rotate(0deg); }\n    75% { opacity: 0.9; transform: translateY(-2px) rotate(1deg); }\n    100% { opacity: 1; transform: translateY(0px) rotate(0deg); }',
    pulse: '0% { transform: scale(1); }\n    50% { transform: scale(1.1); }\n    100% { transform: scale(1); }',
    rotateIn: '0% { transform: rotate(0deg); }\n    100% { transform: rotate(360deg); }',
    shake: '0%, 100% { transform: translateX(0px); }\n    10%, 30%, 50%, 70%, 90% { transform: translateX(calc(-1 * var(--transform-translate-xs))); }\n    20%, 40%, 60%, 80% { transform: translateX(var(--transform-translate-xs)); }',
    signatureDraw: '0% { \n        opacity: 0; \n        stroke-dashoffset: 500; \n        transform: translateX(-5px) translateY(3px) rotate(-3deg); \n    }\n    25% { \n        opacity: 0.3; \n        stroke-dashoffset: 375; \n        transform: translateX(-3px) translateY(2px) rotate(-2deg); \n    }\n    50% { \n        opacity: 0.6; \n        stroke-dashoffset: 250; \n        transform: translateX(-1px) translateY(1px) rotate(-1deg); \n    }\n    75% { \n        opacity: 0.8; \n        stroke-dashoffset: 125; \n        transform: translateX(0px) translateY(0px) rotate(0deg); \n    }\n    100% { \n        opacity: 1; \n        stroke-dashoffset: 0; \n        transform: translateX(0px) translateY(0px) rotate(0deg); \n    }',
    slideInDown: '0% { transform: translateY(-100%); opacity: 0; }\n    100% { transform: translateY(0); opacity: 1; }',
    slideInLeft: '0% { transform: translateX(-100%); opacity: var(--opacity-transparent); }\n    100% { transform: translateX(0); opacity: var(--opacity-opaque); }',
    slideInRight: '0% { transform: translateX(100%); opacity: 0; }\n    100% { transform: translateX(0); opacity: 1; }',
    slideInUp: '0% { transform: translateY(100%); opacity: 0; }\n    100% { transform: translateY(0); opacity: 1; }',
    swing: '0% { transform: rotate(-10deg); }\n    25% { transform: rotate(10deg); }\n    50% { transform: rotate(-5deg); }\n    75% { transform: rotate(5deg); }\n    100% { transform: rotate(0deg); }',
    typewriter: '0% { width: 0; }\n    100% { width: 100%; }',
    wobble: '0%, 100% { transform: rotate(0deg); }\n    15% { transform: rotate(5deg); }\n    30% { transform: rotate(-5deg); }\n    45% { transform: rotate(3deg); }\n    60% { transform: rotate(-3deg); }\n    75% { transform: rotate(2deg); }',
    writeText: '0% { \n        opacity: 0; \n        transform: translateX(-10px) translateY(5px) rotate(-5deg) scale(0.8); \n    }\n    50% { \n        opacity: 0.7; \n        transform: translateX(-2px) translateY(2px) rotate(-1deg) scale(0.95); \n    }\n    100% { \n        opacity: 1; \n        transform: translateX(0px) translateY(0px) rotate(0deg) scale(1); \n    }',
    zoomIn: '0% { transform: scale(0); opacity: 0; }\n    100% { transform: scale(1); opacity: 1; }',
    zoomOut: '0% { transform: scale(1); opacity: 1; }\n    100% { transform: scale(0); opacity: 0; }'
};

// Export for use in main script
if (typeof window !== 'undefined') {
    window.animationKeyframes = keyframes;
} else if (typeof module !== 'undefined') {
    module.exports = keyframes;
}
