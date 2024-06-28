<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

use NortheasternWeb\PIMFIMAdapter\Concerns\RendersRichText;

class Accreditation {
    use RendersRichText;

    protected $id;
    protected $name;
    protected $abbreviation;
    protected $url;
    protected $description;
    protected $logo;

    public function __construct($item) {
        $this->id = $item->getId();
        $this->name = $item->name;
        $this->abbreviation = $item->abbreviation;
        $this->url = $item->url;
        $this->description = $this->renderRichTextNodes($item->description);
        $this->logo = !is_null($item->logo) ? [
            'id' => $item->logo->getId(),
            'title' => $item->logo->getTitle(),
            'description' => $item->logo->getDescription(),
            'file' => $item->logo->getFile(),
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
        ];
    }
}