<?php

namespace Northeastern\PIMFIMAdapter\PIM\Model;

use Northeastern\PIMFIMAdapter\Concerns\RendersRichText;
use Contentful\Delivery\Resource\Entry as ResourceEntry;
use Northeastern\PIMFIMAdapter\Model\Entry;

class University extends Entry {
    use RendersRichText;

    protected $name;
    protected $curriculumDisclaimer;
    protected $estimatedTotalTuitionDisclaimer;
    protected $estimatedFeesDisclaimer;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());
        
        $this->name = $item->name;
        $this->curriculumDisclaimer = $this->renderRichTextNodes($item->curriculumDisclaimer);
        $this->estimatedTotalTuitionDisclaimer = $this->renderRichTextNodes($item->estimatedTotalTuitionDisclaimer);
        $this->estimatedFeesDisclaimer = $this->renderRichTextNodes($item->estimatedFeesDisclaimer);
    }

    public function toArray()
    {
        return [
            ...parent::toArray(),

            'name' => $this->name,
            'curriculumDisclaimer' => $this->curriculumDisclaimer,
            'estimatedTotalTuitionDisclaimer' => $this->estimatedTotalTuitionDisclaimer,
            'estimatedFeesDisclaimer' => $this->estimatedFeesDisclaimer,
        ];
    }
}