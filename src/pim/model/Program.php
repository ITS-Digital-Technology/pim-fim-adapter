<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Model;

use NortheasternWeb\PIMFIMAdapter\Model\Entry;
use Contentful\Delivery\Resource\Entry as ResourceEntry;
use NortheasternWeb\PIMFIMAdapter\Concerns\RendersRichText;

class Program extends Entry {
    use RendersRichText;

    protected string $name;
    protected $legacyId;
    
    protected $banner;
    protected $location;

    protected $format;
    protected $commitment;

    protected $durationUnit;
    protected int|null $durationLowerRangeValue;
    protected int|null $durationUpperRangeValue;

    protected ?bool $visaEligible;
    protected ?bool $stem;
    protected ?bool $dhsStem;
    protected ?bool $align;
    protected ?bool $plusOne;
    protected ?bool $stackableCertificate;

    protected $entryTerms;

    protected $deadline;

    protected ?string $applyNowLink;

    protected $requirements;
    
    protected $tuition;

    protected $programFees;

    protected $averageAid;

    protected $percentReceivingAid;

    protected $accreditation;

    protected $accreditationDescriptionOverride;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());

        $this->name = $item->name;
        $this->legacyId = $item->legacyId;

        $this->banner = (new Banner($item->banner))->toArray();
        $this->location = (new Location($item->location))->toArray();

        $this->format = $item->format;

        $this->commitment = $item->commitment;

        $this->durationUnit = $item->durationUnit;
        $this->durationLowerRangeValue = $item->durationLowerRangeValue;
        $this->durationUpperRangeValue = $item->durationUpperRangeValue;
        
        $this->visaEligible = $item->visaEligible;
        $this->stem = $item->stem;
        $this->dhsStem = $item->dhsStem;
        $this->align = $item->align;
        $this->plusOne = $item->plusOne;
        $this->stackableCertificate = $item->stackableCertificate;
        
        $this->entryTerms = $item->entryTerms;
        
        $this->deadline = $item->deadline;
        
        $this->applyNowLink = $item->applyNowLink;
        
        $this->requirements = $this->renderRichTextNodes($item->requirements);
        
        $this->tuition = $item->tuition;
        $this->programFees = $item->programFees;
        $this->averageAid = $item->averageAid;
        $this->percentReceivingAid = $item->percentReceivingAid;

        $this->accreditation = collect($item->accreditation)->map(function($entry) { 
            return (new Accreditation($entry))->toArray();
        });
        $this->accreditationDescriptionOverride = $this->renderRichTextNodes($item->accreditationDescriptionOverride);
    }

    public function toArray()
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'legacyId' => $this->legacyId,
            'banner' => $this->banner,
            'location' => $this->location,
            'format' => $this->format,
            'commitment' => $this->commitment,
            'durationUnit' => $this->durationUnit,
            'durationLowerRangeValue' => $this->durationLowerRangeValue,
            'durationUpperRangeValue' => $this->durationUpperRangeValue,
            'visaEligible' => $this->visaEligible,
            'stem' => $this->stem,
            'dhsStem' => $this->dhsStem,
            'align' => $this->align,
            'plusOne' => $this->plusOne,
            'stackableCertificate' => $this->stackableCertificate,
            'entryTerms' => $this->entryTerms,
            'deadline' => $this->deadline,
            'applyNowLink' => $this->applyNowLink,
            'requirements' => $this->requirements,
            'tuition' => $this->tuition,
            'programFees' => $this->programFees,
            'averageAid' => $this->averageAid,
            'percentReceivingAid' => $this->percentReceivingAid,
            'accreditation' => $this->accreditation,
            'accreditationDescriptionOverride' => $this->accreditationDescriptionOverride,
        
            ...parent::toArray()
        ];
    }
}