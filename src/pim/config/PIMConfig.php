<?php

namespace NortheasternWeb\PIMFIMAdapter\PIM\Config;

use Dotenv\Dotenv;

class PIMConfig {
    private string $access_token;
    private string $space_id;
    private string $environment_id;

    function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        
        $this->access_token = !defined('PIM_ACCESS_TOKEN') 
            ?? define('PIM_ACCESS_TOKEN', (
                function_exists('getenv') 
                    ? getenv('PIM_ACCESS_TOKEN', '') 
                    : ''
            )
        );

        $this->space_id = !defined('PIM_SPACE_ID') 
            ?? define('PIM_SPACE_ID', (
                function_exists('getenv') 
                    ? getenv('PIM_SPACE_ID', '') 
                    : ''
            )
        );

        $this->environment_id = !defined('PIM_ENVIRONMENT_ID') 
            ?? define('PIM_ENVIRONMENT_ID', (
                function_exists('getenv') 
                    ? getenv('PIM_ENVIRONMENT_ID') 
                    : 'dev'
            )
        );

        return [
            'pim_access_token' => $this->access_token,
            'pim_space_id' => $this->space_id,
            'pim_environment_id' => $this->environment_id
        ];
    }
}