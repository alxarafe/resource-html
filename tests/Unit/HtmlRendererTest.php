<?php

declare(strict_types=1);

namespace Alxarafe\ResourceHtml\Tests\Unit;

use Alxarafe\ResourceHtml\HtmlRenderer;
use Alxarafe\ResourceController\Contracts\RendererContract;
use PHPUnit\Framework\TestCase;

class HtmlRendererTest extends TestCase
{
    private string $templatePath;

    protected function setUp(): void
    {
        $this->templatePath = sys_get_temp_dir() . '/html_test_templates_' . uniqid();
        mkdir($this->templatePath, 0755, true);
    }

    protected function tearDown(): void
    {
        $this->removeDir($this->templatePath);
    }

    private function removeDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($items as $item) {
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }
        rmdir($dir);
    }

    public function testImplementsRendererContract(): void
    {
        $renderer = new HtmlRenderer($this->templatePath);
        $this->assertInstanceOf(RendererContract::class, $renderer);
    }

    public function testRenderSimpleTemplate(): void
    {
        file_put_contents($this->templatePath . '/hello.phtml', 'Hello, <?= $name ?>!');

        $renderer = new HtmlRenderer($this->templatePath);
        $result = $renderer->render('hello', ['name' => 'World']);

        $this->assertSame('Hello, World!', $result);
    }

    public function testRenderWithInclude(): void
    {
        file_put_contents($this->templatePath . '/partial.phtml', 'Partial: <?= $val ?>');
        file_put_contents(
            $this->templatePath . '/main.phtml',
            'Main - <?= $this->render("partial", ["val" => $name]) ?>'
        );

        $renderer = new HtmlRenderer($this->templatePath);
        $result = $renderer->render('main', ['name' => 'Inner']);

        $this->assertSame('Main - Partial: Inner', $result);
    }

    public function testAutoAppendsExtension(): void
    {
        file_put_contents($this->templatePath . '/test.php', 'OK');

        $renderer = new HtmlRenderer($this->templatePath);
        $result = $renderer->render('test'); // Should find test.php since test.phtml doesn't exist

        $this->assertSame('OK', $result);
    }

    public function testAddTemplatePath(): void
    {
        $extraPath = sys_get_temp_dir() . '/html_extra_' . uniqid();
        mkdir($extraPath, 0755, true);
        file_put_contents($extraPath . '/extra.phtml', 'Extra template');

        $renderer = new HtmlRenderer($this->templatePath);
        $renderer->addTemplatePath($extraPath);
        $result = $renderer->render('extra');

        $this->assertSame('Extra template', $result);
        $this->removeDir($extraPath);
    }

    public function testThrowsExceptionIfNotFound(): void
    {
        $renderer = new HtmlRenderer($this->templatePath);
        $this->expectException(\RuntimeException::class);
        $renderer->render('missing_template');
    }
}
