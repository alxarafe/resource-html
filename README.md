# alxarafe/resource-html

![PHP Version](https://img.shields.io/badge/PHP-8.2+-blueviolet?style=flat-square)
![CI](https://github.com/alxarafe/resource-html/actions/workflows/ci.yml/badge.svg)
![Tests](https://github.com/alxarafe/resource-html/actions/workflows/tests.yml/badge.svg)
![Static Analysis](https://img.shields.io/badge/static%20analysis-PHPStan%20%2B%20Psalm-blue?style=flat-square)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/alxarafe/resource-html/issues)

**HTML adapter for alxarafe/resource-controller.**

Provides a `RendererContract` implementation using pure PHP and HTML templates (`.phtml` or `.php`).

## Ecosystem

| Package | Purpose | Status |
|---|---|---|
| **[resource-controller](https://github.com/alxarafe/resource-controller)** | Core CRUD engine + UI components | ✅ Stable |
| **[resource-eloquent](https://github.com/alxarafe/resource-eloquent)** | Eloquent ORM adapter | ✅ Stable |
| **[resource-blade](https://github.com/alxarafe/resource-blade)** | Blade template renderer adapter | ✅ Stable |
| **[resource-twig](https://github.com/alxarafe/resource-twig)** | Twig template renderer adapter | ✅ Stable |
| **[resource-html](https://github.com/alxarafe/resource-html)** | Pure PHP/HTML template renderer adapter | ✅ Stable |

## Installation

```bash
composer require alxarafe/resource-html
```

This will also install `alxarafe/resource-controller` as a dependency.

## Usage

```php
use Alxarafe\ResourceHtml\HtmlRenderer;

// Create a renderer with template paths
$renderer = new HtmlRenderer(
    templatePaths: [__DIR__ . '/views']
);

// Render a template (automatically resolves .phtml or .php)
echo $renderer->render('products/index', [
    'title' => 'Products',
    'items' => $products,
]);

// Add additional template paths at runtime
$renderer->addTemplatePath(__DIR__ . '/module-views');
```

### Template example (`views/products/index.phtml`)

```php
<h1><?= htmlspecialchars($title) ?></h1>
<ul>
<?php foreach ($items as $item): ?>
    <li><?= htmlspecialchars($item['name']) ?> — <?= $item['price'] ?></li>
<?php endforeach; ?>
</ul>

<!-- Include sub-templates recursively using the renderer instance -->
<?= $this->render('partials/footer', ['year' => date('Y')]) ?>
```

## Development

### Docker

```bash
docker compose up -d
docker exec alxarafe-html composer install
```

### Running the CI pipeline locally

```bash
bash bin/ci_local.sh
```

### Running tests only

```bash
bash bin/run_tests.sh
```

## License

GPL-3.0-or-later
