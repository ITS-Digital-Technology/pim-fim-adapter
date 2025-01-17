<?php

namespace Northeastern\PIMFIMAdapter;

use Northeastern\PIMFIMAdapter\ContentfulAdapter;
use Northeastern\PIMFIMAdapter\AdapterConfig;
use Contentful\Delivery\ClientOptions;

abstract class Adapter {
    private AdapterConfig $config;
    private ContentfulAdapter $adapter;

    public function __construct(
        AdapterConfig $config,
        ClientOptions $client_options = null,
        bool $preview_mode = false
    ) {
        $this->config = $config;

        extract((array) $this->config);

        $this->adapter = new ContentfulAdapter(
            $access_token, 
            $space_id, 
            $environment_id, 
            $preview_mode,
            $client_options
        );

        return $this->adapter;
    }
}