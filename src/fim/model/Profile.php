<?php
namespace NortheasternWeb\PIMFIMAdapter\FIM\Model;

use NortheasternWeb\PIMFIMAdapter\Model\Entry;
use Contentful\Delivery\Resource\Entry as ResourceEntry;
use NortheasternWeb\PIMFIMAdapter\Concerns\RendersRichText;

class Profile extends Entry {
    use RendersRichText;

    protected $displayNameInternal;
    
    protected int $legacyId;
    
    protected $banner;
    
    protected $shortDescription;
    protected $academicTitleOverride;
    
    protected $biography;
    protected $accomplishments;
    
    protected $resume;
    
    protected array $areasOfExpertise;
    protected array $trainingCertificates; 
    
    protected $links;
    protected $articles;
    protected $labWebsites;
    
    protected $programs;

    protected $portrait;

    public function __construct(ResourceEntry $item)
    {
        parent::__construct($item->getSystemProperties());

        $this->displayNameInternal = $item->displayNameInternal;
        $this->legacyId = $item->legacyId;
        $this->banner = new Banner($item->banner);
        $this->shortDescription = $item->shortDescription;
        $this->academicTitleOverride = $item->academicTitleOverride;
        $this->biography = $this->renderRichTextNodes($item->biography);
        $this->accomplishments = $this->renderRichTextNodes($item->accomplishments);
        $this->resume = $item->resume;
        $this->areasOfExpertise = $item->areasOfExpertise;
        $this->trainingCertificates = $item->trainingCertificates;
        $this->links = $item->links;
        $this->articles = $item->articles;
        $this->labWebsites = $item->labWebsites;
        $this->programs = $item->programs;
        $this->portrait = $item->portrait;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'displayNameInternal' => $this->displayNameInternal,
            'legacyId' => $this->legacyId,
            'banner' => $this->banner,
            'shortDescription' => $this->shortDescription,
            'academicTitleOverride' => $this->academicTitleOverride,
            'biography' => $this->biography,
            'accomplishments' => $this->accomplishments,
            'resume' => $this->resume,
            'areasOfExpertise' => $this->areasOfExpertise,
            'trainingCertificates' => $this->trainingCertificates,
            'links' => $this->links,
            'articles' => $this->articles,
            'labWebsites' => $this->labWebsites,
            'programs' => $this->programs,
            'portrait' => $this->portrait,

            ...parent::toArray()
        ];
    }
}