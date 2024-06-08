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

## Usage

### Contentful Adapter
The `ContentfulAdapter.php` class file is intended to expose methods that interact with the Contentful API via the Contentful PHP SDK. Each method to get Entries requires a [Query](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html) object to be passed-in as a parameter. By Default, each Query will automatically resolve reference entries 1 level deep. Additional levels of Link resolution will need to occur via separate get Entry calls

Below is a list of methods available in the Contentful Adapter:

| Name | Description |
| ---- | ---- |
| `getEntries` | Get entries by custom [Query](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html) |
| `getEntriesByContentType` | Get entries by Content Type and custom Query

### PIM
