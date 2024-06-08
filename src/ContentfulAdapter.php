<?php

namespace NortheasternWeb\PIMFIMAdapter;

use Contentful\Core\Exception\NotFoundException;
use Contentful\Core\Resource\ResourceArray;
use Contentful\Delivery\ClientOptions;
use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use Contentful\Delivery\Resource\Entry;

/**
 * Contentful Client Adapter
 * 
 * Connect to a Contentful Space and Environments and get Contentful entries.
 * 
 * @property private Client $client
 *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Delivery/Client.html
 * @property private ClientOptions $client_options
 *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Delivery/ClientOptions.html
 */
class ContentfulAdapter {
    private Client $client;

    private ClientOptions $client_options;

    /**
     * @param string $access_token
     * @param string $space_id
     * @param string $environment_id
     * @param ClientOptions $client_options Optional, default value `null`
     */
    public function __construct(
        string $access_token,
        string $space_id,
        string $environment_id,
        ClientOptions $client_options = null
    ) {

        // Contentful Client Options
        $this->client_options = is_null($client_options) 
            ? ClientOptions::create()->usingDeliveryApi() // Default Client Options 
            : $client_options; // Custom Client Options

        // Contentful Client
        $this->client = new Client(
            $access_token,
            $space_id,
            $environment_id,
            $this->client_options
        );
    }

    /**
     * Get Entry By Id
     */
    public function getEntry(string $id, ?Query $query = null): Entry {
        try {
            $entry = $this->client->getEntry($id);

            return $entry;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }

    /**
     * Get Entries
     * 
     * @param Query $query
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html
     * 
     * @return ResourceArray $entries 
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/ResourceArray.html
     */
    public function getEntries(?Query $query = null): ResourceArray {
        try {
            $entries = $this->client->getEntries($query->setInclude(10));

            return $entries;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }

    /**
     * Get Entries by Content Type
     * 
     * @param string $content_type
     * @param Query $query
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html
     * 
     * @return ResourceArray $entries
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/ResourceArray.html
     */
    public function getEntriesByContentType(
        string $content_type,
        ?Query $query = null
    ) {
        try {
            $query = !is_null($query) 
                ? $query 
                : new Query();

            $content_type_query = $query
                ->setContentType($content_type)
                ->setInclude(10);

            $entries = $this->client->getEntries($content_type_query);

            return $entries;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }

    /**
     * Get Entries by Tags
     * 
     * @param array $tags
     * @param Query $query
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html
     * 
     * @return ResourceArray $entries
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/ResourceArray.html
     */
    public function getEntriesByTags(
        array $tags,
        ?Query $query = null 
    ): ResourceArray {
        try {
            $query = !is_null($query) 
                ? $query 
                : new Query();

            $tags_query = $query
                ->where('metadata.tags.sys.id[in]', $tags)
                ->setInclude(10);

            $entries = $this->client->getEntries($tags_query);

            return $entries;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }

    /**
     * Get Entries by Content Type and Tags
     * 
     * @param string $content_type
     * @param array $tags
     * @param Query $query
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Query.html
     * 
     * @return ResourceArray $entries
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/ResourceArray.html
     */
    public function getEntriesByContentTypeAndTags(
        string $content_type, 
        array $tags,
        ?Query $query = null 
    ): ResourceArray {
        try {
            $query = !is_null($query) 
                ? $query 
                : new Query();

            $content_type_and_tags_query = $query
                ->setContentType($content_type)
                ->where('metadata.tags.sys.id[in]', $tags)
                ->setInclude(10);

            $entries = $this->client->getEntries($content_type_and_tags_query);

            return $entries;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }
}