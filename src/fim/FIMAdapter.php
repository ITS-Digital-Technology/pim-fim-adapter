<?php

namespace Northeastern\PIMFIMAdapter\FIM;

use Northeastern\PIMFIMAdapter\FIM\Config\FIMConfig;
use Northeastern\PIMFIMAdapter\ContentfulAdapter;
use Northeastern\PIMFIMAdapter\Adapter;
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
     * Fetch Profile entry by fields.banner.fields.displayNameInternal
     * 
     * @param string $name
     * 
     * @return ResourceArray $entries
     */
    public function getProfileByName(string $name = '') {
        $query = (new Query)
            ->where('fields.banner.sys.contentType.sys.id', 'banner')
            ->where('fields.banner.fields.displayNameInternal[match]', $name);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->profile_content_type,
            $query
        );

        return $entries;
    }


    /**
     * Get Profiles By College
     * 
     * Fetch Profile entry by fields.banner.fields.collegeAffiliation
     * 
     * @param string $college_name
     * 
     * @return ResourceArray $entries
     */
    public function getProfilesByCollege(string $college_name = '') {
        $query = (new Query)
            ->where('fields.banner.sys.contentType.sys.id', 'banner')
            ->where('fields.banner.fields.collegeAffiliation[match]', $college_name);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->profile_content_type,
            $query
        );

        return $entries;
    }


    /**
     * Get Profiles By Custom Query
     * 
     * @param ?Query $query null
     * 
     * @return ResourceArray $entries
     */
    public function getProfilesByCustom(?Query $query = null) {
        $entries = $this->adapter->getEntriesByContentType(
            $this->profile_content_type,
            $query
        );

        return $entries;
    }

}