<?php

namespace NortheasternWeb\PIMFIMAdapter\FIM\Model;

use NortheasternWeb\PIMFIMAdapter\Model\Entry;
use Contentful\Delivery\Resource\Entry as ResourceEntry;

class Link extends Entry {
    protected string $linkText;
    protected $url;
    protected string $target;
    protected $icon;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());
        
        $this->linkText = $item->linkText;
        $this->url = $item->url;
        $this->target = $item->target;
        $this->icon = $item->icon;
    }

    public function toArray()
    {
        return [
            'linkText' => $this->linkText,
            'url' => $this->url,
            'target' => $this->target,
            'icon' => $this->icon,

            ...parent::toArray()
        ];
    }
}