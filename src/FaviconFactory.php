<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\Favicon;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

class FaviconFactory
{
    public function __invoke(ContainerInterface $container): Favicon
    {
        $config = Config::fromContainer($container);

        return new Favicon(
            $config->string('favicon.path'),
            $config->string('favicon.admin_path'),
            $config->bool('favicon.show_in_admin'),
        );
    }
}
