<?php

namespace Northeastern\PIMFIMAdapter\Helpers;

use Contentful\Delivery\Query;
use Contentful\Delivery\Resource\Entry as ResourceEntry;
use Northeastern\PIMFIMAdapter\ContentfulAdapter;

use function Northeastern\PIMFIMAdapter\Helpers\{mapEntriesToModel};

/**
 * Get All Contentful Entries via API (auto-paginate)
 * 
 * @param ContentfulAdapter $adapter
 * @param string $content_type
 * @param bool $preview_mode
 * @param ?Query|null $query
 *
 * @return mixed $contentful_entries
 */
function getAllContentfulEntries(
    ContentfulAdapter $adapter, 
    string $content_type, 
    bool $preview_mode = false,
    Query $query = null
) {
    $contentful_entries = null;
    $limit = 100;
    $skip = 0;

    if (is_null($query)) {
        $query = new Query();
    }

    $query = $query
        ->orderBy('sys.createdAt')
        ->setLimit($limit)
        ->setSkip($skip);

    do {
        $query = $query->setSkip($skip);

        $entries = $adapter->getEntriesByContentType(
            $content_type, 
            $query
        );

        $skip += $limit;

        $contentful_entries = !is_null($contentful_entries) 
            ? $contentful_entries->merge(mapEntriesToModel($content_type, $entries)) 
            : mapEntriesToModel($content_type, $entries);

    } while(count($entries) > 0);

    return $contentful_entries;
}