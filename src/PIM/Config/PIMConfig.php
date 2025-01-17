<?php

namespace Northeastern\PIMFIMAdapter\PIM\Config;

use Northeastern\PIMFIMAdapter\AdapterConfig;

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

    public function getPreviewAccessToken() {        
        if(array_key_exists('PIM_PREVIEW_ACCESS_TOKEN',$_ENV)){
            $access_token = $_ENV['PIM_PREVIEW_ACCESS_TOKEN'];
        } else {
            $access_token = $_ENV['PIM_ACCESS_TOKEN']; 
        }
        return $access_token;
    }

    public function getEnvironmentId() {
        $environment_id = $_ENV['PIM_ENVIRONMENT_ID'];

        return $environment_id;
    }
}