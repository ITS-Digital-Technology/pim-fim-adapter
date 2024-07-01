<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

use Contentful\Delivery\Resource\Entry as ResourceEntry;
use NortheasternWeb\PIMFIMAdapter\Model\Entry;

class Location extends Entry {

    protected $name;
    protected $stateProvince;
    protected $country;
    protected $visaLabel;
    protected $tuitionCurrency;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());

        $this->name = $item->name;
        $this->stateProvince = $item->stateProvince;
        $this->country = $item->country;
        $this->visaLabel = $item->visaLabel;
        $this->tuitionCurrency = $item->tuitionCurrency;
    }

    public function toArray()
    {
        return [
            ...parent::toArray(),

            'name' => $this->name,
            'stateProvince' => $this->stateProvince,
            'country' => $this->country,
            'visaLabel' => $this->visaLabel,
            'tuitionCurrency' => $this->tuitionCurrency,
        ];
    }
}