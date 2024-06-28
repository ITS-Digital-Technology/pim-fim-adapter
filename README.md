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

### Responses
Responses are in PHP Array or Contentful [ResourceArray](https://contentful.github.io/contentful.php/api/6.4.0/Contentful/ResourceArray.html) format and structured as the following:

- For `getEntries*` type responses (Contentful `ResourceArray`), it may be helpful to convert to JSON (`json_encode`) then use Contentful `$client->parseJson()` to return it to PHP Array format.
    ```json
    {
        "sys": {
            "type": "Array"
        },
        "total": 0, // Total count of items matching the query
        "limit": 100, // Limit of items in the query
        "skip": 0, // Number of items to skip in the query. Useful for paginating requests with more than 100 items in a response.
        "items": [] // Your Query's filtered response as an associative array of Asset and Entry items
    }
    ```

### Rich Text
You may encounter Rich Text fields in the PHP response. To Convert to HTML, you may need to look into the [`Contentful\RichText\Renderer` class](https://github.com/contentful/rich-text.php#rendering).