<?php

namespace NortheasternWeb\PIMFIMAdapter\FIM;

use NortheasternWeb\PIMFIMAdapter\FIM\Config\FIMConfig;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use Contentful\Delivery\ClientOptions;

class FIMAdapter {
    private array $config;

    function __construct(
        ClientOptions $client_options,
        FIMConfig $config
    ) {
        (array) $this->config = $config;

        extract($this->config);

        $adapter = new ContentfulAdapter($access_token, $space_id, $environment_id, $client_options);
    }
}