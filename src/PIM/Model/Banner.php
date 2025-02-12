<?php

namespace Northeastern\PIMFIMAdapter\PIM\Model;

use Contentful\Delivery\Resource\Entry as ResourceEntry;
use Northeastern\PIMFIMAdapter\Model\Entry;

use function Northeastern\PIMFIMAdapter\PIM\Helpers\transformConcentrationsToHTML;

class Banner extends Entry {
    protected $bannerId;
    protected $friendlyName;
    protected $major;
    protected $degreeType;
    protected $undergradDegreeType;
    protected $college;
    protected $additionalColleges;
    protected $concentrations;
    protected $concentrationsHTML;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());

        $this->bannerId = $item->bannerId;
        $this->friendlyName = $item->friendlyName;
        $this->major = $item->major;
        $this->degreeType = $item->degreeType;
        $this->undergradDegreeType = $item->undergradDegreeType;
        $this->college = !is_null($item->college) ? (new College($item->college))->toArray() : null;
        $this->additionalColleges = !is_null($item->additionalColleges) ? collect($item->additionalColleges)->map(function ($college) {
            return (new College($college))->toArray();
        }) : null;
        $this->concentrations = !is_null($item->concentrations) ? collect($item->concentrations)->map(function ($concentration) {
            return (new Concentration($concentration))->toArray();
        }) : null;
        $this->concentrationsHTML = transformConcentrationsToHTML($item->concentrations);
    }

    public function toArray()
    {
        return [
            ...parent::toArray(),

            'bannerId' => $this->bannerId,
            'friendlyName' => $this->friendlyName,
            'major' => $this->major,
            'degreeType' => $this->degreeType,
            'undergradDegreeType' => $this->undergradDegreeType,
            'college' => $this->college,
            'additionalColleges' => $this->additionalColleges,
            'concentrations' => $this->concentrations,
            'concentrationsHTML' => $this->concentrationsHTML
        ];
    }
}