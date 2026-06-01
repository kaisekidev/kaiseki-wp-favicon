# kaiseki/wp-favicon

Render favicon and touch-icon link tags on the WordPress front end, admin and login screens.

Point it at a directory containing `favicon.ico`, `icon.svg`, `apple-touch-icon.png` and
`manifest.json`; it prints the matching `<link>` tags on `wp_head`, `login_head` and (optionally)
`admin_head`, and disables WordPress' own site-icon output in the admin. Wired through `ConfigProvider`
and the `favicon` config key.

## Installation

```bash
composer require kaiseki/wp-favicon
```

Requires PHP 8.2 or newer.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator and configure the `favicon` key:

```php
use Kaiseki\WordPress\Favicon\Favicon;

return [
    'favicon' => [
        // Directory holding the icon assets, relative to the active theme directory
        // (the theme directory URI is prepended automatically).
        'path' => 'assets/favicon',
        // Optional separate directory for the admin; falls back to `path`.
        'admin_path' => '',
        // Whether to also render the favicon in the admin when no admin_path is set.
        'show_in_admin' => true,
    ],
    'hook' => [
        'provider' => [
            Favicon::class,
        ],
    ],
];
```

`ConfigProvider` registers `FaviconFactory`, which reads the `favicon` config. With `path` set, the
front-end and login tags are rendered; `admin_path` (or `show_in_admin`) controls the admin output.

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan
```

## License

MIT — see [LICENSE](LICENSE).
