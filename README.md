Pluggable Web Engine
===

Lightweight PHP framework, BlazeMeter fork of [undera/pwe](https://github.com/undera/pwe).
It runs [gettaurus.org](https://gettaurus.org).

Requirements
---

- PHP 8.3 or newer (tested with 8.3, 8.4 and 8.5)
- PHP extensions: ctype, dom, json, posix, xml
- Apache with `mod_rewrite`, the root `.htaccess` routes requests to `index.php`

Installation
---

The package is not published on Packagist, install it from this repository:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/Blazemeter/pwe" }
    ],
    "require": {
        "blazemeter/pwe": "^2.0"
    }
}
```

Syntax highlighting of code blocks in SimpleWiki pages needs [GeSHi](https://github.com/easybook/geshi),
which is optional because of its GPL-2.0 license. Require `easybook/geshi` in your application to enable it,
without it code blocks are rendered unhighlighted.

Tests
---

```
composer install
vendor/bin/phpunit
```

Changes from upstream (2.0.0)
---

- PHP 8.3+ support (PHP 7 is no longer supported)
- wiki rendering based on [jelix/wikirenderer](https://github.com/laurentj/wikirenderer) 3.1 instead of the
  unmaintained `amaury/wikirenderer`
- Smarty 5 instead of Smarty 3
- PHP errors converted to exceptions as before, deprecations are only logged
- Doctrine DBAL integration removed
- GeSHi is an optional dependency
- `.htaccess` denies direct access to `vendor/`, `composer.json`, `composer.lock` and `cfg.php`
- unit tests run with PHPUnit 12

License
---

Apache License 2.0, see [LICENSE.TXT](LICENSE.TXT). Originally written by Andrey Pokhilko.
