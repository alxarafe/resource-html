# alxarafe/resource-html

![PHP Version](https://img.shields.io/badge/PHP-8.2+-blueviolet?style=flat-square)
![CI](https://github.com/alxarafe/resource-html/actions/workflows/ci.yml/badge.svg)
![Tests](https://github.com/alxarafe/resource-html/actions/workflows/tests.yml/badge.svg)
![Static Analysis](https://img.shields.io/badge/static%20analysis-PHPStan%20%2B%20Psalm-blue?style=flat-square)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/alxarafe/resource-html/issues)

**Adaptador HTML para alxarafe/resource-controller.**

Proporciona una implementación de `RendererContract` usando PHP puro y plantillas HTML (`.phtml` o `.php`).

## Ecosistema

| Paquete | Propósito | Estado |
|---|---|---|
| **[resource-controller](https://github.com/alxarafe/resource-controller)** | Motor CRUD central + componentes UI | ✅ Estable |
| **[resource-eloquent](https://github.com/alxarafe/resource-eloquent)** | Adaptador ORM Eloquent | ✅ Estable |
| **[resource-blade](https://github.com/alxarafe/resource-blade)** | Adaptador de renderizado con Blade | ✅ Estable |
| **[resource-twig](https://github.com/alxarafe/resource-twig)** | Adaptador de renderizado con Twig | ✅ Estable |
| **[resource-html](https://github.com/alxarafe/resource-html)** | Adaptador de renderizado con plantillas PHP/HTML | ✅ Estable |

## Instalación

```bash
composer require alxarafe/resource-html
```

Esto también instalará `alxarafe/resource-controller` como dependencia.

## Uso

```php
use Alxarafe\ResourceHtml\HtmlRenderer;

// Crear un renderer con las rutas de plantillas
$renderer = new HtmlRenderer(
    templatePaths: [__DIR__ . '/views']
);

// Renderizar una plantilla (resuelve automáticamente .phtml o .php)
echo $renderer->render('products/index', [
    'title' => 'Productos',
    'items' => $products,
]);

// Añadir rutas de plantillas adicionales en tiempo de ejecución
$renderer->addTemplatePath(__DIR__ . '/module-views');
```

## Desarrollo

### Docker

```bash
docker compose up -d
docker exec alxarafe-html composer install
```

### Ejecutar el pipeline CI en local

```bash
bash bin/ci_local.sh
```

### Ejecutar solo los tests

```bash
bash bin/run_tests.sh
```

## Licencia

GPL-3.0-or-later
