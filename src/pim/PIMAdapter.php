<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM;

use NortheasternWeb\PIMFIMAdapter\PIM\Config\PIMConfig;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\Adapter;
use Contentful\Delivery\ClientOptions;
use Contentful\Delivery\Query;

class PIMAdapter extends Adapter {
    private PIMConfig $config;
    private $program_content_type = 'program'; 
    private ContentfulAdapter $adapter;

    public function __construct(
        ClientOptions $client_options = null
    ) {
        $this->config = new PIMConfig();

        return $this->adapter = parent::__construct($this->config);
    }

    public function getEntry($id) {
        $entry = $this->adapter->getEntry($id);

        return $entry;
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
            ->where('fields.location.sys.contentType.sys.id', 'location')
            ->where('fields.location.fields.name[match]', $name);

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
        $query = (new Query)
            ->where('fields.banner.sys.contentType.sys.id', 'banner')
            ->where('fields.banner.fields.major[match]', $major);

        $entries = $this->adapter->getEntriesByContentTypeAndTags(
            $this->program_content_type,
            ['collegeCollegeOfEngineering']
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
        $query = (new Query);

        if (!empty($id)) {
            $query = $query
                ->where('fields.banner.fields.college.sys.contentType.sys.id', 'college')
                ->where('fields.banner.fields.college.sys.id', $id);
        }

        if (!empty($name)) {
            $query = $query
                ->where('fields.banner.fields.college.sys.contentType.sys.id', 'college')
                ->where('fields.banner.fields.college.fields.name', $name);
        }

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
     * Get Programs By Degree Type
     */
    public function getProgramsByUndergradDegreeType(
        string $name = ''
    ) {

    }


    /**
     * Get Programs By Custom Query
     */
    public function getProgramsByCustom($query) {

    }
}