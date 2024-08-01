<?php

namespace Northeastern\PIMFIMAdapter\FIM\Model;

use Northeastern\PIMFIMAdapter\Model\Entry;
use Contentful\Delivery\Resource\Entry as ResourceEntry;

class Link extends Entry {
    protected string $linkText;
    protected string $target;
    protected $url;
    protected $icon;

    public function __construct(ResourceEntry $item)
    {
        // Get id, updatedAt, createdAt, revision
        parent::__construct($item->getSystemProperties());
        
        $this->linkText = $item->linkText;
        $this->target = $item->target;
        $this->url = $item->url;
        $this->icon = $item->icon;
    }

    public function toArray()
    {
        return [
            // ...[id, updatedAt, createdAt, revision]
            ...parent::toArray(),

            'linkText' => $this->linkText,
            'target' => $this->target,
            'url' => $this->url,
            'icon' => $this->icon,
        ];
    }
}