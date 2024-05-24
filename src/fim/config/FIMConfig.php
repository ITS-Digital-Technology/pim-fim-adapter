<?php

namespace NortheasternWeb\PIMFIMAdapter\FIM\Config;

use Dotenv\Dotenv;

class FIMConfig {
    private string $access_token;
    private string $space_id;
    private string $environment_id;

    function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $this->access_token = !defined('FIM_ACCESS_TOKEN') 
            ?? define('FIM_ACCESS_TOKEN', (
                function_exists('getenv') 
                    ? getenv('FIM_ACCESS_TOKEN', '') 
                    : ''
            )
        );

        $this->space_id = !defined('FIM_SPACE_ID') 
            ?? define('FIM_SPACE_ID', (
                function_exists('getenv') 
                    ? getenv('FIM_SPACE_ID', '') 
                    : ''
            )
        );

        $this->environment_id = !defined('FIM_ENVIRONMENT_ID') 
            ?? define('FIM_ENVIRONMENT_ID', (
                function_exists('getenv') 
                    ? getenv('FIM_ENVIRONMENT_ID') 
                    : 'dev'
            )
        );

        return [
            'fim_access_token' => $this->access_token,
            'fim_space_id' => $this->space_id,
            'fim_environment_id' => $this->environment_id
        ];
    }
}