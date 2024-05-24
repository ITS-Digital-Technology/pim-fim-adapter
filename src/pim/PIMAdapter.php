<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM;

use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\PIM\Config\PIMConfig;
use Contentful\Delivery\ClientOptions;

class PIMAdapter {
    private array $config;

    function __construct(
        ClientOptions $client_options,
        PIMConfig $config
    ) {
        (array) $this->config = $config;

        extract($this->config);

        $adapter = new ContentfulAdapter($access_token, $space_id, $environment_id, $client_options);
    }
}