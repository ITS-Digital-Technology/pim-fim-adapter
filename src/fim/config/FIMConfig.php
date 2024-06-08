<?php

namespace NortheasternWeb\PIMFIMAdapter\FIM\Config;

use NortheasternWeb\PIMFIMAdapter\AdapterConfig;

class FIMConfig extends AdapterConfig {
    public string $space_id;
    public string $access_token;
    public string $environment_id;

    public function __construct() {
        parent::__construct();
    }

    public function getSpaceId() {
        $space_id = $_ENV['FIM_SPACE_ID'];

        return $space_id;
    }

    public function getAccessToken() {        
        $access_token = $_ENV['FIM_ACCESS_TOKEN']; 
        
        return $access_token;
    }

    public function getEnvironmentId() {
        $environment_id = $_ENV['FIM_ENVIRONMENT_ID'];

        return $environment_id;
    }
}