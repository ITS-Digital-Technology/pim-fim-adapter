<?php

namespace Northeastern\PIMFIMAdapter;

abstract class AdapterConfig {

    public string $space_id;
    public string $access_token;
    public string $preview_access_token;
    public string $environment_id;

    public function __construct() {
        $this->space_id = $this->getSpaceId();
        $this->access_token = $this->getAccessToken();
        $this->preview_access_token = $this->getPreviewAccessToken();
        $this->environment_id = $this->getEnvironmentId();

        return [
            'space_id' => $this->space_id,
            'access_token' => $this->access_token,
            'preview_access_token' => $this->preview_access_token,
            'environment_id' => $this->environment_id
        ];
    }

    public function getSpaceId() {}

    public function getAccessToken() {}

    public function getPreviewAccessToken() {}

    public function getEnvironmentId() {}
}