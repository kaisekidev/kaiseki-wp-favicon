<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\Favicon;

use Kaiseki\WordPress\Hook\HookCallbackProviderInterface;
use RuntimeException;

use function is_string;
use function ltrim;
use function printf;
use function rtrim;

use const PHP_URL_PATH;

class Favicon implements HookCallbackProviderInterface
{
    private string $template;
    private string $adminTemplate;
    private string $path;
    private string $adminPath;
    private bool $showInAdmin;
    private bool $relativeToRoot;

    public function __construct(
        string $template,
        string $adminTemplate,
        string $path,
        string $adminPath,
        bool $showInAdmin,
        bool $relativeToRoot
    ) {
        $this->template = $template;
        $this->adminTemplate = $adminTemplate;
        $this->path = $path;
        $this->adminPath = $adminPath;
        $this->showInAdmin = $showInAdmin;
        $this->relativeToRoot = $relativeToRoot;
    }

    public function registerCallbacks(): void
    {
        if (is_admin() === false) {
            add_filter('get_site_icon_url', '__return_false');
        }
        add_action('wp_head', [$this, 'renderFrontendFavicon']);
        if ($this->showInAdmin !== true) {
            return;
        }

        add_filter('get_site_icon_url', '__return_false');
        add_action('admin_head', [$this, 'renderAdminFavicon']);
    }

    public function renderFrontendFavicon(): void
    {
        $this->renderFavicon($this->getPath($this->path));
    }

    public function renderAdminFavicon(): void
    {
        printf($this->adminTemplate, $this->getPath($this->adminPath !== '' ? $this->adminPath : $this->path));
    }

    public function renderFavicon(string $path): void
    {
        printf($this->template, $this->getPath($path));
    }

    private function getPath(string $path): string
    {
        $themeUrlPath = \Safe\parse_url(get_stylesheet_directory_uri(), PHP_URL_PATH);
        if (!is_string($themeUrlPath)) {
            throw new RuntimeException('No string return by get_stylesheet_directory_uri()');
        }
        return $this->relativeToRoot === true
            ? $path
            : rtrim($themeUrlPath, '/') . '/' . ltrim($path, '/');
    }
}
