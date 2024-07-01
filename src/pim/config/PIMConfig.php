<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Config;

use NortheasternWeb\PIMFIMAdapter\AdapterConfig;

class PIMConfig extends AdapterConfig {
    public function __construct() {
        parent::__construct();
    }

    public function getSpaceId() {
        $space_id = $_ENV['PIM_SPACE_ID'];

        return $space_id;
    }

    public function getAccessToken() {        
        $access_token = $_ENV['PIM_ACCESS_TOKEN']; 
        
        return $access_token;
    }

    public function getEnvironmentId() {
        $environment_id = $_ENV['PIM_ENVIRONMENT_ID'];

        return $environment_id;
    }
}