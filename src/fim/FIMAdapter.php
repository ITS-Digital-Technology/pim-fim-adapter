<?php

namespace NortheasternWeb\PIMFIMAdapter\FIM;

use NortheasternWeb\PIMFIMAdapter\FIM\Config\FIMConfig;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\Adapter;
use Contentful\Delivery\ClientOptions;

class FIMAdapter extends Adapter {
    private FIMConfig $config;
    private ContentfulAdapter $adapter;

    function __construct(
        ?ClientOptions $client_options = null
    ) {
        $this->config = new FIMConfig();

        return $this->adapter = parent::__construct($this->config, $client_options);
    }
}