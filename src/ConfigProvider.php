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
                'template' => '<link rel="icon" href="%1$s/favicon.ico" sizes="any">
                               <link rel="icon" href="%1$s/favicon.svg" type="image/svg+xml">
                               <link rel="apple-touch-icon" href="%1$s/apple-touch-icon.png">
                               <link rel="manifest" href="%1$s/manifest.json">',
                'admin_template' => '<link rel="icon" href="%1$s/favicon.ico" sizes="any">
                                     <link rel="icon" href="%1$s/icon.svg" type="image/svg+xml">',
                'path' => '',
                'admin_path' => '',
                'show_in_admin' => true,
                'relative_to_root' => false,
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
