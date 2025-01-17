<?php

namespace Northeastern\PIMFIMAdapter\PIM;

use Northeastern\PIMFIMAdapter\PIM\Config\PIMConfig;
use Northeastern\PIMFIMAdapter\PIM\Model\Program;
use Northeastern\PIMFIMAdapter\ContentfulAdapter;
use Northeastern\PIMFIMAdapter\Adapter;
use Contentful\Delivery\ClientOptions;
use Contentful\Delivery\Query;

use function Northeastern\PIMFIMAdapter\Helpers\{getAllContentfulEntries, mapEntriesToModel};

class PIMAdapter extends Adapter {
    private PIMConfig $config;
    private ContentfulAdapter $adapter;

    private $program_content_type = 'program';
    private $college_content_type = 'college';
    private $university_content_type = 'university';
    private $banner_content_type = 'banner';

    public function __construct(
        ?ClientOptions $client_options = null,
        bool $preview_mode = false
    ) {
        $this->config = new PIMConfig();

        return $this->adapter = parent::__construct($this->config, $client_options,$preview_mode);
    }

    /**
     * Get All Programs
     * 
     * List all Programs
     * 
     * @param bool $preview_mode Optional, default value `false`
     */
    public function getAllPrograms(bool $preview_mode = false) {
        $entries = getAllContentfulEntries($this->adapter, $this->program_content_type, $preview_mode);

        return $entries;
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

        $entries_array = mapEntriesToModel($this->program_content_type, $entries);

        return $entries_array;
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

        $entries_array = mapEntriesToModel($this->program_content_type, $entries);

        return $entries_array;
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
            return $this->getLinkedBannerEntriesByEntryId($entry['id']);
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

        $programs = mapEntriesToModel($this->program_content_type, $program_entries);
        
        return $programs;
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

        $entries = getAllContentfulEntries($this->adapter, $this->program_content_type, $query);

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

        $entries = getAllContentfulEntries($this->adapter, $this->program_content_type, $query);

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
        
        $entries = getAllContentfulEntries($this->adapter, $this->program_content_type, $query);

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
        
        $entries = getAllContentfulEntries($this->adapter, $this->program_content_type, $query);

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
        $entries = getAllContentfulEntries($this->adapter, $this->program_content_type, $query);

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
        $entries = getAllContentfulEntries($this->adapter, $this->college_content_type, $query);

        return $entries;
    }

    /**
     * Get University Fields
     * 
     * Fetch University fields, no query parameters.
     * 
     * @return ResourceArray $university_fields_array
     */
    public function getUniversity(){
        
        $university_fields = $this->adapter->getEntriesByContentType( $this->university_content_type);

        $university_fields_array = mapEntriesToModel($this->university_content_type, $university_fields);

        return $university_fields_array;
    }

    /**
     * Get Banner Entries By Entry Id
     * 
     * Fetches entries (Programs) linked to Banner entries by matching Banner entry Id
     * 
     * @param string $entry_id
     * 
     * @return array $linked_array
     */
    public function getLinkedBannerEntriesByEntryId($entry_id) {
        $entry_skip = 0;
        $entry_limit = 100;
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
}