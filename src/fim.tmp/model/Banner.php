<?php
namespace Northeastern\PIMFIMAdapter\FIM\Model;

use Northeastern\PIMFIMAdapter\Model\Entry;
use Contentful\Delivery\Resource\Entry as ResourceEntry;

class Banner extends Entry {
    protected $bannerId;

    protected $displayNameInternal;

    protected $firstName;
    protected $lastName;
    protected $prefix;
    
    protected $email;

    protected $employmentType;

    protected $academicTitle;

    protected $division;
    protected $departmentAffiliation;
    protected $collegeAffiliation;
    
    protected $maildrop;
    protected $city;
    protected $postalCode;

    protected array $degrees;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());

        $this->bannerId = $item->bannerId;
        $this->displayNameInternal = $item->displayNameInternal;
        $this->firstName = $item->firstName;
        $this->lastName = $item->lastName;
        $this->prefix = $item->prefix;
        $this->email = $item->email;
        $this->employmentType = $item->employmentType;
        $this->academicTitle = $item->academicTitle;
        $this->division = $item->division;
        $this->departmentAffiliation = $item->departmentAffiliation;
        $this->collegeAffiliation = $item->collegeAffiliation;
        $this->maildrop = $item->maildrop;
        $this->city = $item->city;
        $this->postalCode = $item->postalCode;
        $this->degrees = $item->degrees;
    }

    public function toArray() {
        return [
            ...parent::toArray(),

            'bannerId' => $this->bannerId,
            'displayNameInternal' => $this->displayNameInternal,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'prefix' => $this->prefix,
            'email' => $this->email,
            'employmentType' => $this->employmentType,
            'academicTitle' => $this->academicTitle,
            'division' => $this->division,
            'departmentAffiliation' => $this->departmentAffiliation,
            'collegeAffiliation' => $this->collegeAffiliation,
            'maildrop' => $this->maildrop,
            'city' => $this->city,
            'postalCode' => $this->postalCode,
            'degrees' => $this->degrees,
        ];
    }
}