<?php

namespace Northeastern\PIMFIMAdapter\PIM\Helpers;

use DOMDocument;

function transformConcentrationsToHTML($concentrations) {
    $dom = new DOMDocument('1.0', 'utf-8');
    
    if (is_null($concentrations) || empty($concentrations) || !is_array($concentrations)) {
        return;
    }
    
    // Root element
    $root = $dom->createElement('div');
    $root = $dom->appendChild($root);
    $root->setAttribute('class', 'concentrations-wrapper');

    // Unordered List
    $ul = $dom->createElement('ul');
    $ul = $root->appendChild($ul);

    // Table Items/Values
    foreach ($concentrations as $concentration) {
        // List Item
        $li = $dom->createElement('li');
        $li = $ul->appendChild($li);

        // Strong element for name
        $name = $dom->createElement('strong', $concentration['name']);
        $li->appendChild($name);

        // Paragraph element for Description
        if ($concentration['description']) {
            $description = $dom->createElement('p', $concentration['description']);
            $li->appendChild($description);
        }
    }

    $html = $dom->saveHTML();

    return $html;
}