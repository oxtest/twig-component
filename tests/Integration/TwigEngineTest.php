<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\Twig\Tests\Integration;

use org\bovigo\vfs\vfsStream;
use OxidEsales\Twig\Resolver\TemplateChain\TemplateChainResolverInterface;
use OxidEsales\Twig\TwigEngine;
use OxidEsales\Twig\TwigEngineConfigurationInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TwigEngineTest extends TestCase
{
    use ProphecyTrait;

    private string $templateDirPath;
    private string $template;
    /** @var TemplateChainResolverInterface|ObjectProphecy */
    private $templateChainResolver;

    protected function setUp(): void
    {
        parent::setUp();
        $templateDir = vfsStream::setup($this->getTemplateDir());
        $this->template = vfsStream::newFile(
            $this->getTemplateName()
        )->at($templateDir)->setContent("{{ 'twig' }}")->url();
        $this->templateDirPath = vfsStream::url($this->getTemplateDir());
    }

    public function testExists(): void
    {
        $engine = $this->getEngine();
        $this->assertTrue($engine->exists($this->getTemplateName()));
        $this->assertFalse($engine->exists('foo'));
    }

    public function testAddGlobal(): void
    {
        $engine = $this->getEngine();
        $engine->addGlobal('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $engine->getGlobals());
        $this->assertNotEquals(['not_foo' => 'not_bar'], $engine->getGlobals());
    }

    public function testRender(): void
    {
        $engine = $this->getEngine();
        $this->templateChainResolver->getLastChild($this->getTemplateName())->willReturn($this->getTemplateName());

        $this->assertTrue(file_exists($this->template));

        $rendered = $engine->render($this->getTemplateName());

        $this->assertEquals('twig', $rendered);
        $this->assertNotEquals('foo', $rendered);
    }

    public function testRenderFragment(): void
    {
        $engine = $this->getEngine();
        $rendered = $engine->renderFragment("{{ 'twig' }}", 'ox:testid');
        $this->assertEquals('twig', $rendered);
    }

    private function getEngine(): TwigEngine
    {
        /** @var TwigEngineConfigurationInterface $configuration */
        $configuration = $this->getMockBuilder(TwigEngineConfigurationInterface::class)->getMock();
        $configuration->method('getParameters')
            ->willReturn([
                'template_dir' => [$this->templateDirPath],
                'is_debug' => 'false',
                'cache_dir' => 'foo',
            ]);

        $loader = new FilesystemLoader($this->templateDirPath);

        $engine = new Environment($loader);
        $this->templateChainResolver = $this->prophesize(TemplateChainResolverInterface::class);

        return new TwigEngine(
            $engine,
            $this->templateChainResolver->reveal()
        );
    }

    private function getTemplateName(): string
    {
        return 'testTwigTemplate.twig';
    }

    private function getTemplateDir(): string
    {
        return 'testTemplateDir';
    }
}
