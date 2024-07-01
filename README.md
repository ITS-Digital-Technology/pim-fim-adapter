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
This package supports the use of the PHP Dotenv package for setting and reading environment variables. If your PHP project doesn't use Dotenv, declare the variable as a constant (`define()`) in the application's configuration. In WordPress, this configuration would be the `wp-config.php` file. 

### PIM
| Environment Variable | Description |
|---|---|
| `PIM_ACCESS_TOKEN` | Provides the Access Token for reading data from the Contentful PIM Space |
| `PIM_SPACE_ID` | Provides the Space ID for the Contentful PIM Space |
| `PIM_ENVIRONMENT_ID` | Provides the Environment ID for the Contentful PIM Space (e.g., 'master', 'staging', 'development') |

### FIM
| Environment Variable | Description |
|---|---|
| `FIM_ACCESS_TOKEN` | Provides the Access Token for reading data from the Contentful FIM Space |
| `FIM_SPACE_ID` | Provides the Space ID for the Contentful FIM Space |
| `FIM_ENVIRONMENT_ID` | Provides the Environment ID for the Contentful FIM Space (e.g., 'master', 'staging', 'development') |

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

| Name | Parameters | Description |
| ---- | ---- | ---- |
| `getAllPrograms` | N/A | List all Programs, no query parameters. |
| `getCollegeList` | [Query](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html) `$query` - optional | Lists all or some Colleges by Query. Use Query object to filter by specific id(s) |
| `getLinkedBannerEntriesByEntryId` | string `$entry_id` | Fetches entries (Programs) linked to Banner entries by matching Banner entry Id (`$entry_id`/`sys.id`) |
| `getProgramsByCollege` | string `$college_name`, [Query](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html) `$query` - optional | This method walks backwards from the College Entry to the Banner Entry and finally to the linked Entries attached to the Banner Entry such as a Program Entry. Using the College Entry Id that's found when doing a lookup of Colleges by `$college_name`, we filter the API by `$college[0]['id']` with the ID of the fields.`college.sys.id` value in the Banner Entry. Finally, we get linked Entries belonging to the Banner entry. **This method will only return Program entries as Banner entries are only attached to Program Entries.** |
| `getProgramById` | string `$id` | Fetch Program entry by `sys.id` |
| `getProgramByName` | string `$name` | Fetch Program entry by `fields.name` |
| `getProgramsByLocationName` | string `$name` | Fetch Programs by linked Location entry's `fields.name` |
| `getProgramsByMajorName` | string `$major` | Fetch Programs by linked Banner entry's `fields.major` |
| `getProgramsByDegreeType` | string `$degreeType` | Fetch Programs by linked Banner entry's `fields.degreeType`. Accepts the following values: "CAGS", "Dual Degree", "Master's Certificate", "Professional Doctorate" |
| `getProgramsByUndergradDegreeType` | string `$undergradDegreeType` | Fetch Programs by linked Banner entry's `fields.undergradDegreeType`. Accepts the following values: "N/A", "Bachelor's", "Certificate", "Post-Baccalaureate" |
| `getProgramsByCustom` | [Query](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html) `$query` | Fetch Programs by Custom [Query](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html) |

### Responses
Responses are in PHP Array or Contentful [ResourceArray](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/ResourceArray.html). Use the methods attached to `ResourceArray` to map data to fields.

Utilize the PIM/FIM Models to map content types to plain associative PHP arrays.

### Rich Text
You may encounter Rich Text fields in the PHP response. To Convert to HTML, you may need to look into the [`Contentful\RichText\Renderer` class](https://github.com/contentful/rich-text.php#rendering). There's  class that can be used within Model classes for rendering Rich Text (`RendersRichText`).