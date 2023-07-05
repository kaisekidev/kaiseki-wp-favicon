# kaiseki/container-builder

> Create a PSR-11 dependency injection container with laminas-servicemanager and laminas-di_

---

## Table of Contents

- [kaiseki/container-builder](#kaisekicontainer-builder)
    - [Table of Contents](#table-of-contents)
    - [Summary](#summary)
    - [Why you should use it?](#why-you-should-use-it)
    - [Technical Details](#technical-details)
    - [Usage (in a WordPress theme)](#usage-in-a-wordpress-theme)
        - [Installation](#installation)
        - [Setup](#setup)
        - [Config Providers](#config-providers)

## Summary

This package is a bare-bone implementation that allows you to set up a dependency injection (DI) container quickly and
easily. Use this package to build high-quality WordPress themes and plugins with modern PHP development methods.

It's not limited to WordPress though. That's just what we use it for. You can technically utilize it wherever you want.

## Why you should use it?

While it may be daunting or seem like overhead at a first glance to use a DI container, it has many advantages. Once
you clear the first hurdle of learning the basics, you will never want to go back doing things the *old* way.

To counter your first concern: **No, this is not a framework.** This package is simply a ready-to-use implementation
to get you going with writing clean and awesome quality-code quickly. What you make of it is up to you.

But let's get back to the advantages of using a DI container:

1. Firstly, you'll learn how to become a better developer.
2. You will create cleaner and more readable code.
3. Become more productive by creating reusable packages.
4. Maintaining large projects becomes much easier.
5. Your code will be more testable.

## Technical Details

**Important:** You will need [composer](https://getcomposer.org/) and set up
[autoloading](https://getcomposer.org/doc/01-basic-usage.md#autoloading) to use this package.

The container builder creates a [PSR-11](http://www.php-fig.org/psr/psr-11/) container, configured to use
[laminas-servicemanager](https://docs.laminas.dev/laminas-servicemanager) and [laminas-di](https://docs.laminas.dev/laminas-di).

After you have set up the autoloading and use the container builder you are ready to use dependency injection in your code.

What does the DI container do for you:

- Have it autowire your classes and packages for you.
- Require and use third-party composer packages quickly to easily extend your code.
- Reuse code you have already written.
- Create your desired namespaces and folder structure without any restrictions (other than conforming to [PSR-4](https://www.php-fig.org/psr/psr-4/)) and everything will work out of the box.
- Enjoy advanced code completion inside your IDE.
- Centralize your configuration instead of having it scattered all over the project.

## Usage (in a WordPress theme)

We'll explain the usage of this package inside a WordPress theme.

Typically `kaiseki/container-builder` is used in combination with packages that provide
[**ConfigProviders**](#config-providers). [**ConfigProviders**](#config-providers) are simple callables without
dependencies, that return a config array.

In our example we additionaly set up the [kaiseki/wp-hook](https://github.com/kaisekidev/kaiseki-wp-hook) package, that we use in
many projects ourselves. It helps us to quickly register packages that will automatically set themselves up by hooking
into WordPress actions and filters. This step is purely optional.

### Installation

```bash
composer require kaiseki/container-builder
```

### Setup

Add this to the top of your theme's `functions.php` file:

```php
<?php

declare(strict_types=1);

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new RuntimeException('Autoloader is not installed. Please run "composer install".');
}
require __DIR__ . '/vendor/autoload.php';

$container = (new \Kaiseki\ContainerBuilder\ContainerBuilder(require __DIR__ . '/resources/config-providers.php'))
    ->withConfigFolder(__DIR__ . '/resources/config')
    ->build();
```

First, we'll define the path to a file `resources/config-providers.php` that returns an array of
[ConfigProviders](#config-providers) that we wish to load. More on that later.

Next we define the folder that will contain our configuration files with `withConfigFolder()`. All files inside this
folder ending with `.global.php` will be loaded first and files ending with `.local.php` will be loaded last. This
allows you to override settings in the global config with local settings (which you should obviously add to `.gitignore`).

In the last step, we build our container with `build()`.

### Install and initialize the `wp-hook` package (optional)

Now that our container is built we can initialize the [kaiseki/wp-hook](https://github.com/kaisekidev/kaiseki-wp-hook) package.
All packages that want to hook into WordPress actions and filters will do so at this point.

Install [kaiseki/wp-hook](https://github.com/kaisekidev/kaiseki-wp-hook) first,

```bash
composer require kaiseki/wp-hook
```

Then add this line of code after the container was built.

```php
// Call the HookCallbackProviderInterface to register hooks
$container->get(\Kaiseki\WordPress\Hook\HookCallbackProviderInterface::class)->registerCallbacks();
```

### Config Providers

So what's actually a ConfigProvider?

In the most basic sense, they return a configuration array.

Often they will contain information about dependencies.

ConfigProviders are for example the place where you instruct your application which factory should create a Class that
gets injected into another Class.

They also contain aliases so your application knows which implementation of an Interface to inject into a Class that
depends on it.

You can read more on that by checking out the documentation for the
[laminas-servicemanager](https://docs.laminas.dev/laminas-servicemanager/configuring-the-service-manager/).

In our case we want to load our two packages' ConfigProviders so we'll add those to `resources/config-providers.php`:

```php
<?php

return [
    \Kaiseki\WordPress\Config\ConfigProvider::class,
    \Kaiseki\WordPress\Hook\ConfigProvider::class,
];
```
