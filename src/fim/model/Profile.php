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
        
        $this->links = collect($item->links)->map(function($link) {
            return new Link($link);
        });
        
        $this->articles = collect($item->articles)->map(function($article) {
            return new Link($article);
        });
        
        $this->labWebsites = collect($item->labWebsites)->map(function($labWebsite) {
            return new Link($labWebsite);
        });

        // Not yet available in FIM.
        // $this->programs = collect($item->program)->map(function($program) {
        //     return new Program($program);
        // });

        $this->portrait = !is_null($item->portrait) ? [
            'id' => $item->portrait->getId(),
            'title' => $item->portrait->getTitle(),
            'description' => $item->portrait->getDescription(),
            'file' => $item->portrait->getFile(),
            'createdAt' => $item->portrait->getSystemProperties()->getCreatedAt(),
            'updatedAt' => $item->portrait->getSystemProperties()->getUpdatedAt(),
            'revision' => $item->portrait->getSystemProperties()->getRevision(),
        ] : null;;
    }

    public function toArray() {
        return [
            ...parent::toArray(),
 
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
        ];
    }
}