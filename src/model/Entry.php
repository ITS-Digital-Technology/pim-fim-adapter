<?php

namespace Northeastern\PIMFIMAdapter\Model;

class Entry {
    protected $id;
    protected $createdAt;
    protected $updatedAt;
    protected $revision;

    public function __construct($item)
    {
        $this->id = $item->getId();
        $this->createdAt = $item->getCreatedAt();
        $this->updatedAt = $item->getUpdatedAt();
        $this->revision = $item->getRevision();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'revision' => $this->revision,
        ];
    }
}