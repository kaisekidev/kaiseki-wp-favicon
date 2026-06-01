# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-06-01

First tagged release.

### Added

- `Favicon` hook provider — renders favicon, SVG icon, Apple touch icon and web-manifest `<link>` tags
  on `wp_head`, `login_head` and the admin, driven by the `favicon` config key. Wired by `ConfigProvider`
  and `FaviconFactory`.

### Changed

- **BC:** adopted the `kaiseki/wp-hook` 2.0 API — `Favicon` now implements `HookProviderInterface` and
  exposes `addHooks()` (was `HookCallbackProviderInterface::registerHookCallbacks()`).
- **BC:** updated for `kaiseki/config` 2.0 — `FaviconFactory` uses `Config::fromContainer()` and the
  `.` config-key delimiter (`favicon.path` etc., was `favicon/path`).
- PHP requirement is `^8.2` (PHP 8.4 is the primary target); `thecodingmachine/safe` bumped to `^2.0`
  (aligned with `kaiseki/config`).
- Converted the toolchain from PHP_CodeSniffer to the shared `kaiseki/php-coding-standard` php-cs-fixer
  config; modernized PHPStan 2 / PHPUnit 11 / composer-require-checker 4; dropped the bespoke
  `deploy`/`phpstan-pro` scripts. CI now runs via the reusable workflow in `kaisekidev/.github`
  (`coverage-threshold: 30` — only `ConfigProvider` is currently tested).
- Fixed the package `homepage`/`support` URLs (were missing the `kaiseki-` repo prefix).
