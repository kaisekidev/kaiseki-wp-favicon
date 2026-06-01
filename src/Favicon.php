<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\Favicon;

use Kaiseki\WordPress\Hook\HookProviderInterface;

use function add_action;
use function add_filter;
use function get_stylesheet_directory_uri;
use function is_string;
use function ltrim;
use function printf;
use function rtrim;

use const PHP_URL_PATH;

class Favicon implements HookProviderInterface
{
    public function __construct(
        private readonly string $path,
        private readonly string $adminPath = '',
        private readonly bool $showInAdmin = true,
    ) {
    }

    public function addHooks(): void
    {
        add_action('wp_head', [$this, 'renderFrontendFavicon'], 5);
        add_action('login_head', [$this, 'renderFrontendFavicon'], 5);
        $this->registerAdminHookCallbacks();
    }

    private function registerAdminHookCallbacks(): void
    {
        $callback = '';
        if ($this->adminPath !== '') {
            $callback = 'renderAdminFavicon';
        } elseif ($this->path !== '' && $this->showInAdmin) {
            $callback = 'renderFrontendFavicon';
        }
        if ($callback === '') {
            return;
        }
        add_filter('get_site_icon_url', '__return_false');
        add_action('admin_head', [$this, $callback]);
    }

    public function renderFrontendFavicon(): void
    {
        if ($this->path === '') {
            return;
        }
        $this->renderFavicon($this->getPath($this->path));
    }

    public function renderAdminFavicon(): void
    {
        if ($this->adminPath === '') {
            return;
        }
        $this->renderFavicon($this->getPath($this->adminPath), true);
    }

    public function renderFavicon(string $path, bool $simple = false): void
    {
        printf(
            '<link rel="icon" href="%1$s/favicon.ico" sizes="any">' .
            '<link rel="icon" href="%1$s/icon.svg" type="image/svg+xml">',
            rtrim($path, '/'),
        );
        if ($simple === true) {
            return;
        }
        printf(
            '<link rel="apple-touch-icon" href="%1$s/apple-touch-icon.png">' .
            '<link rel="manifest" href="%1$s/manifest.json" crossOrigin="use-credentials">',
            rtrim($path, '/'),
        );
    }

    private function getPath(string $path): string
    {
        $themeUrlPath = \Safe\parse_url(get_stylesheet_directory_uri(), PHP_URL_PATH);
        if (!is_string($themeUrlPath)) {
            return ltrim($path, '/');
        }

        return rtrim($themeUrlPath, '/') . '/' . ltrim($path, '/');
    }
}
