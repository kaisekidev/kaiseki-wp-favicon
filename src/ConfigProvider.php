<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\Favicon;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'favicon' => [
                'path' => '',
                'admin_path' => '',
                'show_in_admin' => true,
            ],
            'hook' => [
                'provider' => [
                    Favicon::class,
                ],
            ],
            'dependencies' => [
                'aliases' => [],
                'factories' => [
                    Favicon::class => FaviconFactory::class,
                ],
            ],
        ];
    }
}
