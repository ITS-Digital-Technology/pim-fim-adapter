<?php

namespace Northeastern\PIMFIMAdapter\PIM\Helpers;

use DOMDocument;

function transformDeadlinesToTable($deadline_json) {
    $dom = new DOMDocument('5.0', 'utf-8');

    if (is_null($deadline_json) && !is_object($deadline_json) && !is_array($deadline_json)) {
        var_dump($deadline_json);
        return;
    }

    foreach ($deadline_json as $deadline) {
        // Root element
        $root = $dom->createElement('div');
        $root = $dom->appendChild($root);

        // Heading
        $heading = $dom->createElement('h4', $deadline['key']);
        $heading = $root->appendChild($heading);

        // Table
        $table = $dom->createElement('table');
        $table = $root->appendChild($table);

        // Table Head
        $thead = $dom->createElement('thead');
        $thead = $table->appendChild($thead);

        // Table Head Row
        $thead_tr = $dom->createElement('tr');
        $thead_tr = $thead->appendChild($thead_tr);

        // Table Body
        $tbody = $dom->createElement('tbody');
        $tbody = $table->appendChild($tbody);
        
        // Table Headers
        foreach ($deadline['headers'] as $thead_th) {
            $td = $dom->createElement('td');
            $td = $thead_tr->appendChild($td);
            
            $th = $dom->createTextNode($thead_th);
            $th = $td->appendChild($th);
        }

        // Table Items/Values
        foreach ($deadline['items'] as $deadline) {

            $deadline = [
                'key' => $deadline['key'],
                'value' => $deadline['value']
            ];

            $tbody_tr = $dom->createElement('tr');
            $tbody_tr = $tbody->appendChild($tbody_tr);
            
            foreach ($deadline as $deadline_value) {
                $td = $dom->createElement('td');
                $td = $tbody_tr->appendChild($td);
                $value = $dom->createTextNode($deadline_value);
                $value = $td->appendChild($value);
            }
        }

    }
    $html = $dom->saveHTML();
    var_dump($html);
    return $html;
}