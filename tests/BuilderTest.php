<?php

namespace Reia\CSSAnimationBuilder\Tests;

use PHPUnit\Framework\TestCase;
use Reia\CSSAnimationBuilder\Builder;

class BuilderTest extends TestCase
{
    private $builder;

    protected function setUp(): void
    {
        $this->builder = new Builder();
    }

    public function testCanCreateBuilderInstance()
    {
        $this->assertInstanceOf(Builder::class, $this->builder);
    }

    public function testCanCreateBuilderWithConfig()
    {
        $config = [
            'theme' => 'dark',
            'animations' => ['fadeIn', 'slideInLeft']
        ];
        
        $builder = new Builder($config);
        $this->assertInstanceOf(Builder::class, $builder);
    }

    public function testCanRenderHTML()
    {
        $html = $this->builder->render();
        $this->assertIsString($html);
        $this->assertStringContainsString('css-animation-builder', $html);
        $this->assertStringContainsString('Animation Builder', $html);
    }

    public function testCanGetAnimations()
    {
        $animations = $this->builder->getAnimations();
        $this->assertIsArray($animations);
        $this->assertNotEmpty($animations);
    }

    public function testCanGenerateCSS()
    {
        $css = $this->builder->generateCSS('fadeIn', [
            'duration' => 1.0,
            'delay' => 0.0,
            'timingFunction' => 'ease'
        ]);
        
        $this->assertIsString($css);
        $this->assertStringContainsString('@keyframes', $css);
        $this->assertStringContainsString('fadeIn', $css);
    }

    public function testCanSetTheme()
    {
        $this->builder->setTheme('dark');
        $html = $this->builder->render();
        $this->assertStringContainsString('theme-dark', $html);
    }

    public function testCanAddCustomAnimation()
    {
        $keyframes = '0% { opacity: 0; } 100% { opacity: 1; }';
        $this->builder->addCustomAnimation('customFade', $keyframes);
        
        $animations = $this->builder->getAnimations();
        $this->assertContains('customFade', $animations);
    }

    public function testGeneratesValidHTML()
    {
        $html = $this->builder->render();
        
        // Check for required elements
        $this->assertStringContainsString('<div class="css-animation-builder', $html);
        $this->assertStringContainsString('cab-controls', $html);
        $this->assertStringContainsString('cab-preview', $html);
        $this->assertStringContainsString('cab-code', $html);
    }

    public function testHandlesInvalidAnimationType()
    {
        $css = $this->builder->generateCSS('nonExistentAnimation', []);
        $this->assertStringContainsString('/* Animation not found */', $css);
    }

    public function testConfigValidation()
    {
        $config = [
            'theme' => 'invalid-theme',
            'animations' => []
        ];
        
        $builder = new Builder($config);
        $this->assertInstanceOf(Builder::class, $builder);
    }

    public function testEscapesUserInput()
    {
        $builder = new Builder([
            'customAnimations' => [
                'test<script>' => 'malicious content'
            ]
        ]);
        
        $html = $builder->render();
        $this->assertStringNotContainsString('<script>', $html);
    }
}
