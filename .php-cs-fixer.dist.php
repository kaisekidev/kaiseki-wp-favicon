<?php

declare(strict_types=1);

use Kaiseki\CodingStandard\PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests'
    ]);

return Config::get($finder);
