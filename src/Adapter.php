<?php

namespace NortheasternWeb\PIMFIMAdapter;

use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\AdapterConfig;
use Contentful\Delivery\ClientOptions;

abstract class Adapter {
    private AdapterConfig $config;
    private ContentfulAdapter $adapter;

    public function __construct(
        AdapterConfig $config,
        ClientOptions $client_options = null
    ) {
        $this->config = $config;

        extract((array) $this->config);

        $this->adapter = new ContentfulAdapter(
            $access_token, 
            $space_id, 
            $environment_id, 
            $client_options
        );

        return $this->adapter;
    }
}