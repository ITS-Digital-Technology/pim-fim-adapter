<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM;

use NortheasternWeb\PIMFIMAdapter\PIM\Config\PIMConfig;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use Contentful\Delivery\ClientOptions;
use Contentful\Delivery\Query;

class PIMAdapter {
    private PIMConfig $config;
    private $program_content_type = 'program'; 
    private ContentfulAdapter $adapter;

    public function __construct(
        ClientOptions $client_options = null
    ) {
        $this->config = new PIMConfig();

        extract((array) $this->config);

        $this->adapter = new ContentfulAdapter(
            $access_token, 
            $space_id, 
            $environment_id, 
            $client_options
        );
    }

    public function getAllPrograms() {
        $entries = $this->adapter->getEntriesByContentType($this->program_content_type);

        return $entries;
    }

    public function getProgramByIdOrName(string $id = '', string $name = '') {
        $query = (new Query)
            ->where('sys.id', $id)
            ->where('fields.name', $name);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Programs by Location Name
     */
    public function getProgramsByLocationName(string $name) {
        $query = (new Query)
            ->where('fields.location', $name);

        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Programs By Major Name
     */
    public function getProgramsByMajorName(string $major) {
        $query = (new Query)->where('banner.fields.major.fields.name', $major);

        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Programs By College Id Or Name
     */
    public function getProgramsByCollegeIdOrName(
        string $id = '', 
        string $name = ''
    ) {
        $query = (new Query)
            ->where('banner.fields.college.fields.name', $name)
            ->where('banner.fields.college.sys.id', $id);

        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Programs By Degree Type
     */
    public function getProgramsByDegreeType(
        string $name = ''
    ) {

    }

    /**
     * Get Programs By Custom Query
     */
    public function getProgramsByCustom($query) {

    }
}