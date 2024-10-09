<?php

namespace Northeastern\PIMFIMAdapter\Concerns;

use Contentful\RichText\Renderer;

trait RendersRichText 
{
    public function renderRichTextNodes($nodes)
    {
        if (! $nodes) {
            return '';
        }

        $renderer = new Renderer();

        return collect($nodes->getContent())
            ->reduce(function ($carry, $node) use ($renderer) {
                return $carry . $renderer->render($node);
            }, '');
    }
}