<?php

namespace Northeastern\PIMFIMAdapter\PIM\Helpers;

use DOMDocument;

function transformConcentrationsToHTML($concentrations) {
    $dom = new DOMDocument('1.0', 'utf-8');
    
    if (is_null($concentrations) || empty($concentrations) || !is_array($concentrations)) {
        return;
    }
    
    // Table Items/Values
    foreach ($concentrations as $concentration) {
        // Root element
        $root = $dom->createElement('div');
        $root = $dom->appendChild($root);
        $root->setAttribute('class', 'concentrations-wrapper');

        // Heading
        $heading = $dom->createElement('h4', $concentration['name']);
        $heading = $root->appendChild($heading);

        $description = $dom->createElement('p', $concentration['description']);
        $description = $root->appendChild($description);

    }

    $html = $dom->saveHTML();

    return $html;
}