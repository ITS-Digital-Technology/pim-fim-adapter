<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

class Banner {
    protected $id;
    protected $bannerId;
    protected $friendlyName;
    protected $major;
    protected $degreeType;
    protected $undergradDegreeType;
    protected $college;
    protected $additionalColleges;

    public function __construct($item) {
        $this->id = $item->getId();
        $this->bannerId = $item->bannerId;
        $this->friendlyName = $item->friendlyName;
        $this->major = $item->major;
        $this->degreeType = $item->degreeType;
        $this->undergradDegreeType = $item->undergradDegreeType;
        $this->college = (new College($item->college))->toArray();
        $this->additionalColleges = collect($item->additionalColleges)->each(function ($college, $key) {
            return (new College($college))->toArray();
        });
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'bannerId' => $this->bannerId,
            'friendlyName' => $this->friendlyName,
            'major' => $this->major,
            'degreeType' => $this->degreeType,
            'undergradDegreeType' => $this->undergradDegreeType,
            'college' => $this->college,
            'additionalColleges' => $this->additionalColleges,
        ];
    }
}