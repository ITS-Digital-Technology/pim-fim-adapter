# pim-fim-adapter
PIM/FIM 2.0 Adapter Composer Package - for PHP and WordPress based websites

## Requirements
- PHP 8.0+ (PHP Core on Server)
- ext-json (PHP Extension on Server)
- ext-mbstring (PHP Extension on Server)

## Installation
### Package Install
1. In the project you're wanting to integrate PIMFIMAdapter to (where your project's `composer.json` resides), run `composer require northeastern-web/pim-fim-adapter`.
2. Add a .env (copy `.env.example` in `.env` file) to project's root directory with constants or define constants in your PHP application's config (WordPress `wp-config.php`).

### Development Install
1. `cd` into project's root directory.
2. Run `composer install` on the command-line/terminal.
3. Add a .env (copy `.env.example` in `.env` file) to project's root directory with constants.