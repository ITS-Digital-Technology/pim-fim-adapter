<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

use NortheasternWeb\PIMFIMAdapter\Model\Entry;
use NortheasternWeb\PIMFIMAdapter\Concerns\RendersRichText;

class Accreditation extends Entry {
    use RendersRichText;

    protected $name;
    protected $abbreviation;
    protected $url;
    protected $description;
    protected $logo;

    public function __construct($item) {
        parent::__construct($item->getSystemProperties());

        $this->name = $item->name;
        $this->abbreviation = $item->abbreviation;
        $this->url = $item->url;
        $this->description = $this->renderRichTextNodes($item->description);
        $this->logo = !is_null($item->logo) ? [
            'id' => $item->logo->getId(),
            'title' => $item->logo->getTitle(),
            'description' => $item->logo->getDescription(),
            'file' => $item->logo->getFile(),
            'createdAt' => $item->logo->getSystemProperties()->getCreatedAt(),
            'updatedAt' => $item->logo->getSystemProperties()->getUpdatedAt(),
            'revision' => $item->logo->getSystemProperties()->getRevision(),
        ] : null;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'url' => $this->url,
            'description' => $this->description,
            'logo' => $this->logo,
            
            ...parent::toArray()
        ];
    }
}