<?php

namespace Northeastern\PIMFIMAdapter\PIM\Model;

use Northeastern\PIMFIMAdapter\Model\Entry;
use Contentful\Delivery\Resource\Entry as ResourceEntry;
use Northeastern\PIMFIMAdapter\Concerns\RendersRichText;
use function Northeastern\PIMFIMAdapter\PIM\Helpers\{transformDeadlinesToTable};
use function Northeastern\PIMFIMAdapter\PIM\Helpers\{transformConcentrationsToHTML};

class Program extends Entry {
    use RendersRichText;

    protected string $name;
    protected $legacyId;
    
    protected $banner;
    protected $concentrations;
    protected $concentrationsHTML;
    protected $location;

    protected $format;
    protected $commitment;

    protected $durationUnit;
    protected int|float|null $durationLowerRangeValue;
    protected int|float|null $durationUpperRangeValue;

    protected ?bool $visaEligible;
    protected ?bool $stem;
    protected ?bool $dhsStem;
    protected ?bool $align;
    protected ?bool $plusOne;
    protected ?bool $stackableCertificate;
    protected ?bool $PGWPEligible;

    protected $entryTerms;

    protected $deadline;
    protected $deadlineTable;
    protected $deadlineOverview;

    protected ?string $applyNowLink;
    protected ?string $curriculumLink;

    protected $requirements;
    protected $tuitionCalculator;
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

        $this->banner = !is_null($item->banner) ? (new Banner($item->banner))->toArray() : null;
        $this->concentrations = !is_null($item->concentrations) ? collect($item->concentrations)->map(function ($concentration) {
            return (new Concentration($concentration))->toArray();
        }) : null;
        $this->concentrationsHTML = transformConcentrationsToHTML($item->concentrations);
        $this->location = !is_null($item->location) ? (new Location($item->location))->toArray() : null;

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
        $this->PGWPEligible = $item->PGWPEligible;
        
        $this->entryTerms = $item->entryTerms;
        
        $this->deadline = $item->deadline;
        $this->deadlineTable = transformDeadlinesToTable($item->deadline);
        $this->deadlineOverview = $this->renderRichTextNodes($item->deadlineOverview);
        
        $this->applyNowLink = $item->applyNowLink;
        $this->curriculumLink = $item->curriculumLink;
        
        $this->requirements = $this->renderRichTextNodes($item->requirements);
        
        $this->tuitionCalculator = $item->tuitionCalculator;
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
            ...parent::toArray(),

            'name' => $this->name,
            'legacyId' => $this->legacyId,
            'banner' => $this->banner,
            'location' => $this->location,
            'concentrations' => $this->concentrations,
            'concentrationsHTML' => $this->concentrationsHTML,
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
            'PGWPEligible' => $this->PGWPEligible,
            'entryTerms' => $this->entryTerms,
            'deadline' => $this->deadline,
            'deadlineTable' => $this->deadlineTable,
            'deadlineOverview' => $this->deadlineOverview,
            'applyNowLink' => $this->applyNowLink,
            'curriculumLink' => $this->curriculumLink,
            'requirements' => $this->requirements,
            'tuitionCalculator' => $this->tuitionCalculator,
            'tuition' => $this->tuition,
            'programFees' => $this->programFees,
            'averageAid' => $this->averageAid,
            'percentReceivingAid' => $this->percentReceivingAid,
            'accreditation' => $this->accreditation,
            'accreditationDescriptionOverride' => $this->accreditationDescriptionOverride,
        ];
    }
}