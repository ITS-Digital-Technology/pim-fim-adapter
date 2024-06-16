<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM;

use NortheasternWeb\PIMFIMAdapter\PIM\Config\PIMConfig;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\Adapter;
use Contentful\Delivery\ClientOptions;
use Contentful\Delivery\Query;

use function PHPSTORM_META\map;

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

    public function getEntry($id) {
        $entry = $this->adapter->getEntry($id);

        return $entry;
    }

    public function getAllPrograms() {
        $entries = $this->adapter->getEntriesByContentType($this->program_content_type);

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

    public function getBannerEntryAndLinkedPrograms($entry_id) {
        $should_loop = true;
        $entry_skip = 0;
        $entry_limit = 1;

        $entry_query = (new Query)
            ->select(['sys.id'])
            ->linksToEntry($entry_id)->select(['sys.id', 'fields.bannerId']);

        do {

            $banner_entries = $this->adapter->getEntriesByContentType(
                $this->banner_content_type, 
                $entry_query
            );

            $banner_entries_items = $banner_entries['items'];
            $linked_array = [];

            foreach ($banner_entries_items as $linked_entry) {
                array_push($linked_array, $linked_entry->getId());
            }
            // var_dump($banner_entries_items);
            if(count($banner_entries_items) > 0) {
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
        
        $college_list = [];
        $program_entries = [
            'sys' => [
                'type' => 'Array'
            ],
            'total' => 0,
            'limit' => 100,
            'skip' => 0,
            'items' => [],
        ];

        // For each college in the response, map $entry_array to id, name, and linked_banner_entries
        foreach($college['items'] as $entry) {
            $entry_array = [
                'id' => $entry->getId(), 
                'name' => $entry->getName(),
                'linked_banner_entries' => $this->getBannerEntryAndLinkedPrograms($entry->getId())
            ];

            array_push($college_list, $entry_array);
        }

        foreach ($college_list as $college_entry) {

            foreach($college_entry['linked_banner_entries'] as $linked_entry_id) {
                
                $entries = $this->adapter->getEntriesByContentType(
                    $this->program_content_type,
                    $query->linksToEntry($linked_entry_id)
                );
    
                array_push($program_entries['items'], $entries['items']);
            }
        }

        $program_entries['total'] = count($program_entries['items']);
        
        return $program_entries;
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
        string $degreeType = ''
    ) {

    }

    /**
     * Get Programs By Undergrad Degree Type
     */
    public function getProgramsByUndergradDegreeType(
        string $undergradDegreeType = ''
    ) {

    }


    /**
     * Get Programs By Custom Query
     */
    public function getProgramsByCustom($query) {
        $entries = $this->adapter->getEntriesByContentType(
            $this->program_content_type,
            $query
        );

        return $entries;
    }
}