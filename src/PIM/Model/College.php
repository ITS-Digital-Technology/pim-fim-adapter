<?php

namespace Northeastern\PIMFIMAdapter\PIM\Model;

use Northeastern\PIMFIMAdapter\Concerns\RendersRichText;
use Contentful\Delivery\Resource\Entry as ResourceEntry;
use Northeastern\PIMFIMAdapter\Model\Entry;

class College extends Entry {
    use RendersRichText;

    protected $id;
    protected $legacyId;
    protected $name;
    protected $link;
    protected $requirements;
    protected $applyNowLink;
    protected $tuitionCostPerCredit;
    protected $deadline;
    protected $deadlineOverview;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());
        
        $this->legacyId = $item->legacyId;
        $this->name = $item->name;
        $this->link = $item->link;
        $this->requirements = $this->renderRichTextNodes($item->requirements);
        $this->applyNowLink = $item->applyNowLink;
        $this->tuitionCostPerCredit = $item->tuitionCostPerCredit;
        $this->deadline = $item->deadline;
        $this->deadlineOverview = $this->renderRichTextNodes($item->deadlineOverview);
    }

    public function toArray()
    {
        return [
            ...parent::toArray(),

            'legacyId' => $this->legacyId,
            'name' => $this->name,
            'link' => $this->link,
            'requirements' => $this->requirements,
            'applyNowLink' => $this->applyNowLink,
            'tuitionCostPerCredit' => $this->tuitionCostPerCredit,
            'deadline' => $this->deadline,
            'deadlineOverview' => $this->deadlineOverview,
        ];
    }
}