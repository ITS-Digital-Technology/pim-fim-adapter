<?php

namespace Northeastern\PIMFIMAdapter\PIM\Model;

use Contentful\Delivery\Resource\Entry as ResourceEntry;
use Northeastern\PIMFIMAdapter\Concerns\RendersRichText;
use Northeastern\PIMFIMAdapter\Model\Entry;

class Concentration extends Entry {
    use RendersRichText;
    
    protected $name;
    protected $description;
    protected $code;
    protected $desc;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());

        $this->name = $item->name;
        $this->description = $this->renderRichTextNodes($item->description);
        $this->code = $item->code;
        $this->desc = $item->desc;
    }

    public function toArray()
    {
        return [
            ...parent::toArray(),

            'name' => $this->name,
            'description' => $this->description,
            'code' => $this->code,
            'desc' => $this->desc
        ];
    }
}