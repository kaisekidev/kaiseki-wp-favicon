<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\Favicon;

use Kaiseki\WordPress\Config\Config;
use Psr\Container\ContainerInterface;

final class FaviconFactory
{
    public function __invoke(ContainerInterface $container): Favicon
    {
        $config = Config::get($container);
        return new Favicon(
            $config->string('favicon/template'),
            $config->string('favicon/admin_template'),
            $config->string('favicon/path'),
            $config->string('favicon/admin_path'),
            $config->bool('favicon/show_in_admin'),
            $config->bool('favicon/relative_to_root')
        );
    }
}
