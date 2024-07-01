<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM;

use NortheasternWeb\PIMFIMAdapter\PIM\Config\PIMConfig;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\Adapter;
use Contentful\Delivery\ClientOptions;
use Contentful\Delivery\Query;

class PIMAdapter extends Adapter {
    private PIMConfig $config;
    private ContentfulAdapter $adapter;

    private $program_content_type = 'program';
    private $college_content_type = 'college';
    private $banner_content_type = 'banner';

    public function __construct(
        ?ClientOptions $client_options = null
    ) {
        $this->config = new PIMConfig();

        return $this->adapter = parent::__construct($this->config, $client_options);
    }

    /**
     * Get All Programs
     * 
     * List all Programs, no query parameters.
     */
    public function getAllPrograms() {
        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type
        );

        return $entries;
    }

    /**
     * Get College List
     * 
     * Lists all or some Colleges by Query. Use Query object to filter by specific id(s)
     * 
     * e.g., `$query->where('fields.name[match]', 'collegeName')`
     *
     * @param ?Query $query null
     *
     * @return \Contentful\Core\Resource\ResourceArray $entries
     */
    public function getCollegeList(?Query $query = null) {
        $entries = $this->adapter->getEntriesByContentType(
            $this->college_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Banner Entries By Entry Id
     * 
     * Fetches entries (Programs) linked to Banner entries by matching Banner entry Id
     * 
     * @param string $entry_id
     * 
     * @return $linked_array
     */
    public function getLinkedBannerEntriesByEntryId($entry_id) {
        $entry_skip = 0;
        $entry_limit = 1;
        $linked_array = [];

        $query = (new Query)
            ->select(['sys.id'])
            ->linksToEntry($entry_id)
            ->orderBy('sys.createdAt');
        do {

            $banner_entries = $this->adapter->getEntriesByContentType(
                $this->banner_content_type, 
                $query->setSkip($entry_skip)
            );

            foreach ($banner_entries as $linked_entry) {
                array_push($linked_array, $linked_entry->getId());
            }

            if(count($banner_entries) > 0) {
                $entry_skip += $entry_limit;
            } else {
                break;
            }

        } while(0);

        return $linked_array;
    }

    /**
     * Get Programs by College Name
     * 
     * This method walks backwards from the College Entry to the Banner Entry 
     * and finally to the linked Entries attached to the Banner Entry such as a Program Entry.
     * 
     * Using the College Entry Id that's found when doing a lookup of Colleges by $college_name,
     * we filter the API by `$college[0]['id']` with the ID of the fields.college.sys.id value in the Banner Entry.
     * Finally, we get linked Entries belonging to the Banner entry.
     * 
     * This method will only return Program entries as Banner entries are only attached to Program Entries.
     *  
     * @param string $college_name
     * @param ?Query $query
     * 
     * @return $linked_banner_entries
     */
    public function getProgramsByCollege(string $college_name, ?Query $query = null) {
        $query = is_null($query) ? new Query() : $query;

        // Get single College match based on $college_name - Full Text Search enabled.
        $college = $this->getCollegeList(
            (new Query)->where('fields.name[match]', $college_name)
        );

        // Get List of Banner Entries used by College
        $banner_list = collect($college)->map(function($entry, $key) {
            return $this->getLinkedBannerEntriesByEntryId($entry->getId());
        });

        // Iterate over $banner_list arrays of $college_entry array.
        // Outputs flat Array with Entry Ids for the program Entries.
        $program_ids = collect($banner_list)->map(function($college_entry) { 
            // Iterate over banner entry IDs found in each $college_entry 
            return collect($college_entry)->map(function($linked_entry_id) {
                // Get Program Entries by entry
                $linked_entries = $this->adapter->getEntriesByContentType(
                    $this->program_content_type,
                    (new Query)
                        ->linksToEntry($linked_entry_id)
                        ->select(['sys.id'])
                );

                return collect($linked_entries)->map(function($entry) {
                    return $entry->getId();
                });

            })->collapse();
        })->collapse();

        // Get Program entries by Array of Ids.
        $program_entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query->where('sys.id[in]', $program_ids->all())
        );
        
        return $program_entries;
    }

    /**
     * Get Program By Id
     * 
     * Fetch Program entry by sys.id
     * 
     * @param string $id
     * 
     * @return ResourceArray $entries
     */
    public function getProgramById(string $id = '') {
        $query = (new Query)
            ->where('sys.id', $id);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Program By Name
     * 
     * Fetch Program entry by fields.name
     * 
     * @param string $name
     * 
     * @return ResourceArray $entries
     */
    public function getProgramByName(string $name = '') {
        $query = (new Query)
            ->where('fields.name', $name);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Programs by Location Name
     * 
     * @param string $name
     * 
     * @return ResourceArray $entries
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
     * 
     * @param string $major
     * 
     * @return ResourceArray $entries
     */
    public function getProgramsByMajorName(string $major) {
        $query = (new Query)
            ->where('fields.banner.sys.contentType.sys.id', 'banner')
            ->where('fields.banner.fields.major[match]', $major);

        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Programs By Degree Type
     * 
     * @param string $degreeType
     * 
     * @return ResourceArray $entries
     */
    public function getProgramsByDegreeType(
        string $degreeType
    ) {
        $query = (new Query)
            ->where('fields.banner.sys.contentType.sys.id', 'banner')
            ->where('fields.banner.fields.degreeType', $degreeType);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }

    /**
     * Get Programs By Undergrad Degree Type
     * 
     * @param string $undergradDegreeType
     * 
     * @return ResourceArray $entries
     */
    public function getProgramsByUndergradDegreeType(
        string $undergradDegreeType
    ) {
        $query = (new Query)
            ->where('fields.banner.sys.contentType.sys.id', 'banner')
            ->where('fields.banner.fields.undergradDegreeType', $undergradDegreeType);
        
        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }


    /**
     * Get Programs By Custom Query
     * 
     * @param ?Query $query null
     * 
     * @return ResourceArray $entries
     */
    public function getProgramsByCustom(?Query $query = null) {
        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }
}