<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

use NortheasternWeb\PIMFIMAdapter\Concerns\RendersRichText;
use Contentful\Delivery\Resource\Entry as ResourceEntry;
use NortheasternWeb\PIMFIMAdapter\Model\Entry;

class College extends Entry {
    use RendersRichText;

    protected $id;
    protected $legacyId;
    protected $name;
    protected $requirements;
    protected $applyNowLink;
    protected $tuitionCostPerCredit;
    protected $deadline;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());
        
        $this->legacyId = $item->legacyId;
        $this->name = $item->name;
        $this->requirements = $this->renderRichTextNodes($item->requirements);
        $this->applyNowLink = $item->applyNowLink;
        $this->tuitionCostPerCredit = $item->tuitionCostPerCredit;
        $this->deadline = $item->deadline;
    }

    public function toArray()
    {
        return [
            ...parent::toArray(),

            'legacyId' => $this->legacyId,
            'name' => $this->name,
            'requirements' => $this->requirements,
            'applyNowLink' => $this->applyNowLink,
            'tuitionCostPerCredit' => $this->tuitionCostPerCredit,
            'deadline' => $this->deadline,
        ];
    }
}