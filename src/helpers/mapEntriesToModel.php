<?php

namespace Northeastern\PIMFIMAdapter\Helpers;

// PIM
use Northeastern\PIMFIMAdapter\PIM\Model\College;
use Northeastern\PIMFIMAdapter\PIM\Model\Program;

// FIM
use Northeastern\PIMFIMAdapter\FIM\Model\Profile;

function mapEntriesToModel($content_type, $entries) {
    $entries_array = null;

    switch ($content_type) {
        case 'college':
            $entries_array = collect($entries)->map(function($item) {
                return (new College($item))->toArray();
            });
            break;
        case 'program':
            $entries_array = collect($entries)->map(function($item) {
                return (new Program($item))->toArray();
            });
            break;
        case 'faculty':
            $entries_array = collect($entries)->map(function($item) {
                return (new Profile($item))->toArray();
            });
            break;
    }

    return $entries_array;
}