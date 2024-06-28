<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

use NortheasternWeb\PIMFIMAdapter\Concerns\RendersRichText;

class College {
    use RendersRichText;

    protected $id;
    protected $legacyId;
    protected $name;
    protected $requirements;
    protected $applyNowLink;
    protected $tuitionCostPerCredit;
    protected $deadline;

    public function __construct($item) {
        $this->id = $item->getId();
        $this->legacyId = $item->legacyId;
        $this->name = $item->name;
        $this->requirements = $this->renderRichTextNodes($item->requirements);
        $this->applyNowLink = $item->applyNowLink;
        $this->tuitionCostPerCredit = $item->tuitionCostPerCredit;
        $this->deadline = $item->deadline;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'legacyId' => $this->legacyId,
            'name' => $this->name,
            'requirements' => $this->requirements,
            'applyNowLink' => $this->applyNowLink,
            'tuitionCostPerCredit' => $this->tuitionCostPerCredit,
            'deadline' => $this->deadline,
        ];
    }
}