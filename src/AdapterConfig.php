<?php

namespace Northeastern\PIMFIMAdapter;

abstract class AdapterConfig {

    public string $space_id;
    public string $access_token;
    public string $environment_id;
    public bool $preview_mode;

    public function __construct() {
        $this->space_id = $this->getSpaceId();
        $this->access_token = $this->getAccessToken();
        $this->environment_id = $this->getEnvironmentId();
        $this->preview_mode = $this->getPreviewMode();

        return [
            'space_id' => $this->space_id,
            'access_token' => $this->access_token,
            'environment_id' => $this->environment_id,
            'preview_mode' => $this->preview_mode
        ];
    }

    public function getSpaceId() {}

    public function getAccessToken() {}

    public function getEnvironmentId() {}

    public function getPreviewMode() {}
}