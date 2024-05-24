<?php

namespace NortheasternWeb\PIMFIMAdapter;

use Contentful\Core\Exception\NotFoundException;
use Contentful\Core\Resource\ResourceArray;
use Contentful\Delivery\ClientOptions;
use Contentful\Delivery\Client;
use Contentful\Delivery\Query;

/**
 * Contentful Client Adapter
 * 
 * Connect to a Contentful Space and Environments and get Contentful entries.
 * 
 *
 * 
 * @property private Client $client
 *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/Delivery/Client.html
 */
class ContentfulAdapter {
    private Client $client;

    function __construct(
        string $access_token, 
        string $space_id, 
        string $environment_id, 
        ClientOptions $client_options = null
    ) {
        // Contentful Client Options
        $client_options = !is_null($client_options) 
            ? $client_options::create()->usingDeliveryApi() // Default Client Options 
            : $client_options; // Custom Client Options

        // Contentful Client
        $this->client = new Client(
            $access_token,
            $space_id,
            $environment_id,
            $client_options
        );
    }

    /**
     * Get Entries
     * 
     * @param Query $query
     * 
     * @return ResourceArray $entries 
     *  - https://contentful.github.io/contentful.php/api/6.4.0/Contentful/ResourceArray.html
     */
    protected function getEntries(Query $query = null): ResourceArray {
        try {
            $entries = $this->client->getEntries($query);

            return $entries;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }

    /**
     * Get Entries by Content Type
     * 
     * @param Query $query
     * @param string $content_type
     * 
     * @return ResourceArray $entries
     */
    protected function getEntriesByContentType(Query $query = null, string $content_type): ResourceArray {
        try {
            $content_type_query = $query->setContentType($content_type);
            $entries = $this->client->getEntries($content_type_query);

            return $entries;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }

    /**
     * Get Entries by Tags
     * 
     * @param Query $query
     * @param array $tags
     * 
     * @return ResourceArray $entries
     */
    protected function getEntriesByTags(Query $query = null, array $tags): ResourceArray {
        try {
            $tags_query = $query->where('metadata.tags.sys.id[in]', $tags);
            $entries = $this->client->getEntries($tags_query);

            return $entries;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }

    /**
     * Get Entries by Content Type and Tags
     * 
     * @param Query $query
     * @param string $content_type
     * @param array $tags
     * 
     * @return ResourceArray $entries
     */
    protected function getEntriesByContentTypeAndTags(Query $query = null, string $content_type, array $tags): ResourceArray {
        try {
            $content_type_and_tags_query = $query
                ->setContentType($content_type)
                ->where('metadata.tags.sys.id[in]', $tags);
            $entries = $this->client->getEntries($content_type_and_tags_query);

            return $entries;
        } catch (NotFoundException $exception) {
            return $exception;
        }
    }
}