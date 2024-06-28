<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

class Location {

    protected $id;
    protected $name;
    protected $stateProvince;
    protected $country;
    protected $visaLabel;
    protected $tuitionCurrency;

    public function __construct($item) {
        $this->id = $item->getId();
        $this->name = $item->name;
        $this->stateProvince = $item->stateProvince;
        $this->country = $item->country;
        $this->visaLabel = $item->visaLabel;
        $this->tuitionCurrency = $item->tuitionCurrency;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'stateProvince' => $this->stateProvince,
            'country' => $this->country,
            'visaLabel' => $this->visaLabel,
            'tuitionCurrency' => $this->tuitionCurrency,
        ];
    }
}