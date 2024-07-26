<?php

namespace NortheasternWeb\PIMFIMAdapter\Helpers;

use Contentful\Delivery\Query;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;

/**
 * Get All Contentful Entries via API
 * 
 * @param ContentfulAdapter $adapter
 * @param string $content_type
 * @param ?Query|null $query
 *
 * @return $contentful_entries
 */
function getAllContentfulEntries(ContentfulAdapter $adapter, string $content_type, Query $query = null)
{
    $contentful_entries = [];
    $limit = 100;
    $skip = 0;

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

        foreach ($entries as $entry) {
            array_push($contentful_entries, $entry);
        }

    } while(count($entries) > 0);

    return $contentful_entries;
}