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
        $nameText = $concentration['name'] ?? '';
        $name = $dom->createElement('strong', htmlspecialchars($nameText, ENT_XML1 | ENT_COMPAT, 'UTF-8'));
        $li->appendChild($name);

        // Paragraph element for Description
        $descText = $concentration['description'] ?? '';
        if (!empty($descText)) {
            $description = $dom->createElement('p', htmlspecialchars($descText, ENT_XML1 | ENT_COMPAT, 'UTF-8'));
            $li->appendChild($description);
        }
    }

    $html = $dom->saveHTML();

    return $html;
}