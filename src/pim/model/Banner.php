<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

use Contentful\Delivery\Resource\Entry as ResourceEntry;
use NortheasternWeb\PIMFIMAdapter\Model\Entry;

class Banner extends Entry {
    protected $bannerId;
    protected $friendlyName;
    protected $major;
    protected $degreeType;
    protected $undergradDegreeType;
    protected $college;
    protected $additionalColleges;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());

        $this->bannerId = $item->bannerId;
        $this->friendlyName = $item->friendlyName;
        $this->major = $item->major;
        $this->degreeType = $item->degreeType;
        $this->undergradDegreeType = $item->undergradDegreeType;
        $this->college = (new College($item->college))->toArray();
        $this->additionalColleges = collect($item->additionalColleges)->map(function ($college) {
            return (new College($college))->toArray();
        });
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'bannerId' => $this->bannerId,
            'friendlyName' => $this->friendlyName,
            'major' => $this->major,
            'degreeType' => $this->degreeType,
            'undergradDegreeType' => $this->undergradDegreeType,
            'college' => $this->college,
            'additionalColleges' => $this->additionalColleges,

            ...parent::toArray()
        ];
    }
}