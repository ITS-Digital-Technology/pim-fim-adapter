<?php

namespace NortheasternWeb\PIMFIMAdapter\FIM;

use NortheasternWeb\PIMFIMAdapter\FIM\Config\FIMConfig;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\Adapter;
use Contentful\Delivery\ClientOptions;
use Contentful\Delivery\Query;

class FIMAdapter extends Adapter {
    private FIMConfig $config;
    private ContentfulAdapter $adapter;
    private $profile_content_type = 'profile';

    function __construct(
        ?ClientOptions $client_options = null
    ) {
        $this->config = new FIMConfig();

        return $this->adapter = parent::__construct($this->config, $client_options);
    }

    /**
     * Get All Profiles
     * 
     * List all Profiles, no query parameters.
     */
    public function getAllProfiles() {
        $entries = $this->adapter->getEntriesByContentType(
            $this->profile_content_type
        );

        return $entries;
    }

    /**
     * Get Profile By Id
     * 
     * Fetch Profile entry by sys.id
     * 
     * @param string $id
     * 
     * @return ResourceArray $entries
     */
    public function getProfileById(string $id = '') {
        $query = (new Query)
            ->where('sys.id', $id);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->profile_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Profile By Name
     * 
     * Fetch Profile entry by fields.displayNameInternal
     * 
     * @param string $name
     * 
     * @return ResourceArray $entries
     */
    public function getProfileByName(string $name = '') {
        $query = (new Query)
            ->where('fields.displayNameInternal', $name);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->profile_content_type,
            $query
        );

        return $entries;
    }
}