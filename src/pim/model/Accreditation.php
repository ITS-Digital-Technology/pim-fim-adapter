<?php

namespace Northeastern\PIMFIMAdapter\PIM\Model;

use Northeastern\PIMFIMAdapter\Concerns\RendersRichText;
use Contentful\Delivery\Resource\Entry as ResourceEntry;
use Northeastern\PIMFIMAdapter\Model\Entry;

class Accreditation extends Entry {
    use RendersRichText;

    protected $name;
    protected $abbreviation;
    protected $url;
    protected $description;
    protected $logo;

    public function __construct(ResourceEntry $item) {
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

    public function toArray()
    {
        return [
            ...parent::toArray(),

            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'url' => $this->url,
            'description' => $this->description,
            'logo' => $this->logo,            
        ];
    }
}