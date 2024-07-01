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

## Configuration


## Usage
The PiM/FIM adapter package allows you to quickly query results from Contentful without having to build-up complex queries or know the content model. Each response in the PIM/FIM adapter classes returns a Contentful object, this can be converted to a Laravel collection, JSON, or other formats. 

You may see `test/index.php`, it is a testing file that can be used for development and validating responses for each adapter method.

### Contentful Adapter
The `ContentfulAdapter.php` class file is intended to expose methods that interact with the Contentful API via the Contentful PHP SDK. Each method to get Entries requires a [Query](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html) object to be passed-in as a parameter. By Default, each Query will automatically resolve reference entries 1 level deep. Additional levels of Link resolution will need to occur via separate get Entry calls

Below is a list of methods available in the Contentful Adapter:

| Name | Description |
| ---- | ---- |
| `getEntries` | Get entries by custom [Query](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html) |
| `getEntriesByContentType` | Get entries by Content Type and custom Query

### PIM
Below are a list of methods available in the `PIMAdapter` class

| Name | Description |
| ---- | ---- |
| `getAllPrograms` | List all Programs, no query parameters. |
| `getCollegeList` | Lists all or some Colleges by Query. Use Query object to filter by specific id(s) |
| `getLinkedBannerEntriesByEntryId` | Fetches entries (Programs) linked to Banner entries by matching Banner entry Id |
| `getProgramsByCollege` | This method walks backwards from the College Entry to the Banner Entry and finally to the linked Entries attached to the Banner Entry such as a Program Entry. Using the College Entry Id that's found when doing a lookup of Colleges by `$college_name`, we filter the API by `$college[0]['id']` with the ID of the fields.`college.sys.id` value in the Banner Entry. Finally, we get linked Entries belonging to the Banner entry. **This method will only return Program entries as Banner entries are only attached to Program Entries.** |
| `getProgramById` | Fetch Program entry by `sys.id` |
| `getProgramByName` | Fetch Program entry by `fields.name` |
| `getProgramsByLocationName` | Fetch Programs by linked Location entry's `fields.name` |
| `getProgramsByMajorName` | Fetch Programs by linked Banner entry's `fields.major` |

### FIM
Below are a list of methods available in the `FIMAdapter` class

| Name | Description |
| ---- | ---- |
| `getAllProfiles` | List all Profiles, no query parameters. |
| `getProfileById` | Fetch Profile entry by `sys.id` |
| `getProfileByName` | Fetch Profile entry by `fields.displayNameInternal` |

### Responses
Responses are in PHP Array or Contentful [ResourceArray](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/ResourceArray.html). Use the methods attached to `ResourceArray` to map data to fields.


### Rich Text
You may encounter Rich Text fields in the PHP response. To Convert to HTML, you may need to look into the [`Contentful\RichText\Renderer` class](https://github.com/contentful/rich-text.php#rendering). There's  class that can be used within Model classes for rendering Rich Text (`RendersRichText`).