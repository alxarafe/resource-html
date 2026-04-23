<?php

declare(strict_types=1);

namespace Alxarafe\ResourceHtml;

use Alxarafe\ResourceController\Contracts\RendererContract;

/**
 * HtmlRenderer — RendererContract implementation using pure PHP.
 *
 * It extracts data variables and includes .phtml or .php files.
 * Inside templates, $this refers to the HtmlRenderer instance,
 * allowing recursive rendering via echo $this->render('partial', $data);
 */
class HtmlRenderer implements RendererContract
{
    /** @var string[] */
    private array $paths;

    /**
     * @param string|string[] $templatePaths Directories where templates are located.
     */
    public function __construct(string|array $templatePaths)
    {
        $this->paths = is_array($templatePaths) ? $templatePaths : [$templatePaths];
    }

    #[\Override]
    public function render(string $template, array $data = []): string
    {
        $file = $this->findTemplate($template);
        if ($file === null) {
            throw new \RuntimeException("Template not found: {$template}");
        }

        $render = function (string $__file, array $__data): string {
            extract($__data, EXTR_SKIP);
            ob_start();
            include $__file;
            return (string) ob_get_clean();
        };

        return $render($file, $data);
    }

    #[\Override]
    public function addTemplatePath(string $path): void
    {
        array_unshift($this->paths, $path);
    }

    private function findTemplate(string $template): ?string
    {
        $template = str_replace('.', '/', $template);
        $extensions = ['.phtml', '.php', '.html'];
        
        $hasExtension = false;
        foreach ($extensions as $ext) {
            if (str_ends_with($template, $ext)) {
                $hasExtension = true;
                break;
            }
        }

        $candidates = $hasExtension ? [$template] : [$template . '.phtml', $template . '.php', $template . '.html'];

        foreach ($candidates as $candidate) {
            foreach ($this->paths as $path) {
                $file = rtrim($path, '/') . '/' . ltrim($candidate, '/');
                if (is_file($file)) {
                    return $file;
                }
            }
        }

        return null;
    }
}
